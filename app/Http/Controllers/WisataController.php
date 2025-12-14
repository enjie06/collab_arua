<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FusekiService;
use Illuminate\Support\Facades\Log;

class WisataController extends Controller
{
    protected $fusekiService;
    
    public function __construct(FusekiService $fusekiService)
    {
        $this->fusekiService = $fusekiService;
    }
    
    /**
     * Halaman /wisata - Semua destinasi
     */
    public function index()
    {
        try {
            Log::info("WisataController: Loading wisata data...");
            
            // 1. Ambil SEMUA data dari Fuseki
            $allWisata = $this->fusekiService->getAllWisata();
            Log::info("WisataController: Got " . count($allWisata) . " wisata from Fuseki");
            
            // 2. Format data untuk view
            $formattedWisata = $this->formatWisataForView($allWisata);
            
            // 3. Kelompokkan berdasarkan jenisWisata
            $grouped = $this->groupWisataByType($formattedWisata);
            
            Log::info("WisataController: Grouped results - Alam: " . count($grouped['alam']) . 
                    ", Budaya: " . count($grouped['budaya']) . 
                    ", Religi: " . count($grouped['religi']));
            
            // 4. DEBUG: Tampilkan sample
            if (count($grouped['alam']) > 0) {
                Log::info("Sample alam data for view:", [
                    'nama' => $grouped['alam'][0]['nama'] ?? 'N/A',
                    'kategori' => $grouped['alam'][0]['kategori'] ?? 'N/A',
                    'kota' => $grouped['alam'][0]['kota'] ?? 'N/A'
                ]);
            }
            
            // 5. Jika data kosong, tampilkan fallback
            if (empty($allWisata)) {
                Log::warning("WisataController: No data from Fuseki, using fallback");
                return $this->showFallbackData();
            }
            
            // 6. Pass data ke view
            return view('wisata', [
                'wisataAlam' => $grouped['alam'],
                'wisataBudaya' => $grouped['budaya'], 
                'wisataReligi' => $grouped['religi']
            ]);
            
        } catch (\Exception $e) {
            Log::error("WisataController Error: " . $e->getMessage());
            return $this->showFallbackData();
        }
    }
    
    /**
     * KELOMPOKKAN WISATA BERDASARKAN JENIS
     */
    private function groupWisataByType($wisataList)
    {
        $grouped = [
            'alam' => [],
            'budaya' => [],
            'religi' => []
        ];
        
        foreach ($wisataList as $wisata) {
            $jenis = strtolower($wisata['jenisWisata'] ?? '');
            
            // DEBUG: Log jika jenis kosong
            if (empty($jenis)) {
                Log::warning("Wisata without jenisWisata: " . ($wisata['nama'] ?? 'Unknown'));
            }
            
            // Determine category
            if (str_contains($jenis, 'alam') || $this->isAlamCategory($wisata['kategori'] ?? '')) {
                $grouped['alam'][] = $wisata;
            } elseif (str_contains($jenis, 'budaya') || $this->isBudayaCategory($wisata['kategori'] ?? '')) {
                $grouped['budaya'][] = $wisata;
            } elseif (str_contains($jenis, 'religi') || $this->isReligiCategory($wisata['kategori'] ?? '')) {
                $grouped['religi'][] = $wisata;
            } else {
                // Default ke alam jika tidak diketahui
                $grouped['alam'][] = $wisata;
            }
        }
        
        return $grouped;
    }
    
    /**
     * DETECT KATEGORI ALAM
     */
    private function isAlamCategory($kategori)
    {
        $kategori = strtolower($kategori);
        $alamKeywords = ['air terjun', 'danau', 'gunung', 'pantai', 'sungai', 'sumber air', 'goa', 'hutan', 'pemandian', 'kolam'];
        
        foreach ($alamKeywords as $keyword) {
            if (str_contains($kategori, $keyword)) return true;
        }
        
        return false;
    }
    
    /**
     * DETECT KATEGORI BUDAYA
     */
    private function isBudayaCategory($kategori)
    {
        $kategori = strtolower($kategori);
        $budayaKeywords = ['istana', 'museum', 'kampung', 'desa', 'taman', 'monumen', 'candi', 'benteng', 'istana'];
        
        foreach ($budayaKeywords as $keyword) {
            if (str_contains($kategori, $keyword)) return true;
        }
        
        return false;
    }
    
    /**
     * DETECT KATEGORI RELIGI
     */
    private function isReligiCategory($kategori)
    {
        $kategori = strtolower($kategori);
        $religiKeywords = ['masjid', 'gereja', 'kuil', 'pura', 'vihara', 'klenteng', 'tempat ibadah'];
        
        foreach ($religiKeywords as $keyword) {
            if (str_contains($kategori, $keyword)) return true;
        }
        
        return false;
    }
    
