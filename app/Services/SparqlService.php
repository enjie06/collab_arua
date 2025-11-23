<?php

namespace App\Services;

use EasyRdf\Sparql\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class SparqlService
{
    protected $sparqlClient;

    public function __construct()
    {
        try {
            // GUNAKAN 'arua' bukan 'wisatabaru'
            $this->sparqlClient = new Client('http://localhost:3030/arua/sparql');
            
        } catch (Exception $e) {
            Log::error('Failed to initialize SPARQL client: ' . $e->getMessage());
            throw $e;
        }
    }

    public function searchWisata($keyword)
    {
        try {
            // Escape keyword untuk mencegah SPARQL injection
            $escapedKeyword = addslashes($keyword);
            
            $query = "
                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                PREFIX ws: <http://example.com/wisatasumut#>
                PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

                SELECT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
                WHERE {
                    ?wisata rdfs:label ?label ;
                            ws:jenisWisata ?jenis ;
                            ws:kategori ?kategori ;
                            ws:alamat ?alamat ;
                            ws:kotaKabupaten ?kota ;
                            geo:latitude ?latitude ;
                            geo:longitude ?longitude .
                    
                    FILTER (contains(lcase(str(?label)), lcase(\"$escapedKeyword\")) ||
                            contains(lcase(str(?kategori)), lcase(\"$escapedKeyword\")) ||
                            contains(lcase(str(?kota)), lcase(\"$escapedKeyword\")))
                }
                LIMIT 50
            ";

            Log::info('Executing SPARQL query: ' . $query);
            $results = $this->sparqlClient->query($query);
            
            return $results;

        } catch (Exception $e) {
            Log::error('SPARQL search error: ' . $e->getMessage());
            return []; // Return empty array instead of throwing
        }
    }

    public function getByKategori($kategori)
    {
        try {
            $escapedKategori = addslashes($kategori);
            
            $query = "
                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                PREFIX ws: <http://example.com/wisatasumut#>
                PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

                SELECT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
                WHERE {
                    ?wisata rdfs:label ?label ;
                            ws:jenisWisata ?jenis ;
                            ws:kategori ?kategori ;
                            ws:alamat ?alamat ;
                            ws:kotaKabupaten ?kota ;
                            geo:latitude ?latitude ;
                            geo:longitude ?longitude .
                    
                    FILTER (lcase(str(?kategori)) = lcase(\"$escapedKategori\"))
                }
            ";

            return $this->sparqlClient->query($query);

        } catch (Exception $e) {
            Log::error('SPARQL category error: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllWisata()
    {
        try {
            $query = "
                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                PREFIX ws: <http://example.com/wisatasumut#>
                PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

                SELECT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
                WHERE {
                    ?wisata rdfs:label ?label ;
                            ws:jenisWisata ?jenis ;
                            ws:kategori ?kategori ;
                            ws:alamat ?alamat ;
                            ws:kotaKabupaten ?kota ;
                            geo:latitude ?latitude ;
                            geo:longitude ?longitude .
                }
                ORDER BY ?label
            ";

            return $this->sparqlClient->query($query);

        } catch (Exception $e) {
            Log::error('SPARQL get all error: ' . $e->getMessage());
            return [];
        }
    }

    // Test connection method
    public function testConnection()
    {
        try {
            $query = "SELECT * WHERE { ?s ?p ?o } LIMIT 1";
            $this->sparqlClient->query($query);
            return true;
        } catch (Exception $e) {
            Log::error('SPARQL connection test failed: ' . $e->getMessage());
            return false;
        }
    }
}