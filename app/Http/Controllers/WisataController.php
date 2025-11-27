<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\RDFParser;

class WisataController extends Controller
{
    public function index()
    {
        $allWisataData = [];
        
        $rdfFiles = [
            public_path('data/wisata_alam_1.xml'),
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
                    // Skip file yang error
                    continue;
                }
            }
        }
        
        // CONVERT FIELD NAMES untuk kompatibel dengan view
        $allWisataData = $this->convertFieldNames($allWisataData);
        
        // Group by jenisWisata
        $wisataAlam = array_filter($allWisataData, function($item) {
            return isset($item['jenisWisata']) && $item['jenisWisata'] === 'Alam';
        });
        
        $wisataBudaya = array_filter($allWisataData, function($item) {
            return isset($item['jenisWisata']) && $item['jenisWisata'] === 'Budaya';
        });
        
        $wisataReligi = array_filter($allWisataData, function($item) {
            return isset($item['jenisWisata']) && $item['jenisWisata'] === 'Religi';
        });

        // Reset array keys
        $wisataAlam = array_values($wisataAlam);
        $wisataBudaya = array_values($wisataBudaya);
        $wisataReligi = array_values($wisataReligi);

        return view('wisata', compact('wisataAlam', 'wisataBudaya', 'wisataReligi'));
    }

    /**
     * Convert field names dari RDFParser format ke View format
     */
    private function convertFieldNames($data)
    {
        return array_map(function($item) {
            return [
                'nama' => $item['nama'] ?? $item['label'] ?? '',
                'gambar' => $item['gambar'] ?? '',
                'kategori' => $item['kategori'] ?? '',
                'alamat' => $item['alamat'] ?? '',
                'kota' => $item['kotaKabupaten'] ?? '',
                'provinsi' => $item['provinsi'] ?? '',
                'latitude' => $item['latitude'] ?? '',
                'longitude' => $item['longitude'] ?? '',
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