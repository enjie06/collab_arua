<?php

namespace App\Http\Controllers;

use App\Services\FusekiService;

class WelcomeController extends Controller
{
    protected $fusekiService;
    
    public function __construct(FusekiService $fusekiService)
    {
        $this->fusekiService = $fusekiService;
    }
    
    /**
     * Halaman / - Homepage
     */
    public function index()
{
    try {
        // Ambil semua data dari Fuseki
        $allWisata = $this->fusekiService->getAllWisata();
        
        // Ambil 10 wisata pertama (filter yang ada gambar dulu)
        $topWisata = [];
        foreach ($allWisata as $wisata) {
            if (count($topWisata) >= 10) break;
            
            // Prioritaskan yang ada gambar
            if (!empty($wisata['gambar'])) {
                $topWisata[] = $wisata;
            }
        }
        
        // Jika masih kurang, tambahkan yang tanpa gambar
        if (count($topWisata) < 10) {
            foreach ($allWisata as $wisata) {
                if (count($topWisata) >= 10) break;
                if (empty($wisata['gambar'])) {
                    $topWisata[] = $wisata;
                }
            }
        }
        
        // Kelompokkan untuk carousel (3-4 per kategori)
        $grouped = $this->fusekiService->getGroupedWisata();
        
        // Ambil maksimal 4 per kategori
        $wisataAlam = array_slice($grouped['alam'], 0, 4);
        $wisataBudaya = array_slice($grouped['budaya'], 0, 3);
        $wisataReligi = array_slice($grouped['religi'], 0, 3);
        
        // Jika data kurang, tambahkan fallback
        if (empty($wisataAlam) && empty($wisataBudaya) && empty($wisataReligi)) {
            return $this->showFallbackHomepage();
        }
        
        return view('welcome', [
            'wisataAlam' => $wisataAlam,
            'wisataBudaya' => $wisataBudaya,
            'wisataReligi' => $wisataReligi,
            'topWisata' => $topWisata
        ]);
        
    } catch (\Exception $e) {
        // Jika error, tampilkan fallback
        return $this->showFallbackHomepage();
    }
}

private function showFallbackHomepage()
{
    $fallbackAlam = [
        [
            'nama' => 'Danau Toba',
            'gambar' => '',
            'kategori' => 'Danau',
            'jenisWisata' => 'alam',
            'kota' => 'Simalungun'
        ]
    ];
    
    $fallbackBudaya = [
        [
            'nama' => 'Istana Maimun',
            'gambar' => '',
            'kategori' => 'Istana',
            'jenisWisata' => 'budaya',
            'kota' => 'Medan'
        ]
    ];
    
    $fallbackReligi = [
        [
            'nama' => 'Masjid Raya Medan',
            'gambar' => '',
            'kategori' => 'Masjid',
            'jenisWisata' => 'religi',
            'kota' => 'Medan'
        ]
    ];
    
    return view('welcome', [
        'wisataAlam' => $fallbackAlam,
        'wisataBudaya' => $fallbackBudaya,
        'wisataReligi' => $fallbackReligi,
        'topWisata' => array_merge($fallbackAlam, $fallbackBudaya, $fallbackReligi)
    ]);
}
}