    /**
     * Data fallback jika Fuseki tidak ada data
     */
    private function showFallbackData()
    {
        Log::info("WisataController: Showing fallback data");
        
        $fallbackAlam = [
            [
                'nama' => 'Danau Toba',
                'gambar' => '',
                'kategori' => 'Danau',
                'jenisWisata' => 'alam',
                'alamat' => 'Parapat, Simalungun',
                'kota' => 'Simalungun',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Gratis',
                'hargaTiket' => 'Gratis',
                'latitude' => '2.628611',
                'longitude' => '98.825278',
                'fasilitas' => 'Parkir, Toilet, Warung Makan',
                'aktivitas' => 'Berenang, Fotografi, Bersantai',
                'dekat_dengan' => 'Parapat',
                'jam_buka' => '08:00',
                'jam_tutup' => '18:00'
            ]
        ];
        
        $fallbackBudaya = [
            [
                'nama' => 'Istana Maimun',
                'gambar' => '',
                'kategori' => 'Istana',
                'jenisWisata' => 'budaya',
                'alamat' => 'Jl. Brigjend Katamso No. 66, Medan',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Rp 10.000',
                'hargaTiket' => 'Rp 10.000',
                'latitude' => '3.5752',
                'longitude' => '98.6837',
                'fasilitas' => 'Parkir, Guide, Toilet',
                'aktivitas' => 'Fotografi, Belajar Sejarah',
                'dekat_dengan' => 'Pusat Kota Medan',
                'jam_buka' => '08:00',
                'jam_tutup' => '17:00'
            ]
        ];
        
        $fallbackReligi = [
            [
                'nama' => 'Masjid Raya Medan',
                'gambar' => '',
                'kategori' => 'Masjid',
                'jenisWisata' => 'religi',
                'alamat' => 'Jl. Sisingamangaraja, Medan',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Gratis',
                'hargaTiket' => 'Gratis',
                'latitude' => '3.5852',
                'longitude' => '98.6739',
                'fasilitas' => 'Parkir, Tempat Wudhu, Perpustakaan',
                'aktivitas' => 'Ibadah, Fotografi',
                'agama_terkait' => 'Islam',
                'jam_buka' => '04:00',
                'jam_tutup' => '22:00'
            ]
        ];
        
        return view('wisata', [
            'wisataAlam' => $fallbackAlam,
            'wisataBudaya' => $fallbackBudaya,
            'wisataReligi' => $fallbackReligi
        ]);
    }
    
    /**
     * DEBUG PAGE - untuk cek data
     */
    public function debug()
    {
        $allWisata = $this->fusekiService->getAllWisata();
        $grouped = $this->groupWisataByType($allWisata);
        
        return response()->json([
            'total_wisata' => count($allWisata),
            'grouped_counts' => [
                'alam' => count($grouped['alam']),
                'budaya' => count($grouped['budaya']),
                'religi' => count($grouped['religi'])
            ],
            'sample_alam' => $grouped['alam'][0] ?? 'No alam data',
            'sample_budaya' => $grouped['budaya'][0] ?? 'No budaya data',
            'sample_religi' => $grouped['religi'][0] ?? 'No religi data'
        ]);
    }

    private function formatWisataForView($wisataList)
    {
        $formatted = [];
        
        foreach ($wisataList as $wisata) {
            // Format kategori: "Sumberair" -> "Sumber Air"
            $kategori = $wisata['kategori'] ?? '';
            $kategori = str_replace('_', ' ', $kategori);
            
            // Jika satu kata tapi seharusnya dua kata
            $singleWordCategories = [
                'sumberair' => 'Sumber Air',
                'tamannasional' => 'Taman Nasional',
                'airterjun' => 'Air Terjun'
            ];
            
            $kategoriLower = strtolower($kategori);
            if (isset($singleWordCategories[$kategoriLower])) {
                $kategori = $singleWordCategories[$kategoriLower];
            } else {
                $kategori = ucwords($kategori);
            }
            
            // Jika kota kosong, gunakan provinsi atau default
            $kota = $wisata['kota'] ?? '';
            if (empty($kota)) {
                $kota = $wisata['provinsi'] ?? 'Sumatera Utara';
            }
            
            $formatted[] = array_merge($wisata, [
                'kategori' => $kategori,
                'kota' => $kota
            ]);
        }
        
        return $formatted;
    }

    public function debugView()
    {
        $allWisata = $this->fusekiService->getAllWisata();
        $formattedWisata = $this->formatWisataForView($allWisata);
        $grouped = $this->groupWisataByType($formattedWisata);
        
        return view('debug.wisata', [
            'allWisata' => $allWisata,
            'wisataAlam' => $grouped['alam'],
            'wisataBudaya' => $grouped['budaya'],
            'wisataReligi' => $grouped['religi']
        ]);
    }
}