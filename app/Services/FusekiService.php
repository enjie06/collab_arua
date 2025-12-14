<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class FusekiService
{
    private $endpoint;
    
    public function __construct()
    {
        // PASTIKAN INI SAMA DENGAN ENDPOINT FUSEKI-MU
        $this->endpoint = "http://localhost:3030/wisatasumut_revisi/sparql";
    }
    
    /**
     * AMBIL SEMUA WISATA (untuk halaman /wisata dan /)
     */
    public function getAllWisata()
    {
        // Query SPARQL yang mengambil SEMUA data
        $query = <<<SPARQL
PREFIX wisata: <http://www.semanticweb.org/asus/ontologies/2025/11/wisata_sumut.owl#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-syntax-ns#>

SELECT ?uri ?nama ?jenis ?kategori ?alamat ?kota ?provinsi ?gambar ?harga 
       ?latitude ?longitude ?fasilitas ?aktivitas ?dekatDengan ?agama ?tokoh
       ?jamBuka ?jamTutup ?hariBuka
WHERE {
  ?uri a wisata:DestinasiWisata .
  ?uri wisata:nama ?nama .
  
  OPTIONAL { ?uri wisata:memilikiJenisWisata/rdfs:label ?jenis . }
  OPTIONAL { 
    ?uri wisata:memilikiKategoriAlam|wisata:memilikiKategoriBudaya|wisata:memilikiKategoriReligi/rdfs:label ?kategori .
  }
  OPTIONAL { ?uri wisata:alamatLengkap ?alamat . }
  OPTIONAL { 
    ?uri wisata:berlokasiDi ?kotaURI .
    ?kotaURI rdfs:label ?kota .
  }
  OPTIONAL { ?uri wisata:provinsi ?provinsi . }
  OPTIONAL { ?uri wisata:gambarURL ?gambar . }
  OPTIONAL { ?uri wisata:hargaTiket ?harga . }
  OPTIONAL { ?uri wisata:latitude ?latitude . }
  OPTIONAL { ?uri wisata:longitude ?longitude . }
  OPTIONAL { ?uri wisata:memilikiFasilitas/rdfs:label ?fasilitas . }
  OPTIONAL { ?uri wisata:memilikiAktivitas/rdfs:label ?aktivitas . }
  OPTIONAL { 
    ?uri wisata:dekatDengan ?dekatURI .
    ?dekatURI wisata:nama ?dekatDengan .
  }
  OPTIONAL { ?uri wisata:berkaitanDenganAgama/rdfs:label ?agama . }
  OPTIONAL { ?uri wisata:berkaitanDenganTokoh/rdfs:label ?tokoh . }
  OPTIONAL { ?uri wisata:jamBuka ?jamBuka . }
  OPTIONAL { ?uri wisata:jamTutup ?jamTutup . }
  OPTIONAL { ?uri wisata:hariBuka ?hariBuka . }
}
ORDER BY ?nama
SPARQL;
        
        return $this->executeQuery($query);
    }
    
    /**
     * SEARCH WISATA (untuk halaman search)
     */
    public function searchWisata($keyword)
    {
        $keyword = addslashes($keyword);
        
        // Query SPARQL dengan filter keyword
        $query = <<<SPARQL
PREFIX wisata: <http://www.semanticweb.org/asus/ontologies/2025/11/wisata_sumut.owl#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-syntax-ns#>

SELECT ?uri ?nama ?jenis ?kategori ?alamat ?kota ?provinsi ?gambar ?harga 
       ?latitude ?longitude ?fasilitas ?aktivitas
WHERE {
  ?uri a wisata:DestinasiWisata .
  ?uri wisata:nama ?nama .
  
  OPTIONAL { ?uri wisata:memilikiJenisWisata/rdfs:label ?jenis . }
  OPTIONAL { 
    ?uri wisata:memilikiKategoriAlam|wisata:memilikiKategoriBudaya|wisata:memilikiKategoriReligi/rdfs:label ?kategori .
  }
  OPTIONAL { ?uri wisata:alamatLengkap ?alamat . }
  OPTIONAL { 
    ?uri wisata:berlokasiDi ?kotaURI .
    ?kotaURI rdfs:label ?kota .
  }
  OPTIONAL { ?uri wisata:provinsi ?provinsi . }
  OPTIONAL { ?uri wisata:gambarURL ?gambar . }
  OPTIONAL { ?uri wisata:hargaTiket ?harga . }
  OPTIONAL { ?uri wisata:latitude ?latitude . }
  OPTIONAL { ?uri wisata:longitude ?longitude . }
  OPTIONAL { ?uri wisata:memilikiFasilitas/rdfs:label ?fasilitas . }
  OPTIONAL { ?uri wisata:memilikiAktivitas/rdfs:label ?aktivitas . }
  
  FILTER (
    regex(lcase(str(?nama)), lcase("$keyword"), "i") ||
    regex(lcase(str(?kategori)), lcase("$keyword"), "i") ||
    regex(lcase(str(?kota)), lcase("$keyword"), "i") ||
    regex(lcase(str(?alamat)), lcase("$keyword"), "i") ||
    regex(lcase(str(?jenis)), lcase("$keyword"), "i")
  )
}
LIMIT 50
SPARQL;
        
        return $this->executeQuery($query);
    }
    
    /**
     * KELOMPOKKAN WISATA BERDASARKAN JENIS (Alam, Budaya, Religi)
     */
    public function getGroupedWisata()
    {
        $allWisata = $this->getAllWisata();
        
        $grouped = [
            'alam' => [],
            'budaya' => [],
            'religi' => []
        ];
        
        foreach ($allWisata as $wisata) {
            $jenis = strtolower($wisata['jenis'] ?? '');
            
            if (str_contains($jenis, 'alam')) {
                $grouped['alam'][] = $wisata;
            } elseif (str_contains($jenis, 'budaya')) {
                $grouped['budaya'][] = $wisata;
            } elseif (str_contains($jenis, 'religi')) {
                $grouped['religi'][] = $wisata;
            }
        }
        
        return $grouped;
    }
    
    /**
     * EKSEKUSI QUERY KE FUSEKI
     */
    private function executeQuery($sparql)
    {
        try {
            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->endpoint,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => 'query=' . urlencode($sparql),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Accept: application/sparql-results+json'
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FAILONERROR => true
            ]);
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                Log::error("Fuseki CURL Error: " . curl_error($ch));
                return []; // Return empty array jika error
            }
            
            curl_close($ch);
            
            $data = json_decode($response, true);
            
            if (!isset($data['results']['bindings'])) {
                Log::warning("No results from Fuseki query");
                return [];
            }
            
            // Konversi ke format array PHP yang diharapkan view
            $results = [];
        foreach ($data['results']['bindings'] as $binding) {
            $cleanKategori = $this->extractLabel($binding['kategori']['value'] ?? 'Umum');
            $cleanJenis = $this->extractLabel($binding['jenis']['value'] ?? '');
            
            $wisata = [
                'nama' => $binding['nama']['value'] ?? 'Tanpa Nama',
                'gambar' => $binding['gambar']['value'] ?? '',
                'kategori' => $cleanKategori,
                'jenisWisata' => $cleanJenis,
                'alamat' => $binding['alamat']['value'] ?? '',
                'kota' => $this->extractLabel($binding['kota']['value'] ?? ''),
                'provinsi' => $binding['provinsi']['value'] ?? 'Sumatera Utara',
                'harga_tiket' => $binding['harga']['value'] ?? 'Gratis',
                'hargaTiket' => $binding['harga']['value'] ?? 'Gratis',
                'latitude' => $binding['latitude']['value'] ?? '',
                'longitude' => $binding['longitude']['value'] ?? '',
                'fasilitas' => $this->extractLabel($binding['fasilitas']['value'] ?? ''),
                'aktivitas' => $this->extractLabel($binding['aktivitas']['value'] ?? ''),
                'dekat_dengan' => $binding['dekatDengan']['value'] ?? '',
                'agama_terkait' => $this->extractLabel($binding['agama']['value'] ?? ''),
                'tokoh_terkait' => $this->extractLabel($binding['tokoh']['value'] ?? ''),
                'jam_buka' => $binding['jamBuka']['value'] ?? '08:00',
                'jam_tutup' => $binding['jamTutup']['value'] ?? '17:00',
                'jamBuka' => $binding['jamBuka']['value'] ?? '08:00',
                'jamTutup' => $binding['jamTutup']['value'] ?? '17:00',
                'hariBuka' => $binding['hariBuka']['value'] ?? 'Setiap Hari'
            ];
            
            // Tentukan jenis wisata berdasarkan kategori jika jenis kosong
            if (empty($wisata['jenisWisata'])) {
                $wisata['jenisWisata'] = $this->determineJenisFromKategori($cleanKategori);
            }
            
            $results[] = $wisata;
        }
        
        Log::info("FusekiService: Retrieved " . count($results) . " wisata");
        return $results;
        
    } catch (\Exception $e) {
        Log::error("FusekiService Error: " . $e->getMessage());
        return [];
    }
}

