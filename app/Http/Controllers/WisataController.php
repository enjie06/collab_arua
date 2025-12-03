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
            'wisata_alam_1' => public_path('data/wisata_alam_1.xml'),
            'wisata_alam_2' => public_path('data/wisata_alam_2.xml'),
            'wisata_religi' => public_path('data/wisata_religi.xml'),
            'wisata_budaya' => public_path('data/wisata_budaya.xml'),
        ];
        
        foreach ($rdfFiles as $name => $file) {
            \Log::info("=== Processing: {$name} ===");
            
            if (!file_exists($file)) {
                \Log::error("File not found: {$name}");
                continue;
            }
            
            $fileSize = filesize($file);
            \Log::info("File size: {$fileSize} bytes");
            
            if ($fileSize === 0) {
                \Log::warning("File {$name} is empty!");
                continue;
            }
            
            try {
                $data = RDFParser::parse($file);
                \Log::info("{$name} - Success! Data count: " . count($data));
                
                $allWisataData = array_merge($allWisataData, $data);
                
            } catch (\Exception $e) {
                \Log::error("Error parsing {$name}: " . $e->getMessage());
                
                if ($name === 'wisata_budaya') {
                    $content = file_get_contents($file);
                    \Log::info("First 1000 chars of wisata_budaya.xml:");
                    \Log::info(substr($content, 0, 1000));
                }
                continue;
            }
        }
        
        \Log::info('TOTAL ALL DATA BEFORE CONVERT: ' . count($allWisataData));
        
        $convertedData = $this->convertFieldNames($allWisataData);
        
        \Log::info('=== AFTER CONVERT ===');
        \Log::info('Total converted: ' . count($convertedData));
        
        $wisataAlam = array_filter($convertedData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'alam' || $jenis === 'wisata alam';
        });
        
        $wisataBudaya = array_filter($convertedData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'budaya' || $jenis === 'wisata budaya';
        });
        
        $wisataReligi = array_filter($convertedData, function($item) {
            $jenis = strtolower(trim($item['jenisWisata'] ?? ''));
            return $jenis === 'religi' || $jenis === 'wisata religi';
        });

        $wisataAlam = array_values($wisataAlam);
        $wisataBudaya = array_values($wisataBudaya);
        $wisataReligi = array_values($wisataReligi);

        if (count($wisataBudaya) === 0) {
            \Log::warning('Budaya masih kosong, menambahkan data dummy');
            $wisataBudaya = $this->getDummyBudayaData();
        }

        \Log::info('=== FINAL COUNTS ===');
        \Log::info('- Alam: ' . count($wisataAlam));
        \Log::info('- Budaya: ' . count($wisataBudaya));
        \Log::info('- Religi: ' . count($wisataReligi));

        return view('wisata', compact('wisataAlam', 'wisataBudaya', 'wisataReligi'));
    }

    private function convertFieldNames($data)
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
    
    private function getDummyBudayaData()
    {
        return [
            [
                'nama' => 'Museum Batak',
                'gambar' => '',
                'kategori' => 'Museum',
                'alamat' => 'Jl. Diponegoro No.1, Balige',
                'kota' => 'Kabupaten Toba Samosir',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Rp 10.000',
                'jam_buka' => '08:00',
                'jam_tutup' => '16:00',
                'jenisWisata' => 'Budaya'
            ],
            [
                'nama' => 'Istana Maimun',
                'gambar' => '',
                'kategori' => 'Istana',
                'alamat' => 'Jl. Brigjen Katamso, Medan',
                'kota' => 'Kota Medan',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Rp 15.000',
                'jam_buka' => '08:00',
                'jam_tutup' => '17:00',
                'jenisWisata' => 'Budaya'
            ],
            [
                'nama' => 'Rumah Adat Bolon',
                'gambar' => '',
                'kategori' => 'Rumah Adat',
                'alamat' => 'Desa Huta Siallagan, Samosir',
                'kota' => 'Kabupaten Samosir',
                'provinsi' => 'Sumatera Utara',
                'harga_tiket' => 'Rp 5.000',
                'jam_buka' => '08:00',
                'jam_tutup' => '18:00',
                'jenisWisata' => 'Budaya'
            ]
        ];
    }
}