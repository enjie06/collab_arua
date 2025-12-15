<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FusekiService;
use App\Services\FuzzySearchService;

class SearchController extends Controller
{
    protected $fusekiService;
    protected $fuzzySearchService;
    
    public function __construct(FusekiService $fusekiService, FuzzySearchService $fuzzySearchService)
    {
        $this->fusekiService = $fusekiService;
        $this->fuzzySearchService = $fuzzySearchService;
    }
    
    /**
     * Halaman /search - Hasil pencarian dengan typo correction
     */
    public function search(Request $request)
    {
        $originalKeyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        // Jika keyword kosong, redirect ke halaman wisata
        if (empty($originalKeyword)) {
            return redirect()->route('wisata');
        }
        
        // Normalize keyword
        $keyword = $this->fuzzySearchService->normalizeKeyword($originalKeyword);
        
        // Cek apakah ini pencarian "wisata sekitar"
        $sekitarDetection = $this->fuzzySearchService->detectWisataSekitar($keyword);
        $isWisataSekitar = $sekitarDetection['isWisataSekitar'];
        $location = $sekitarDetection['location'];
        
        // Search wisata dari Fuseki dengan keyword original
        $allResults = $this->fusekiService->searchWisata($keyword);
        
        // Extract keywords dari hasil untuk learning
        $learnedKeywords = [];
        if (!empty($allResults)) {
            $learnedKeywords = $this->fuzzySearchService->extractKeywordsFromData($allResults);
        }
        
        // Cek typo dan cari koreksi
        $correction = null;
        $correctedKeyword = null;
        $suggestions = [];
        $isCorrected = false;
        $correctionType = null;
        
        if (empty($allResults)) {
            // Tidak ada hasil, coba koreksi typo
            if ($isWisataSekitar) {
                // Untuk "wisata sekitar", koreksi lokasi-nya
                $correction = $this->fuzzySearchService->findClosestMatch($location, $learnedKeywords);
                
                if ($correction['needsCorrection']) {
                    $correctedLocation = $correction['corrected'];
                    $correctedKeyword = "wisata sekitar " . $correctedLocation;
                    $keyword = $correctedLocation;
                    $allResults = $this->fusekiService->searchWisata($correctedLocation);
                    $isCorrected = true;
                    $correctionType = "Koreksi lokasi";
                    $suggestions = $correction['suggestions'];
                    $location = $correctedLocation;
                }
            } else {
                // Pencarian normal, koreksi keyword
                $correction = $this->fuzzySearchService->findClosestMatch($keyword, $learnedKeywords);
                
                if ($correction['needsCorrection']) {
                    $correctedKeyword = $correction['corrected'];
                    $keyword = $correctedKeyword;
                    $allResults = $this->fusekiService->searchWisata($correctedKeyword);
                    $isCorrected = true;
                    $correctionType = "Koreksi ejaan";
                    $suggestions = $correction['suggestions'];
                }
            }
        } else if ($isWisataSekitar) {
            // Ada hasil untuk "wisata sekitar", tapi tetap coba cari alternatif lokasi
            $correction = $this->fuzzySearchService->findClosestMatch($location, $learnedKeywords);
            $suggestions = $correction['suggestions'] ?? [];
        }
        
        // Cek filter harga
        $priceFilter = $this->fuzzySearchService->detectPriceFilter($originalKeyword);
        
        // Filter tambahan
        $filteredResults = $allResults;
        
        // Filter by category
        if (!empty($category)) {
            $categoryLower = strtolower($category);
            $filteredResults = array_filter($filteredResults, function($wisata) use ($categoryLower) {
                $jenis = strtolower($wisata['jenisWisata'] ?? '');
                return str_contains($jenis, $categoryLower);
            });
        }
        
        // Filter by type
        if (!empty($type)) {
            $typeLower = strtolower($type);
            $filteredResults = array_filter($filteredResults, function($wisata) use ($typeLower) {
                $kategori = strtolower($wisata['kategori'] ?? '');
                return str_contains($kategori, $typeLower);
            });
        }
        
        // Filter by price
        if ($priceFilter['hasFilter']) {
            $filteredResults = array_filter($filteredResults, function($wisata) use ($priceFilter) {
                $harga = strtolower($wisata['hargaTiket'] ?? $wisata['harga_tiket'] ?? '');
                
                switch ($priceFilter['type']) {
                    case 'gratis':
                        return str_contains($harga, 'gratis') || 
                               str_contains($harga, 'free') || 
                               str_contains($harga, 'rp 0') ||
                               str_contains($harga, 'rp0');
                    case 'murah':
                        // Harga < 50.000
                        preg_match('/\d+/', str_replace(['.', ',', 'rp', ' '], '', $harga), $matches);
                        $price = isset($matches[0]) ? (int)$matches[0] : 0;
                        return $price > 0 && $price < 50000;
                    case 'mahal':
                        // Harga > 100.000
                        preg_match('/\d+/', str_replace(['.', ',', 'rp', ' '], '', $harga), $matches);
                        $price = isset($matches[0]) ? (int)$matches[0] : 0;
                        return $price >= 100000;
                }
                
                return true;
            });
        }
        
        // Kelompokkan hasil untuk view
        $wisataAlam = [];
        $wisataBudaya = [];
        $wisataReligi = [];
        
        foreach ($filteredResults as $wisata) {
            $jenis = strtolower($wisata['jenisWisata'] ?? '');
            
            if (str_contains($jenis, 'alam')) {
                $wisataAlam[] = $wisata;
            } elseif (str_contains($jenis, 'budaya')) {
                $wisataBudaya[] = $wisata;
            } elseif (str_contains($jenis, 'religi')) {
                $wisataReligi[] = $wisata;
            }
        }
        
        return view('search.results', [
            'results' => $filteredResults,
            'wisataAlam' => $wisataAlam,
            'wisataBudaya' => $wisataBudaya,
            'wisataReligi' => $wisataReligi,
            'keyword' => $originalKeyword,
            'correctedKeyword' => $correctedKeyword,
            'isCorrected' => $isCorrected,
            'correctionType' => $correctionType,
            'suggestions' => $suggestions,
            'isWisataSekitar' => $isWisataSekitar,
            'originalLocation' => $location,
            'total' => count($filteredResults),
            'selectedCategory' => $category,
            'selectedType' => $type,
            'searchType' => 'sparql'
        ]);
    }
}