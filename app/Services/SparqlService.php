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
            $this->sparqlClient = new Client('http://localhost:3030/arua/sparql');
        } catch (Exception $e) {
            Log::error('Failed to initialize SPARQL client: ' . $e->getMessage());
            throw $e;
        }
    }

    public function searchWisata($keyword)
    {
        try {
            $escapedKeyword = addslashes($keyword);
            
            $query = "
                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                PREFIX ws: <http://example.com/wisatasumut#>
                PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

                SELECT DISTINCT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
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
                ORDER BY ?label
                LIMIT 50
            ";

            Log::info('Executing SPARQL query: ' . $query);
            $results = $this->sparqlClient->query($query);
            
            return $results;

        } catch (Exception $e) {
            Log::error('SPARQL search error: ' . $e->getMessage());
            return [];
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

                SELECT DISTINCT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
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
                ORDER BY ?label
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

                SELECT DISTINCT ?wisata ?label ?jenis ?kategori ?alamat ?kota ?latitude ?longitude
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

    // Debug method untuk cek duplikat
    public function debugDuplicateData($keyword = 'pantai')
    {
        try {
            $escapedKeyword = addslashes($keyword);
            
            $query = "
                PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                PREFIX ws: <http://example.com/wisatasumut#>

                SELECT ?wisata ?label ?alamat (COUNT(?wisata) as ?count)
                WHERE {
                    ?wisata rdfs:label ?label ;
                            ws:alamat ?alamat .
                    
                    FILTER (contains(lcase(str(?label)), lcase(\"$escapedKeyword\")))
                }
                GROUP BY ?wisata ?label ?alamat
                ORDER BY DESC(?count)
            ";

            $results = $this->sparqlClient->query($query);
            
            $debug = [];
            foreach ($results as $result) {
                $debug[] = [
                    'uri' => $result->wisata->getUri(),
                    'label' => $result->label->getValue(),
                    'alamat' => $result->alamat->getValue(),
                    'count' => $result->count->getValue()
                ];
            }
            
            return $debug;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}