/**
 * EKSTRAK LABEL DARI URI (misal: http://...#sumberair -> sumberair -> Sumber Air)
 */
private function extractLabel($uriOrLabel)
{
    if (empty($uriOrLabel)) return '';
    
    // Jika mengandung '#', ambil bagian setelah #
    if (strpos($uriOrLabel, '#') !== false) {
        $parts = explode('#', $uriOrLabel);
        $label = end($parts);
    } else {
        $label = $uriOrLabel;
    }
    
    // Bersihkan
    $label = str_replace('_Instance', '', $label);
    $label = str_replace('_', ' ', $label);
    $label = str_replace('Http://www.semanticweb.org/asus/ontologies/2025/11/wisata Sumut.owl#', '', $label);
    
    return ucwords(strtolower(trim($label)));
}

/**
 * TENTUKAN JENIS WISATA BERDASARKAN KATEGORI
 */
private function determineJenisFromKategori($kategori)
{
    $kategori = strtolower($kategori);
    
    $alamKeywords = ['air terjun', 'danau', 'gunung', 'pantai', 'sungai', 'sumber air', 'goa', 'hutan'];
    $budayaKeywords = ['istana', 'museum', 'kampung', 'desa', 'taman', 'monumen', 'candi'];
    $religiKeywords = ['masjid', 'gereja', 'kuil', 'pura', 'vihara', 'klenteng'];
    
    foreach ($alamKeywords as $keyword) {
        if (str_contains($kategori, $keyword)) return 'alam';
    }
    
    foreach ($budayaKeywords as $keyword) {
        if (str_contains($kategori, $keyword)) return 'budaya';
    }
    
    foreach ($religiKeywords as $keyword) {
        if (str_contains($kategori, $keyword)) return 'religi';
    }
    
    return 'alam'; // default
}
    
    /**
     * CLEAN LABEL (hapus _Instance, _ dan ganti spasi)
     */
    private function cleanLabel($label)
    {
        if (empty($label)) return '';
        $label = str_replace('_Instance', '', $label);
        $label = str_replace('_', ' ', $label);
        return ucwords(strtolower(trim($label)));
    }
    
    /**
     * TEST KONEKSI KE FUSEKI
     */
    public function testConnection()
    {
        try {
            $query = "SELECT (COUNT(*) as ?count) WHERE { ?s ?p ?o }";
            $ch = curl_init();
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $this->endpoint,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => 'query=' . urlencode($query),
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5
            ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $data = json_decode($response, true);
            
            return [
                'success' => true,
                'count' => $data['results']['bindings'][0]['count']['value'] ?? 0,
                'message' => 'Connected to Fuseki successfully'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}