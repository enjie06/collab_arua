<?php

namespace App\Helpers;

class RDFParser
{
    public static function parse($filePath)
    {
        // Cek jika file exists
        if (!file_exists($filePath)) {
            throw new \Exception("RDF file not found: " . $filePath);
        }

        // Load file content dan bersihkan XML errors
        $fileContent = file_get_contents($filePath);
        
        // Bersihkan XML dari karakter yang tidak valid
        $fileContent = self::cleanXml($fileContent);
        
        // Parse XML dari string yang sudah dibersihkan
        $xml = simplexml_load_string($fileContent);
        
        if ($xml === false) {
            throw new \Exception("Failed to parse XML file. File may contain invalid XML syntax.");
        }
        
        // Register namespaces
        $xml->registerXPathNamespace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
        $xml->registerXPathNamespace('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
        $xml->registerXPathNamespace('ws', 'http://example.com/wisatasumut#');
        $xml->registerXPathNamespace('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
        $xml->registerXPathNamespace('foaf', 'http://xmlns.com/foaf/0.1/');

        $wisataData = [];

        // Get all Description nodes
        $descriptions = $xml->xpath('//rdf:Description');

        foreach ($descriptions as $desc) {
            $attrs = $desc->attributes('rdf', true);
            $uri = (string)$attrs['about'];

            // Get all child elements
            $data = [
                'uri' => $uri,
                'nama' => self::getValue($desc, 'rdfs:label'),
                'label' => self::getValue($desc, 'rdfs:label'),
                'jenisWisata' => self::getValue($desc, 'ws:jenisWisata'),
                'kategori' => self::getValue($desc, 'ws:kategori'),
                'alamat' => self::getValue($desc, 'ws:alamat'),
                'kotaKabupaten' => self::getValue($desc, 'ws:kotaKabupaten'),
                'provinsi' => self::getValue($desc, 'ws:provinsi'),
                'latitude' => self::getValue($desc, 'geo:latitude'),
                'longitude' => self::getValue($desc, 'geo:longitude'),
                'hargaTiket' => self::getValue($desc, 'ws:hargaTiket'),
                'hariBuka' => self::getValue($desc, 'ws:hariBuka'),
                'jamBuka' => self::getValue($desc, 'ws:jamBuka'),
                'jamTutup' => self::getValue($desc, 'ws:jamTutup'),
                'dekatDengan' => self::getValue($desc, 'ws:dekatDengan'),
                'fasilitas' => self::getValue($desc, 'ws:fasilitas'),
                'aktivitas' => self::getValue($desc, 'ws:aktivitas'),
                'gambar' => self::getResource($desc, 'foaf:depiction')
            ];

            // Hanya tambahkan jika ada label (nama)
            if (!empty($data['label'])) {
                $wisataData[] = $data;
            }
        }

        return $wisataData;
    }

    /**
     * Bersihkan XML dari karakter yang tidak valid
     */
    private static function cleanXml($content)
    {
        // Replace karakter & yang tidak di-escape (kecuali yang sudah valid)
        $content = preg_replace('/&(?!(amp|lt|gt|quot|apos|#x[0-9a-fA-F]+|#[0-9]+);)/', '&amp;', $content);
        
        // Bersihkan karakter kontrol yang tidak valid di XML
        $content = preg_replace('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/', '', $content);
        
        return $content;
    }

    private static function getValue($node, $elementName)
    {
        $parts = explode(':', $elementName);
        $namespace = $parts[0];
        $localName = $parts[1];

        $namespaces = [
            'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#',
            'ws' => 'http://example.com/wisatasumut#',
            'geo' => 'http://www.w3.org/2003/01/geo/wgs84_pos#',
            'foaf' => 'http://xmlns.com/foaf/0.1/'
        ];

        if (!isset($namespaces[$namespace])) {
            return '';
        }

        $elements = $node->children($namespaces[$namespace]);
        return isset($elements->$localName) ? (string)$elements->$localName : '';
    }

    private static function getResource($node, $elementName)
    {
        $parts = explode(':', $elementName);
        $namespace = $parts[0];
        $localName = $parts[1];

        $namespaces = [
            'foaf' => 'http://xmlns.com/foaf/0.1/'
        ];

        if (!isset($namespaces[$namespace])) {
            return '';
        }

        $elements = $node->children($namespaces[$namespace]);
        
        if (isset($elements->$localName)) {
            $attrs = $elements->$localName->attributes('rdf', true);
            
            // Handle jika attribute resource ada tapi tidak ada value
            if (isset($attrs['resource'])) {
                $resourceValue = (string)$attrs['resource'];
                
                // Filter out Google redirect URLs dan URLs yang tidak valid
                if (self::isInvalidImageUrl($resourceValue)) {
                    return ''; // Return empty untuk URLs yang tidak valid
                }
                
                return !empty($resourceValue) ? $resourceValue : '';
            }
            
            // Coba ambil dari attributes umum juga
            $attrsAll = $elements->$localName->attributes();
            if (isset($attrsAll['resource'])) {
                $resourceValue = (string)$attrsAll['resource'];
                
                // Filter out Google redirect URLs dan URLs yang tidak valid
                if (self::isInvalidImageUrl($resourceValue)) {
                    return ''; // Return empty untuk URLs yang tidak valid
                }
                
                return !empty($resourceValue) ? $resourceValue : '';
            }
        }
        
        return '';
    }

    /**
     * Cek apakah URL gambar tidak valid (Google redirect, dll)
     */
    private static function isInvalidImageUrl($url)
    {
        // Jika URL kosong atau hanya berisi tanda petik
        if (empty($url) || $url === '""' || $url === "''" || trim($url) === '') {
            return true;
        }
        
        // List pattern URLs yang tidak valid
        $invalidPatterns = [
            'google.com/url?',      // Google redirect URLs
            '& ',                   // URL dengan spasi setelah &
            'http:// &',            // URL dengan karakter tidak valid
            'https:// &',           // URL dengan karakter tidak valid
            '""',                   // URL kosong dengan petik
        ];
        
        foreach ($invalidPatterns as $pattern) {
            if (strpos($url, $pattern) !== false) {
                return true;
            }
        }
        
        // Cek jika URL tidak mengandung ekstensi gambar umum
        $imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg'];
        $hasImageExtension = false;
        foreach ($imageExtensions as $ext) {
            if (stripos($url, $ext) !== false) {
                $hasImageExtension = true;
                break;
            }
        }
        
        // Jika tidak ada ekstensi gambar dan panjang URL terlalu pendek, consider invalid
        if (!$hasImageExtension && strlen($url) < 10) {
            return true;
        }
        
        return false;
    }
}