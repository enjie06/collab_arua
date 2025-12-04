<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RDFParser;
use App\Helpers\TypoCorrector;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Enhanced search dengan semua fitur baru
     */
    private function enhancedSearch($data, $keyword, $category = null, $type = null)
    {
        $originalKeyword = $keyword;
        
        // 1. Deteksi "wisata sekitar [lokasi]"
        $nearbySearch = TypoCorrector::detectNearbySearch($keyword);
        
        if ($nearbySearch) {
            // User mencari "wisata sekitar [lokasi]"
            $location = $nearbySearch['correctedLocation'];
            
            // Cari wisata berdasarkan lokasi
            $results = array_filter($data, function($item) use ($location) {
                $itemKota = strtolower(trim($item['kotaKabupaten'] ?? $item['kota'] ?? ''));
                $itemProvinsi = strtolower(trim($item['provinsi'] ?? ''));
                $itemNama = strtolower(trim($item['nama'] ?? $item['label'] ?? ''));
                $itemAlamat = strtolower(trim($item['alamat'] ?? ''));
                $itemDekatDengan = strtolower(trim($item['dekatDengan'] ?? ''));
                
                // Cari di berbagai field lokasi
                return str_contains($itemKota, $location) ||
                       str_contains($itemProvinsi, $location) ||
                       str_contains($itemNama, $location) ||
                       str_contains($itemAlamat, $location) ||
                       str_contains($itemDekatDengan, $location);
            });
            
            return [
                'data' => array_values($results),
                'originalKeyword' => $originalKeyword,
                'correctedKeyword' => $location,
                'isCorrected' => $location !== $nearbySearch['location'],
                'searchType' => 'nearby',
                'nearbyLocation' => $location
            ];
        }
        
        // 2. Jika bukan "wisata sekitar", gunakan fuzzy search biasa
        return $this->fuzzySearch($data, $keyword, $category, $type);
    }
    
    /**
     * Fuzzy search dengan toleransi typo
     */
    private function fuzzySearch($data, $keyword, $category = null, $type = null)
    {
        $originalKeyword = $keyword;
        $correctedKeyword = TypoCorrector::correct($keyword);
        
        \Log::info("Fuzzy Search: '$originalKeyword' -> '$correctedKeyword'");
        
        $filtered = $data;
        
        if (!empty($correctedKeyword)) {
            $keywordLower = strtolower(trim($correctedKeyword));
            
            // Daftar KATEGORI yang valid
            $validCategories = [
                'pantai', 'danau', 'gunung', 'bukit', 'sungai', 'air terjun',
                'pulau', 'religi', 'budaya', 'alam', 'medan', 'masjid',
                'gereja', 'kuil', 'pura', 'museum', 'kampung adat', 'desa wisata',
                'istana', 'taman', 'salib', 'air panas', 'goa', 'hutan', 
                'kolam', 'pemandian', 'monumen', 'candi', 'vihara'
            ];

            // Cek jenis search
            $isCategorySearch = in_array($keywordLower, $validCategories);
            $isDaySearch = TypoCorrector::isDayKeyword($keywordLower);
            $isJenisSearch = in_array($keywordLower, ['alam', 'budaya', 'religi', 'sejarah', 'kuliner', 'edukasi']);
            $isHargaSearch = TypoCorrector::isHargaKeyword($keywordLower);

            $filtered = array_filter($filtered, function($item) use ($keywordLower, $isCategorySearch, $isDaySearch, $isJenisSearch, $isHargaSearch) {
                // Ambil data
                $itemKategori = strtolower(trim($item['kategori'] ?? ''));
                $itemJenis = strtolower(trim($item['jenisWisata'] ?? ''));
                $itemNama = strtolower(trim($item['nama'] ?? $item['label'] ?? ''));
                $itemHariBuka = strtolower(trim($item['hariBuka'] ?? ''));
                $itemAlamat = strtolower(trim($item['alamat'] ?? ''));
                $itemKota = strtolower(trim($item['kotaKabupaten'] ?? $item['kota'] ?? ''));
                $itemProvinsi = strtolower(trim($item['provinsi'] ?? ''));
                $itemHarga = strtolower(trim($item['hargaTiket'] ?? $item['harga'] ?? $item['tiket'] ?? ''));
                $itemAktivitas = strtolower(trim($item['aktivitas'] ?? ''));
                $itemFasilitas = strtolower(trim($item['fasilitas'] ?? ''));
                $itemJamBuka = strtolower(trim($item['jamBuka'] ?? ''));
                $itemJamTutup = strtolower(trim($item['jamTutup'] ?? ''));
                $itemDekatDengan = strtolower(trim($item['dekatDengan'] ?? ''));
                
                // 1. SEARCH BERDASARKAN KATEGORI
                if ($isCategorySearch) {
                    return str_contains($itemKategori, $keywordLower) || 
                           str_contains($itemJenis, $keywordLower) ||
                           str_contains($itemNama, $keywordLower);
                }
                
                // 2. SEARCH BERDASARKAN HARI BUKA
                if ($isDaySearch) {
                    return str_contains($itemHariBuka, $keywordLower) ||
                           str_contains($itemJamBuka, $keywordLower) ||
                           str_contains($itemJamTutup, $keywordLower);
                }
                
                // 3. SEARCH BERDASARKAN JENIS WISATA
                if ($isJenisSearch) {
                    return str_contains($itemJenis, $keywordLower) ||
                           str_contains($itemKategori, $keywordLower);
                }
                
                // 4. SEARCH BERDASARKAN HARGA TIKET
                if ($isHargaSearch) {
                    return str_contains($itemHarga, $keywordLower);
                }
                
                // 5. SEARCH UMUM (cari di semua field)
                $searchFields = [
                    'nama' => $itemNama,
                    'kategori' => $itemKategori,
                    'jenis' => $itemJenis,
                    'alamat' => $itemAlamat,
                    'kota' => $itemKota,
                    'provinsi' => $itemProvinsi,
                    'hari_buka' => $itemHariBuka,
                    'jam_buka' => $itemJamBuka,
                    'jam_tutup' => $itemJamTutup,
                    'harga' => $itemHarga,
                    'aktivitas' => $itemAktivitas,
                    'fasilitas' => $itemFasilitas,
                    'dekat_dengan' => $itemDekatDengan,
                ];
                
                foreach ($searchFields as $fieldValue) {
                    if (str_contains($fieldValue, $keywordLower)) {
                        return true;
                    }
                }
                
                return false;
            });
        }
        
        // Filter tambahan untuk parameter category dan type
        if (!empty($category)) {
            $categoryLower = strtolower(trim($category));
            $filtered = array_filter($filtered, function($item) use ($categoryLower) {
                $itemKategori = strtolower(trim($item['kategori'] ?? ''));
                return str_contains($itemKategori, $categoryLower);
            });
        }
        
        if (!empty($type)) {
            $typeLower = strtolower(trim($type));
            $filtered = array_filter($filtered, function($item) use ($typeLower) {
                $itemType = strtolower(trim($item['jenisWisata'] ?? ''));
                return str_contains($itemType, $typeLower);
            });
        }
        
        return [
            'data' => array_values($filtered),
            'originalKeyword' => $originalKeyword,
            'correctedKeyword' => $correctedKeyword,
            'isCorrected' => $correctedKeyword !== $originalKeyword,
            'searchType' => 'regular'
        ];
    }
    
    public function search(Request $request)
    {
        $allData = $this->loadAllRDFData();
        
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        // Gunakan ENHANCED search (dengan nearby detection)
        $searchResult = $this->enhancedSearch($allData, $keyword, $category, $type);
        
        $filteredData = $searchResult['data'];
        $isCorrected = $searchResult['isCorrected'] ?? false;
        $correctedKeyword = $searchResult['correctedKeyword'] ?? $keyword;
        $originalKeyword = $searchResult['originalKeyword'] ?? $keyword;
        $searchType = $searchResult['searchType'] ?? 'regular';
        $nearbyLocation = $searchResult['nearbyLocation'] ?? null;
        
        // Log untuk debugging
        \Log::info("Search - Original: '$originalKeyword', Corrected: '$correctedKeyword', Type: $searchType");
        
        $formattedResults = $this->formatForView($filteredData);
        
        $wisataAlam = array_filter($formattedResults, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'alam' || $jenis === 'wisata alam';
        });
        
        $wisataBudaya = array_filter($formattedResults, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'budaya' || $jenis === 'wisata budaya';
        });
        
        $wisataReligi = array_filter($formattedResults, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'religi' || $jenis === 'wisata religi';
        });
        
        $wisataAlam = array_values($wisataAlam);
        $wisataBudaya = array_values($wisataBudaya);
        $wisataReligi = array_values($wisataReligi);

        return view('search.results', [
            'results' => $formattedResults,
            'wisataAlam' => $wisataAlam,    
            'wisataBudaya' => $wisataBudaya, 
            'wisataReligi' => $wisataReligi, 
            'keyword' => $originalKeyword,
            'correctedKeyword' => $isCorrected ? $correctedKeyword : null,
            'isCorrected' => $isCorrected,
            'searchType' => $searchType,
            'nearbyLocation' => $nearbyLocation,
            'selectedCategory' => $category,
            'selectedType' => $type,
            'total' => count($formattedResults)
        ]);
    }
    
    private function loadAllRDFData()
    {
        $allData = [];
        
        $rdfFiles = [
            'wisata_alam_1' => public_path('data/wisata_alam_1.xml'),
            'wisata_alam_2' => public_path('data/wisata_alam_2.xml'),
            'wisata_religi' => public_path('data/wisata_religi.xml'),
            'wisata_budaya' => public_path('data/wisata_budaya.xml'),
        ];
        
        foreach ($rdfFiles as $name => $file) {
            if (file_exists($file)) {
                try {
                    $data = RDFParser::parse($file);
                    $allData = array_merge($allData, $data);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        
        return $allData;
    }
    
    // Method lama untuk compatibility
    private function filterData($data, $keyword, $category, $type)
    {
        return $this->fuzzySearch($data, $keyword, $category, $type)['data'];
    }
    
    private function formatForView($data)
    {
        return array_map(function($item) {
            return [
                'nama' => $item['nama'] ?? $item['label'] ?? 'Tanpa Nama',
                'gambar' => $item['gambar'] ?? $item['image'] ?? '',
                'kategori' => $item['kategori'] ?? $item['category'] ?? $item['jenisWisata'] ?? 'Umum',
                'alamat' => $item['alamat'] ?? $item['address'] ?? '',
                'kota' => $item['kotaKabupaten'] ?? $item['kota'] ?? $item['city'] ?? '',
                'provinsi' => $item['provinsi'] ?? $item['province'] ?? 'Sumatera Utara',
                'latitude' => $item['latitude'] ?? $item['lat'] ?? '',
                'longitude' => $item['longitude'] ?? $item['long'] ?? $item['lng'] ?? '',
                'harga_tiket' => $item['hargaTiket'] ?? $item['harga'] ?? $item['tiket'] ?? 'Gratis',
                'hari_buka' => $item['hariBuka'] ?? $item['hari'] ?? 'Setiap Hari',
                'jam_buka' => $item['jamBuka'] ?? $item['jamBuka'] ?? '08:00',
                'jam_tutup' => $item['jamTutup'] ?? $item['jamTutup'] ?? '17:00',
                'dekat_dengan' => $item['dekatDengan'] ?? $item['dekat'] ?? '',
                'fasilitas' => $item['fasilitas'] ?? $item['facilities'] ?? '',
                'aktivitas' => $item['aktivitas'] ?? $item['activities'] ?? '',
                'agama_terkait' => $item['agamaTerkait'] ?? $item['agama'] ?? '',
                'tokoh_terkait' => $item['tokohTerkait'] ?? $item['tokoh'] ?? '',
                'jenisWisata' => $item['jenisWisata'] ?? $item['type'] ?? $item['kategori'] ?? 'Umum',
            ];
        }, $data);
    }
    
    private function getAllCategories($data)
    {
        $categories = [];
        foreach ($data as $item) {
            $cat = $item['kategori'] ?? $item['category'] ?? null;
            if ($cat && !in_array($cat, $categories)) {
                $categories[] = $cat;
            }
        }
        sort($categories);
        return $categories;
    }
    
    private function getAllTypes($data)
    {
        $types = [];
        foreach ($data as $item) {
            $type = $item['jenisWisata'] ?? $item['type'] ?? null;
            if ($type && !in_array($type, $types)) {
                $types[] = $type;
            }
        }
        sort($types);
        return $types;
    }
    
    public function byCategory($category)
    {
        $allData = $this->loadAllRDFData();
        $filteredData = $this->filterData($allData, null, $category, null);
        $formattedResults = $this->formatForView($filteredData);
        
        return view('search.category', [
            'results' => $formattedResults,
            'category' => $category,
            'total' => count($formattedResults)
        ]);
    }
    
    public function allWisata()
    {
        $allData = $this->loadAllRDFData();
        $formattedResults = $this->formatForView($allData);
        
        return view('search.all', [
            'results' => $formattedResults,
            'total' => count($formattedResults)
        ]);
    }
}