<?php

namespace App\Services;

use EasyRdf\Graph;
use EasyRdf\Sparql\Client;
use Illuminate\Support\Facades\Log;

class SparqlSearchService
{
    protected $graph;
    
    public function __construct()
    {
        // Option 1: Query ke file RDF lokal
        $this->graph = new Graph();
        $this->loadRdfFiles();
    }
    
    protected function loadRdfFiles()
    {
        $files = [
            public_path('data/wisata_alam_1.xml'),
            public_path('data/wisata_alam_2.xml'),
            public_path('data/wisata_budaya.xml'),
            public_path('data/wisata_religi.xml'),
        ];
        
        foreach ($files as $file) {
            if (file_exists($file)) {
                try {
                    $this->graph->parseFile($file, 'rdfxml');
                    Log::info("Loaded RDF: " . basename($file));
                } catch (\Exception $e) {
                    Log::error("Failed to load {$file}: " . $e->getMessage());
                }
            }
        }
    }
    
    /**
     * SPARQL Search - Mencari di SEMUA field
     */
    public function search($keyword = null, $category = null, $type = null)
    {
        // Build SPARQL query
        $query = $this->buildSearchQuery($keyword, $category, $type);
        
        try {
            $results = $this->graph->query($query);
            return $this->formatResults($results);
        } catch (\Exception $e) {
            Log::error("SPARQL Query Error: " . $e->getMessage());
            
            // Fallback: return empty array jika error
            return [];
        }
    }
    
    /**
     * Build SPARQL query untuk search di semua field
     */
    protected function buildSearchQuery($keyword, $category, $type)
    {
        $prefixes = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX ws: <http://example.com/wisatasumut#>
            PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>
            PREFIX foaf: <http://xmlns.com/foaf/0.1/>
        ";
        
        $select = "
            SELECT DISTINCT ?wisata ?label ?jenis ?kategori ?alamat 
                   ?kota ?provinsi ?latitude ?longitude ?harga 
                   ?fasilitas ?aktivitas ?gambar ?jamBuka ?jamTutup
                   ?dekatDengan ?agama ?tokoh ?hariBuka
        ";
        
        $where = "
            WHERE {
                ?wisata rdfs:label ?label .
                OPTIONAL { ?wisata ws:jenisWisata ?jenis . }
                OPTIONAL { ?wisata ws:kategori ?kategori . }
                OPTIONAL { ?wisata ws:alamat ?alamat . }
                OPTIONAL { ?wisata ws:kotaKabupaten ?kota . }
                OPTIONAL { ?wisata ws:provinsi ?provinsi . }
                OPTIONAL { ?wisata geo:latitude ?latitude . }
                OPTIONAL { ?wisata geo:longitude ?longitude . }
                OPTIONAL { ?wisata ws:hargaTiket ?harga . }
                OPTIONAL { ?wisata ws:fasilitas ?fasilitas . }
                OPTIONAL { ?wisata ws:aktivitas ?aktivitas . }
                OPTIONAL { ?wisata foaf:depiction ?gambar . }
                OPTIONAL { ?wisata ws:jamBuka ?jamBuka . }
                OPTIONAL { ?wisata ws:jamTutup ?jamTutup . }
                OPTIONAL { ?wisata ws:dekatDengan ?dekatDengan . }
                OPTIONAL { ?wisata ws:agamaTerkait ?agama . }
                OPTIONAL { ?wisata ws:tokohTerkait ?tokoh . }
                OPTIONAL { ?wisata ws:hariBuka ?hariBuka . }
        ";
        
        // Tambah FILTER untuk keyword
        $filters = [];
        
        if ($keyword) {
            $safeKeyword = addslashes(strtolower($keyword));
            $filters[] = "
                FILTER (
                    regex(LCASE(STR(?label)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?kategori)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?jenis)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?alamat)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?kota)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?provinsi)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?harga)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?fasilitas)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?aktivitas)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?dekatDengan)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?agama)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?tokoh)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?hariBuka)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?jamBuka)), '{$safeKeyword}', 'i') ||
                    regex(LCASE(STR(?jamTutup)), '{$safeKeyword}', 'i')
                )
            ";
        }
        
        if ($category) {
            $safeCategory = addslashes($category);
            $filters[] = "?wisata ws:kategori '{$safeCategory}' .";
        }
        
        if ($type) {
            $safeType = addslashes($type);
            $filters[] = "?wisata ws:jenisWisata '{$safeType}' .";
        }
        
        $filterString = implode("\n", $filters);
        
        return $prefixes . $select . $where . $filterString . "} LIMIT 100";
    }
    
    /**
     * Format hasil SPARQL ke array
     */
    protected function formatResults($sparqlResults)
    {
        $data = [];
        
        foreach ($sparqlResults as $row) {
            $item = [
                'nama' => $row->label->getValue(),
                'jenisWisata' => isset($row->jenis) ? $row->jenis->getValue() : 'Umum',
                'kategori' => isset($row->kategori) ? $row->kategori->getValue() : 'Umum',
                'alamat' => isset($row->alamat) ? $row->alamat->getValue() : '',
                'kota' => isset($row->kota) ? $row->kota->getValue() : '',
                'provinsi' => isset($row->provinsi) ? $row->provinsi->getValue() : 'Sumatera Utara',
                'latitude' => isset($row->latitude) ? $row->latitude->getValue() : '',
                'longitude' => isset($row->longitude) ? $row->longitude->getValue() : '',
                'harga_tiket' => isset($row->harga) ? $row->harga->getValue() : 'Gratis',
                'fasilitas' => isset($row->fasilitas) ? $row->fasilitas->getValue() : '',
                'aktivitas' => isset($row->aktivitas) ? $row->aktivitas->getValue() : '',
                'gambar' => isset($row->gambar) ? $row->gambar->getUri() : '',
                'jam_buka' => isset($row->jamBuka) ? $row->jamBuka->getValue() : '',
                'jam_tutup' => isset($row->jamTutup) ? $row->jamTutup->getValue() : '',
                'dekat_dengan' => isset($row->dekatDengan) ? $row->dekatDengan->getValue() : '',
                'agama_terkait' => isset($row->agama) ? $row->agama->getValue() : '',
                'tokoh_terkait' => isset($row->tokoh) ? $row->tokoh->getValue() : '',
                'hari_buka' => isset($row->hariBuka) ? $row->hariBuka->getValue() : 'Setiap Hari',
            ];
            
            $data[] = $item;
        }
        
        return $data;
    }
    
    /**
     * Test query SPARQL sederhana
     */
    public function testSparql()
    {
        $query = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX ws: <http://example.com/wisatasumut#>
            
            SELECT (COUNT(?wisata) as ?total)
            WHERE {
                ?wisata rdfs:label ?label .
            }
        ";
        
        try {
            $results = $this->graph->query($query);
            foreach ($results as $row) {
                return $row->total->getValue();
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
        
        return 0;
    }
}