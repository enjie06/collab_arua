<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SparqlSearchService;

class SparqlSearchController extends Controller
{
    protected $sparqlService;
    
    public function __construct(SparqlSearchService $sparqlService)
    {
        $this->sparqlService = $sparqlService;
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        $results = $this->sparqlService->search($keyword, $category, $type);
        
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
            'keyword' => $keyword,
            'selectedCategory' => $category,
            'selectedType' => $type,
            'total' => count($results),
            'searchType' => 'sparql' 
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