<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FusekiService;

class SearchController extends Controller
{
    protected $fusekiService;
    
    public function __construct(FusekiService $fusekiService)
    {
        $this->fusekiService = $fusekiService;
    }
    
    /**
     * Halaman /search - Hasil pencarian
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        // Jika keyword kosong, redirect ke halaman wisata
        if (empty($keyword)) {
            return redirect()->route('wisata');
        }
        
        // Search wisata dari Fuseki
        $allResults = $this->fusekiService->searchWisata($keyword);
        
        // Filter tambahan jika ada category atau type
        $filteredResults = $allResults;
        
        if (!empty($category)) {
            $categoryLower = strtolower($category);
            $filteredResults = array_filter($filteredResults, function($wisata) use ($categoryLower) {
                $jenis = strtolower($wisata['jenisWisata'] ?? '');
                return str_contains($jenis, $categoryLower);
            });
        }
        
        if (!empty($type)) {
            $typeLower = strtolower($type);
            $filteredResults = array_filter($filteredResults, function($wisata) use ($typeLower) {
                $kategori = strtolower($wisata['kategori'] ?? '');
                return str_contains($kategori, $typeLower);
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
            'keyword' => $keyword,
            'total' => count($filteredResults),
            'selectedCategory' => $category,
            'selectedType' => $type,
            'searchType' => 'sparql' // Tandai bahwa ini search dari SPARQL
        ]);
    }
}