<?php

namespace App\Services;

class FuzzySearchService
{
    /**
     * Daftar kata kunci populer untuk wisata Sumut
     */
    private $commonKeywords = [
        // Nama kota/kabupaten
        'medan', 'nias', 'samosir', 'toba', 'berastagi', 'parapat', 'sidikalang',
        'tarutung', 'sibolga', 'pematangsiantar', 'tebing tinggi', 'binjai',
        'tanjungbalai', 'padangsidimpuan', 'gunungsitoli', 'pandan',
        
        // Kategori wisata
        'pantai', 'danau', 'gunung', 'air terjun', 'taman', 'museum', 'candi',
        'istana', 'masjid', 'gereja', 'vihara', 'kuil', 'makam', 'pemandian',
        'kolam', 'pulau', 'bukit', 'gua', 'hutan', 'kebun', 'perkebunan',
        
        // Jenis wisata
        'alam', 'budaya', 'religi', 'sejarah', 'kuliner',
        
        // Aktivitas
        'berenang', 'hiking', 'camping', 'memancing', 'foto', 'surfing',
        
        // Kata umum
        'wisata', 'tempat', 'destinasi', 'objek', 'sekitar'
    ];

    /**
     * Hitung jarak Levenshtein antara dua string
     */
    private function levenshteinDistance($str1, $str2)
    {
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);
        
        $len1 = strlen($str1);
        $len2 = strlen($str2);
        
        if ($len1 == 0) return $len2;
        if ($len2 == 0) return $len1;
        
        $matrix = [];
        
        for ($i = 0; $i <= $len1; $i++) {
            $matrix[$i][0] = $i;
        }
        
        for ($j = 0; $j <= $len2; $j++) {
            $matrix[0][$j] = $j;
        }
        
        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($str1[$i-1] == $str2[$j-1]) ? 0 : 1;
                $matrix[$i][$j] = min(
                    $matrix[$i-1][$j] + 1,      // deletion
                    $matrix[$i][$j-1] + 1,      // insertion
                    $matrix[$i-1][$j-1] + $cost // substitution
                );
            }
        }
        
        return $matrix[$len1][$len2];
    }

    /**
     * Hitung similarity score (0-100)
     */
    private function similarityScore($str1, $str2)
    {
        $distance = $this->levenshteinDistance($str1, $str2);
        $maxLen = max(strlen($str1), strlen($str2));
        
        if ($maxLen == 0) return 100;
        
        return (1 - ($distance / $maxLen)) * 100;
    }

    /**
     * Cari kata terdekat dari typo
     */
    public function findClosestMatch($keyword, $additionalKeywords = [])
    {
        $keyword = strtolower(trim($keyword));
        $allKeywords = array_merge($this->commonKeywords, $additionalKeywords);
        
        // Hapus duplikat
        $allKeywords = array_unique($allKeywords);
        
        $bestMatch = null;
        $bestScore = 0;
        $suggestions = [];
        
        foreach ($allKeywords as $candidate) {
            $candidate = strtolower(trim($candidate));
            
            // Skip jika sama persis
            if ($keyword === $candidate) {
                continue;
            }
            
            $score = $this->similarityScore($keyword, $candidate);
            
            // Tambahkan ke suggestions jika cukup mirip (>60%)
            if ($score >= 60 && $score < 100) {
                $suggestions[] = [
                    'word' => $candidate,
                    'score' => $score
                ];
            }
            
            // Update best match
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $candidate;
            }
        }
        
        // Sort suggestions by score
        usort($suggestions, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Ambil max 5 suggestions
        $suggestions = array_slice($suggestions, 0, 5);
        
        return [
            'corrected' => $bestMatch,
            'score' => $bestScore,
            'suggestions' => array_column($suggestions, 'word'),
            'needsCorrection' => $bestScore >= 70 && $bestScore < 100
        ];
    }

    /**
     * Deteksi pola "wisata sekitar [lokasi]"
     */
    public function detectWisataSekitar($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        $patterns = [
            '/wisata\s+sekitar\s+(.+)/i',
            '/sekitar\s+(.+)/i',
            '/dekat\s+(.+)/i',
            '/di\s+sekitar\s+(.+)/i'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $keyword, $matches)) {
                return [
                    'isWisataSekitar' => true,
                    'location' => trim($matches[1])
                ];
            }
        }
        
        return [
            'isWisataSekitar' => false,
            'location' => null
        ];
    }

    /**
     * Ekstrak kata kunci dari data wisata untuk learning
     */
    public function extractKeywordsFromData($wisataData)
    {
        $keywords = [];
        
        foreach ($wisataData as $wisata) {
            // Nama wisata
            if (!empty($wisata['nama'])) {
                $keywords[] = strtolower($wisata['nama']);
            }
            
            // Kota
            if (!empty($wisata['kota'])) {
                $keywords[] = strtolower($wisata['kota']);
            }
            
            // Kategori
            if (!empty($wisata['kategori'])) {
                $keywords[] = strtolower($wisata['kategori']);
            }
            
            // Lokasi/alamat (extract kata penting)
            if (!empty($wisata['alamat'])) {
                $words = explode(' ', strtolower($wisata['alamat']));
                foreach ($words as $word) {
                    if (strlen($word) > 4) { // Hanya kata >= 5 huruf
                        $keywords[] = $word;
                    }
                }
            }
        }
        
        return array_unique($keywords);
    }

    /**
     * Cek apakah keyword mengandung filter harga
     */
    public function detectPriceFilter($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        $patterns = [
            'gratis' => '/gratis|free|tanpa\s+biaya/i',
            'murah' => '/murah|terjangkau|ekonomis/i',
            'mahal' => '/mahal|premium|eksklusif/i'
        ];
        
        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $keyword)) {
                return [
                    'hasFilter' => true,
                    'type' => $type
                ];
            }
        }
        
        return ['hasFilter' => false, 'type' => null];
    }

    /**
     * Normalize keyword untuk pencarian yang lebih baik
     */
    public function normalizeKeyword($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        // Hapus karakter special
        $keyword = preg_replace('/[^a-z0-9\s]/i', ' ', $keyword);
        
        // Hapus multiple spaces
        $keyword = preg_replace('/\s+/', ' ', $keyword);
        
        return trim($keyword);
    }

    /**
     * Generate alternative search terms
     */
    public function generateAlternatives($keyword)
    {
        $alternatives = [];
        $keyword = strtolower(trim($keyword));
        
        // Common variations
        $variations = [
            'pantai' => ['beach', 'pesisir', 'tepi laut'],
            'danau' => ['lake', 'situ', 'telaga'],
            'gunung' => ['mount', 'pegunungan', 'bukit'],
            'air terjun' => ['waterfall', 'curug'],
            'museum' => ['galeri', 'gedung'],
            'masjid' => ['mesjid', 'musholla'],
            'gereja' => ['kapel', 'katedral']
        ];
        
        foreach ($variations as $key => $alts) {
            if (str_contains($keyword, $key)) {
                $alternatives = array_merge($alternatives, $alts);
            }
            foreach ($alts as $alt) {
                if (str_contains($keyword, $alt)) {
                    $alternatives[] = $key;
                    $alternatives = array_merge($alternatives, array_diff($alts, [$alt]));
                }
            }
        }
        
        return array_unique($alternatives);
    }
}