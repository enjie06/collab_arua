<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RDFParser;
use Illuminate\Support\Str;

class SearchController extends Controller
{
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
            'budaya' => 'budaya', // sudah benar, tapi untuk consistency
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
    
    /**
     * Fuzzy search dengan toleransi typo
     */
    /**
 * Fuzzy search dengan toleransi typo DAN fokus pada kategori
 */
        /**
 * Fuzzy search dengan toleransi typo DAN fokus pada kategori
 */
        private function fuzzySearch($data, $keyword, $category = null, $type = null)
        {
            $originalKeyword = $keyword;
            $correctedKeyword = $this->correctTypo($keyword);
            
            \Log::info("Fuzzy Search: '$originalKeyword' -> '$correctedKeyword'");
            
            $filtered = $data;
            
            if (!empty($correctedKeyword)) {
                $keywordLower = strtolower(trim($correctedKeyword));
                
                // Daftar KATEGORI yang valid
                $validCategories = [
                    'pantai', 'danau', 'gunung', 'bukit', 'sungai', 'air terjun',
                    'pulau', 'religi', 'budaya', 'alam', 'medan', 'masjid',
                    'gereja', 'kuil', 'pura', 'museum', 'kampung adat', 'desa wisata',
                    'istana', 'taman', 'salib', 'air panas', 'goa', 'hutan', 'kolam', 'pemandian', 'monumen', 'candi'
                ];

                $validDays = [
                    'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu',
                    'setiap hari', 'setiap hari kecuali', 'hari libur', 'weekend',
                    'weekday', 'libur nasional'
                ];

                $validJenisWisata = ['alam', 'budaya', 'religi', 'sejarah', 'kuliner', 'edukasi'];
                
                $hargaKeywords = ['gratis', 'murah', 'rp', 'ribu', 'ratus', 'juta', 'free', 'tiket'];

                // Cek jenis search
                $isCategorySearch = in_array($keywordLower, $validCategories);
                $isDaySearch = in_array($keywordLower, $validDays) || $this->isDayKeyword($keywordLower);
                $isJenisSearch = in_array($keywordLower, $validJenisWisata);
                $isHargaSearch = $this->isHargaKeyword($keywordLower);

                // PERBAIKAN DI SINI: Hapus ) ekstra sebelum {
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
                    
                    // 1. SEARCH BERDASARKAN KATEGORI
                    if ($isCategorySearch) {
                        return str_contains($itemKategori, $keywordLower) || 
                            str_contains($itemJenis, $keywordLower);
                    }
                    
                    // 2. SEARCH BERDASARKAN HARI BUKA
                    if ($isDaySearch) {
                        return str_contains($itemHariBuka, $keywordLower);
                    }
                    
                    // 3. SEARCH BERDASARKAN JENIS WISATA
                    if ($isJenisSearch) {
                        return str_contains($itemJenis, $keywordLower);
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
                'isCategorySearch' => $isCategorySearch ?? false
            ];
        }
    
    public function search(Request $request)
    {
        $allData = $this->loadAllRDFData();
        
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        // Gunakan fuzzy search
        $searchResult = $this->fuzzySearch($allData, $keyword, $category, $type);
        
        $filteredData = $searchResult['data'];
        $isCorrected = $searchResult['isCorrected'];
        $correctedKeyword = $searchResult['correctedKeyword'];
        $originalKeyword = $searchResult['originalKeyword'];
        
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
            'keyword' => $originalKeyword, // Tampilkan keyword asli dari user
            'correctedKeyword' => $isCorrected ? $correctedKeyword : null,
            'isCorrected' => $isCorrected,
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

    private function isDayKeyword($keyword)
{
    $dayPatterns = [
        'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu',
        'seni', 'selas', 'sabt', 'mingg', // Typo correction
        'hari', 'buka', 'tutup', 'operasional',
        'setiap', 'kecuali', 'libur', 'weekend', 'weekday'
    ];
    
    foreach ($dayPatterns as $pattern) {
        if (str_contains($keyword, $pattern) || str_contains($pattern, $keyword)) {
            return true;
        }
    }
    
    return false;
}

private function isHargaKeyword($keyword)
{
    $hargaPatterns = [
        'gratis', 'free', 'rp', 'rupiah', 'ribu', 'ratus', 'juta',
        'tiket', 'harga', 'masuk', 'biaya', 'tarif', 'uang',
        'murah', 'mahal', 'terjangkau', 'diskon'
    ];
    
    // Juga cek jika mengandung angka (misal: 10000, 10rb, 10k)
    if (preg_match('/\d+/', $keyword)) {
        return true;
    }
    
    foreach ($hargaPatterns as $pattern) {
        if (str_contains($keyword, $pattern) || str_contains($pattern, $keyword)) {
            return true;
        }
    }
    
    return false;
}
    
    // Method filterData yang lama (untuk backup, bisa dihapus kalau sudah yakin)
    private function filterData($data, $keyword, $category, $type)
{
    $filtered = $data;
    
    if (!empty($keyword)) {
        $keywordLower = strtolower(trim($keyword));
        
        // KATEGORI yang harus exact match
        $categoryKeywords = [
            'pantai', 'danau', 'gunung', 'bukit', 'alam', 'religi', 
            'budaya', 'masjid', 'gereja', 'pura', 'kuil', 'museum',
            'kampung adat', 'desa wisata', 'istana', 'salib'
        ];
        
        $isCategorySearch = in_array($keywordLower, $categoryKeywords);
        
        $filtered = array_filter($filtered, function($item) use ($keywordLower, $isCategorySearch) {
            // Ambil data dengan benar
            $itemKategori = strtolower(trim($item['kategori'] ?? ''));
            $itemJenis = strtolower(trim($item['jenisWisata'] ?? ''));
            $itemNama = strtolower(trim($item['nama'] ?? $item['label'] ?? ''));
            $itemAlamat = strtolower(trim($item['alamat'] ?? ''));
            $itemKota = strtolower(trim($item['kotaKabupaten'] ?? $item['kota'] ?? ''));
            $itemProvinsi = strtolower(trim($item['provinsi'] ?? ''));
            $itemHariBuka = strtolower(trim($item['hariBuka'] ?? ''));
            $itemJamBuka = strtolower(trim($item['jamBuka'] ?? ''));
            $itemJamTutup = strtolower(trim($item['jamTutup'] ?? ''));
            $itemHarga = strtolower(trim($item['hargaTiket'] ?? $item['harga'] ?? $item['tiket'] ?? ''));
            $itemAktivitas = strtolower(trim($item['aktivitas'] ?? ''));
            $itemFasilitas = strtolower(trim($item['fasilitas'] ?? ''));

            // Jika search kategori
            if ($isCategorySearch) {
                // HANYA cari di kategori dan jenisWisata
                return str_contains($itemKategori, $keywordLower) || 
                       str_contains($itemJenis, $keywordLower);
            }

            $searchFields = [
                $itemNama,
                $itemKategori,
                $itemJenis,
                $itemAlamat,
                $itemKota,
                $itemProvinsi,
                $itemHariBuka,
                $itemJamBuka,
                $itemJamTutup,
                $itemHarga,
                $itemAktivitas,
                $itemFasilitas,
            ];
            
            // Jika bukan kategori, cari di field yang aman
            $safeSearchFields = [
                $item['nama'] ?? $item['label'] ?? '',
                $item['kategori'] ?? '',
                $item['jenisWisata'] ?? '',
                $item['alamat'] ?? '',
                $item['kotaKabupaten'] ?? $item['kota'] ?? '',
                $item['provinsi'] ?? '',
            ];
            
            foreach ($safeSearchFields as $field) {
                if (str_contains(strtolower($field), $keywordLower)) {
                    return true;
                }
            }
            return false;
        });
    }
        
        if (!empty($category)) {
            $categoryLower = strtolower(trim($category));
            $filtered = array_filter($filtered, function($item) use ($categoryLower) {
                $itemCategory = strtolower($item['kategori'] ?? $item['category'] ?? '');
                return $itemCategory === $categoryLower;
            });
        }
        
        if (!empty($type)) {
            $typeLower = strtolower(trim($type));
            $filtered = array_filter($filtered, function($item) use ($typeLower) {
                $itemType = strtolower($item['jenisWisata'] ?? $item['type'] ?? '');
                return $itemType === $typeLower;
            });
        }
        
        return array_values($filtered);
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