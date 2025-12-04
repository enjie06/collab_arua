<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RDFParser;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $allData = $this->loadAllRDFData();
        
        $keyword = $request->input('q', '');
        $category = $request->input('category');
        $type = $request->input('type');
        
        $filteredData = $this->filterData($allData, $keyword, $category, $type);
        
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
            'keyword' => $keyword,
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
    
    private function filterData($data, $keyword, $category, $type)
    {
        $filtered = $data;
        
        if (!empty($keyword)) {
            $keywordLower = strtolower(trim($keyword));
            $filtered = array_filter($filtered, function($item) use ($keywordLower) {
                $searchFields = [
                    $item['nama'] ?? $item['label'] ?? '',
                    $item['kategori'] ?? $item['category'] ?? '',
                    $item['jenisWisata'] ?? $item['type'] ?? '',
                    $item['alamat'] ?? $item['address'] ?? '',
                    $item['kotaKabupaten'] ?? $item['kota'] ?? $item['city'] ?? '',
                    $item['provinsi'] ?? $item['province'] ?? '',
                ];
                
                foreach ($searchFields as $field) {
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