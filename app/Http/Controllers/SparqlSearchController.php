<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SparqlSearchService;
use App\Helpers\TypoCorrector;

class SparqlSearchController extends Controller
{
    protected $sparqlService;
    
    public function __construct(SparqlSearchService $sparqlService)
    {
        $this->sparqlService = $sparqlService;
    }
    
    /**
     * Enhanced search dengan semua fitur baru untuk SPARQL
     */
    private function enhancedSearch($keyword, $category = null, $type = null)
    {
        $originalKeyword = $keyword;
        
        // 1. Deteksi "wisata sekitar [lokasi]"
        $nearbySearch = TypoCorrector::detectNearbySearch($keyword);
        
        if ($nearbySearch) {
            // User mencari "wisata sekitar [lokasi]"
            $location = $nearbySearch['correctedLocation'];
            
            // Search dengan SPARQL untuk lokasi tertentu
            $results = $this->sparqlService->searchByLocation($location);
            
            return [
                'data' => $results,
                'originalKeyword' => $originalKeyword,
                'correctedKeyword' => $location,
                'isCorrected' => $location !== $nearbySearch['location'],
                'searchType' => 'nearby',
                'nearbyLocation' => $location
            ];
        }
        
        // 2. Jika bukan "wisata sekitar", gunakan search biasa dengan typo correction
        $correctedKeyword = TypoCorrector::correct($keyword);
        $isCorrected = $correctedKeyword !== $originalKeyword;
        
        // 3. Gunakan SPARQL service dengan keyword yang sudah dikoreksi
        $results = $this->sparqlService->search($correctedKeyword, $category, $type);
        
        return [
            'data' => $results,
            'originalKeyword' => $originalKeyword,
            'correctedKeyword' => $correctedKeyword,
            'isCorrected' => $isCorrected,
            'searchType' => 'regular'
        ];
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        // Gunakan ENHANCED search (dengan nearby detection & typo correction)
        $searchResult = $this->enhancedSearch($keyword, $category, $type);
        
        $results = $searchResult['data'];
        $isCorrected = $searchResult['isCorrected'] ?? false;
        $correctedKeyword = $searchResult['correctedKeyword'] ?? $keyword;
        $originalKeyword = $searchResult['originalKeyword'] ?? $keyword;
        $searchType = $searchResult['searchType'] ?? 'regular';
        $nearbyLocation = $searchResult['nearbyLocation'] ?? null;
        
        // Log untuk debugging
        \Log::info("SPARQL Search - Original: '$originalKeyword', Corrected: '$correctedKeyword', Type: $searchType");
        
        $wisataAlam = array_filter($results, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'alam' || $jenis === 'wisata alam';
        });
        
        $wisataBudaya = array_filter($results, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'budaya' || $jenis === 'wisata budaya';
        });
        
        $wisataReligi = array_filter($results, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'religi' || $jenis === 'wisata religi';
        });
        
        $wisataAlam = array_values($wisataAlam);
        $wisataBudaya = array_values($wisataBudaya);
        $wisataReligi = array_values($wisataReligi);
        
        return view('search.results', [
            'results' => $results,
            'wisataAlam' => $wisataAlam,
            'wisataBudaya' => $wisataBudaya,
            'wisataReligi' => $wisataReligi,
            'keyword' => $originalKeyword,
            'correctedKeyword' => $isCorrected ? $correctedKeyword : null,
            'isCorrected' => $isCorrected,
            'searchType' => 'sparql',
            'nearbyLocation' => $nearbyLocation,
            'selectedCategory' => $category,
            'selectedType' => $type,
            'total' => count($results),
        ]);
    }
    
    public function test()
    {
        $total = $this->sparqlService->testSparql();
        
        return response()->json([
            'status' => 'success',
            'total_data' => $total,
            'message' => 'SPARQL service is working!'
        ]);
    }
}