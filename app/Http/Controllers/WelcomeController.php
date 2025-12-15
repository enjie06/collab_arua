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
            'gambar' => 'https://tse3.mm.bing.net/th/id/OIP.g_Ps3e2c4dA117467s-JZwHaE6?pid=Api&amp;P=0&amp;h=220',
            'kategori' => 'Danau',
            'jenisWisata' => 'alam',
            'kota' => 'Simalungun'
        ],

        [
            'nama' => 'Pulau Samosir',
            'gambar' => 'https://wahananews.co/photo/berita/dir042022/menelusuri-sejarah-terbentuknya-danau-toba-dan-pulau-samosir_0Uounr7D9I.jpg',
            'kategori' => 'Pulau',
            'jenisWisata' => 'alam',
            'kota' => 'Samosir'
        ],

        [
            'nama' => 'Bukit Holbung',
            'gambar' => 'https://tse2.mm.bing.net/th/id/OIP.dxP4esid4Lc8LxLhLC72wQHaEc?pid=Api&amp;P=0&amp;h=220',
            'kategori' => 'Bukit',
            'jenisWisata' => 'alam',
            'kota' => 'Samosir'
        ],

        [
            'nama' => 'Gunung Sibayak',
            'gambar' => 'https://tse2.mm.bing.net/th/id/OIP.gx5_VyBVb34Q8j4HxICijQHaEO?pid=Api&amp;P=0&amp;h=220',
            'kategori' => 'Gunung',
            'jenisWisata' => 'alam',
            'kota' => 'Berastagi'
        ],
 
    ];
    
    $fallbackBudaya = [
        [
            'nama' => 'Istana Maimun',
            'gambar' => 'https://blog.airpaz.com/wp-content/uploads/Istana-Maimun-Medan.jpg',
            'kategori' => 'Istana',
            'jenisWisata' => 'budaya',
            'kota' => 'Medan'
        ],

        [
            'nama' => 'Museum Negeri Sumatera Utara',
            'gambar' => 'https://tourtoba.com/wp-content/uploads/2018/02/museum-negeri.jpg',
            'kategori' => 'Museum',
            'jenisWisata' => 'budaya',
            'kota' => 'Medan'
        ],

        [
            'nama' => 'Desa Wisata Tomok',
            'gambar' => 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Musum_Batak_di_Tomok%2C_Simanindo%2C_Samosir.jpg',
            'kategori' => 'Desa Budaya',
            'jenisWisata' => 'budaya',
            'kota' => 'Samosir'
        ],

    ];
    
    $fallbackReligi = [
        [
            'nama' => 'Masjid Raya Al-Mashun',
            'gambar' => 'https://upload.wikimedia.org/wikipedia/commons/d/d6/Masjid_Raya_Al_Mashun_Medan.jpg',
            'kategori' => 'Masjid',
            'jenisWisata' => 'religi',
            'kota' => 'Medan'
        ],

        [
            'nama' => 'Taman Alam Lumbini',
            'gambar' => 'https://www.itrip.id/wp-content/uploads/2022/03/Daya-Tarik-Taman-Alam-Lumbini.jpg',
            'kategori' => 'Pagoda',
            'jenisWisata' => 'religi',
            'kota' => 'Berastagi'
        ],

        [
            'nama' => 'Graha Maria Annai Velangkanni',
            'gambar' => 'https://images.genpi.co/uploads/sumut/arsip/normal/2022/03/11/graha-maria-annai-velangkanni-foto-dok-disparbud-sumut-n0mt.jpg',
            'kategori' => 'Gereja',
            'jenisWisata' => 'religi',
            'kota' => 'Medan'
        ],

    ];
    
    
    return view('welcome', [
        'wisataAlam' => $fallbackAlam,
        'wisataBudaya' => $fallbackBudaya,
        'wisataReligi' => $fallbackReligi,
        'topWisata' => array_merge($fallbackAlam, $fallbackBudaya, $fallbackReligi)
    ]);
}
}