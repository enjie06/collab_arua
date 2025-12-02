<?php

namespace App\Services;

use App\Helpers\RDFParser;
use Illuminate\Support\Facades\Log;

class SparqlSearchService
{
    protected $allWisata = [];
    
    public function __construct()
    {
        $this->loadAllWisata();
    }
    
    protected function loadAllWisata()
    {
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
                    $this->allWisata = array_merge($this->allWisata, $data);
                    Log::info("Loaded {$name}: " . count($data) . " items");
                } catch (\Exception $e) {
                    Log::error("Failed to load {$name}: " . $e->getMessage());
                }
            }
        }
        
        Log::info("Total wisata loaded: " . count($this->allWisata));
    }
    
    /**
     * Simple search function
     */
    public function search($keyword = null, $category = null, $type = null)
    {
        if (empty($this->allWisata)) {
            return [];
        }
        
        $filtered = $this->allWisata;
        
        // Filter by keyword
        if ($keyword) {
            $keywordLower = strtolower($keyword);
            $filtered = array_filter($filtered, function($item) use ($keywordLower) {
                // Cari di berbagai field
                $searchFields = [
                    $item['nama'] ?? '',
                    $item['label'] ?? '',
                    $item['kategori'] ?? '',
                    $item['jenisWisata'] ?? '',
                    $item['alamat'] ?? '',
                    $item['kotaKabupaten'] ?? '',
                    $item['provinsi'] ?? '',
                    $item['dekatDengan'] ?? '',
                    $item['fasilitas'] ?? '',
                    $item['aktivitas'] ?? '',
                ];
                
                foreach ($searchFields as $field) {
                    if (str_contains(strtolower($field), $keywordLower)) {
                        return true;
                    }
                }
                return false;
            });
        }
        
        // Filter by category
        if ($category) {
            $categoryLower = strtolower($category);
            $filtered = array_filter($filtered, function($item) use ($categoryLower) {
                $itemCategory = strtolower($item['kategori'] ?? $item['category'] ?? '');
                return $itemCategory === $categoryLower;
            });
        }
        
        // Filter by type
        if ($type) {
            $typeLower = strtolower($type);
            $filtered = array_filter($filtered, function($item) use ($typeLower) {
                $itemType = strtolower($item['jenisWisata'] ?? $item['type'] ?? '');
                return $itemType === $typeLower;
            });
        }
        
        // Convert to format yang diharapkan view
        return $this->convertToViewFormat(array_values($filtered));
    }
    
    /**
     * Convert array ke format yang diharapkan view (dengan ->getValue())
     */
    protected function convertToViewFormat($data)
    {
        return array_map(function($item) {
            return (object)[
                'label' => (object)['getValue' => function() use ($item) { 
                    return $item['nama'] ?? $item['label'] ?? 'Tanpa Nama'; 
                }],
                'kategori' => (object)['getValue' => function() use ($item) { 
                    return $item['kategori'] ?? $item['category'] ?? $item['jenisWisata'] ?? 'Umum'; 
                }],
                'jenis' => (object)['getValue' => function() use ($item) { 
                    return $item['jenisWisata'] ?? $item['type'] ?? 'Umum'; 
                }],
                'kota' => (object)['getValue' => function() use ($item) { 
                    return $item['kotaKabupaten'] ?? $item['kota'] ?? $item['city'] ?? ''; 
                }],
                'alamat' => (object)['getValue' => function() use ($item) { 
                    return $item['alamat'] ?? $item['address'] ?? ''; 
                }],
                'latitude' => (object)['getValue' => function() use ($item) { 
                    return $item['latitude'] ?? $item['lat'] ?? ''; 
                }],
                'longitude' => (object)['getValue' => function() use ($item) { 
                    return $item['longitude'] ?? $item['long'] ?? $item['lng'] ?? ''; 
                }],
                'hargaTiket' => (object)['getValue' => function() use ($item) { 
                    return $item['hargaTiket'] ?? $item['harga'] ?? $item['tiket'] ?? 'Gratis'; 
                }],
                'gambar' => isset($item['gambar']) ? 
                    (object)['getUri' => function() use ($item) { return $item['gambar']; }] : null,
                'original' => $item // Simpan data original untuk debug
            ];
        }, $data);
    }
    
    /**
     * Get all unique categories
     */
    public function getAllCategories()
    {
        $categories = [];
        foreach ($this->allWisata as $item) {
            $cat = $item['kategori'] ?? $item['category'] ?? $item['jenisWisata'] ?? null;
            if ($cat) {
                $categories[] = $cat;
            }
        }
        return array_unique($categories);
    }
    
    /**
     * Get all unique types
     */
    public function getAllTypes()
    {
        $types = [];
        foreach ($this->allWisata as $item) {
            $type = $item['jenisWisata'] ?? $item['type'] ?? null;
            if ($type) {
                $types[] = $type;
            }
        }
        return array_unique($types);
    }
}