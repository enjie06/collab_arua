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
    
    /**
     * Koreksi typo umum dalam pencarian
     */
    private function correctTypo($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        // Mapping typo ke kata yang benar
        $typoMap = [
            // Pantai
            'pantal' => 'pantai',
            'pantay' => 'pantai',
            'pantae' => 'pantai',
            'pantao' => 'pantai',
            'pntai' => 'pantai',
            'pantaii' => 'pantai',
            'pantiai' => 'pantai',
            'panta' => 'pantai',
            
            // Danau
            'danaw' => 'danau',
            'danu' => 'danau',
            'danao' => 'danau',
            'danauu' => 'danau',
            'danou' => 'danau',
            'dana' => 'danau',
            'danua' => 'danau',
            
            // Medan
            'medn' => 'medan',
            'meden' => 'medan',
            'medaan' => 'medan',
            'meddan' => 'medan',
            'meda' => 'medan',
            
            // Religi
            'relegi' => 'religi',
            'reliji' => 'religi',
            'relige' => 'religi',
            'relegy' => 'religi',
            'relligi' => 'religi',
            'relliji' => 'religi',
            'relig' => 'religi',
            
            // Alam
            'alamm' => 'alam',
            'allam' => 'alam',
            'alaam' => 'alam',
            'allm' => 'alam',
            'alma' => 'alam',
            
            // Budaya
            'budayaa' => 'budaya',
            'budaya' => 'budaya',
            'budya' => 'budaya',
            'buday' => 'budaya',
            
            // Kata umum lainnya
            'wisataa' => 'wisata',
            'wista' => 'wisata',
            'wistata' => 'wisata',
            'sumatra' => 'sumatera',
            'sumattera' => 'sumatera',
            'tobaa' => 'toba',
            'toba' => 'toba',
        ];
        
        // 1. Cek exact match dalam typoMap
        if (isset($typoMap[$keyword])) {
            return $typoMap[$keyword];
        }
        
        // 2. Cek partial/similar match menggunakan Levenshtein distance
        $bestMatch = $keyword;
        $bestDistance = PHP_INT_MAX;
        
        foreach ($typoMap as $typo => $correct) {
            $distance = levenshtein($keyword, $typo);
            
            // Jika sangat mirip (1-2 karakter berbeda)
            if ($distance <= 2 && $distance < $bestDistance) {
                $bestDistance = $distance;
                $bestMatch = $correct;
            }
        }
        
        // 3. Jika tidak ditemukan typo, return keyword asli
        return ($bestDistance <= 2 && $bestDistance > 0) ? $bestMatch : $keyword;
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        $allData = $this->loadAllRDFData();

        if (strtolower($keyword) === 'pantai') {
        echo "<h2>DEBUG: Search 'pantai'</h2>";
        echo "<h3>Semua item dengan kategori mengandung 'pantai':</h3>";
        
        $count = 0;
        foreach ($allData as $item) {
            $kategori = strtolower($item['kategori'] ?? '');
            $nama = $item['nama'] ?? $item['label'] ?? '';
            
            if (str_contains($kategori, 'pantai')) {
                echo "<p><strong>$nama</strong> | Kategori: $kategori</p>";
                $count++;
            }
        }
        
        echo "<h3>Total item dengan kategori 'pantai': $count</h3>";
        
        echo "<h3>Item yang mengandung 'pantai' di DEKAT DENGAN:</h3>";
        foreach ($allData as $item) {
            $dekatDengan = strtolower($item['dekatDengan'] ?? '');
            $nama = $item['nama'] ?? $item['label'] ?? '';
            $kategori = $item['kategori'] ?? '';
            
            if (str_contains($dekatDengan, 'pantai')) {
                echo "<p><strong>$nama</strong> | Kategori: $kategori | Dekat Dengan: $dekatDengan</p>";
            }
        }
        
        die();
    }
        
        // Koreksi typo
        $originalKeyword = $keyword;
        $correctedKeyword = $this->correctTypo($keyword);
        $isCorrected = $correctedKeyword !== $originalKeyword;
        
        // Gunakan keyword yang sudah dikoreksi untuk search SPARQL
        $results = $this->sparqlService->search($correctedKeyword, $category, $type);
        
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