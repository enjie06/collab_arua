<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RDFParser;

class WelcomeController extends Controller
{
    public function index()
    {
        $allWisataData = [];
        
        $rdfFiles = [
            public_path('data/wisata_alam_1.xml'),
            public_path('data/wisata_alam_2.xml'),
            public_path('data/wisata_religi.xml'),
            public_path('data/wisata_budaya.xml'),
        ];
        
        // Parse semua file RDF
        foreach ($rdfFiles as $file) {
            if (file_exists($file)) {
                try {
                    $data = RDFParser::parse($file);
                    $allWisataData = array_merge($allWisataData, $data);
                } catch (\Exception $e) {
                    \Log::error('Error in ' . basename($file) . ': ' . $e->getMessage());
                    continue;
                }
            } else {
                \Log::warning('File not found: ' . basename($file));
            }
        }
        
        // Convert field names untuk kompatibilitas
        $allWisataData = $this->convertFieldNames($allWisataData);
        
        // DEBUG: Cek apakah koordinat sudah ada
        \Log::info('=== DEBUG KOORDINAT ===');
        foreach (array_slice($allWisataData, 0, 5) as $index => $item) {
            \Log::info("Item {$index}: {$item['nama']} - Lat: {$item['latitude']}, Lng: {$item['longitude']}");
        }
        
        // Group by jenisWisata
        $wisataAlam = array_values(array_filter($allWisataData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'alam' || $jenis === 'wisata alam';
        }));
        
        $wisataBudaya = array_values(array_filter($allWisataData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'budaya' || $jenis === 'wisata budaya';
        }));
        
        $wisataReligi = array_values(array_filter($allWisataData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'religi' || $jenis === 'wisata religi';
        }));

        \Log::info('=== FINAL COUNTS ===');
        \Log::info('- Alam: ' . count($wisataAlam));
        \Log::info('- Budaya: ' . count($wisataBudaya));
        \Log::info('- Religi: ' . count($wisataReligi));

        return view('welcome', compact('wisataAlam', 'wisataBudaya', 'wisataReligi'));
    }

    /**
     * Convert field names dari RDFParser format ke View format
     * PERBAIKI INI: Pastikan latitude dan longitude tidak hilang!
     */
    private function convertFieldNames($data)
    {
        return array_map(function($item) {
            // DEBUG: Lihat apa yang ada di $item
            if (!isset($item['latitude']) || !isset($item['longitude'])) {
                \Log::warning("Item tanpa koordinat: " . ($item['nama'] ?? 'Unknown'));
            }
            
            return [
                'nama' => $item['nama'] ?? $item['label'] ?? '',
                'gambar' => $item['gambar'] ?? '',
                'kategori' => $item['kategori'] ?? '',
                'alamat' => $item['alamat'] ?? '',
                'kota' => $item['kotaKabupaten'] ?? '',
                'provinsi' => $item['provinsi'] ?? '',
                
                // PERBAIKAN PENTING: Jangan hilangkan koordinat!
                'latitude' => !empty($item['latitude']) ? (float)$item['latitude'] : null,
                'longitude' => !empty($item['longitude']) ? (float)$item['longitude'] : null,
                
                'harga_tiket' => $item['hargaTiket'] ?? '',
                'hari_buka' => $item['hariBuka'] ?? '',
                'jam_buka' => $item['jamBuka'] ?? '',
                'jam_tutup' => $item['jamTutup'] ?? '',
                'dekat_dengan' => $item['dekatDengan'] ?? '',
                'fasilitas' => $item['fasilitas'] ?? '',
                'aktivitas' => $item['aktivitas'] ?? '',
                'agama_terkait' => $item['agamaTerkait'] ?? '',
                'tokoh_terkait' => $item['tokohTerkait'] ?? '',
                'jenisWisata' => $item['jenisWisata'] ?? '',
            ];
        }, $data);
    }
}