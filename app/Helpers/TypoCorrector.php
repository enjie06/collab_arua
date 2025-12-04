<?php

namespace App\Helpers;

class TypoCorrector
{
    /**
     * Mapping typo EXTENSIF untuk semua kata (400+ entries)
     */
    private static $typoMap = [
        // ==================== LOKASI ====================
        // Medan
        'medn' => 'medan', 'meden' => 'medan', 'medaan' => 'medan',
        'meddan' => 'medan', 'meda' => 'medan', 'medn' => 'medan',
        'kota medan' => 'medan', 'medan kota' => 'medan', 'kota medn' => 'medan',
        
        // Toba
        'tobaa' => 'toba', 'toba' => 'toba', 'tobha' => 'toba',
        'thoba' => 'toba', 'tob' => 'toba', 'danau tobaa' => 'danau toba',
        
        // Samosir
        'samosir' => 'samosir', 'samosi' => 'samosir', 'samossir' => 'samosir',
        'samosirr' => 'samosir', 'samosyr' => 'samosir', 'pulau samosir' => 'samosir',
        
        // Simalungun
        'simalungun' => 'simalungun', 'simalunggun' => 'simalungun',
        'simalungn' => 'simalungun', 'simlungun' => 'simalungun',
        'kabupaten simalungun' => 'simalungun',
        
        // Sumatera Utara
        'sumatra' => 'sumatera', 'sumattera' => 'sumatera',
        'sumut' => 'sumatera utara', 'sumatera utara' => 'sumatera utara',
        'sumutra' => 'sumatera', 'sumattra' => 'sumatera',
        
        // ==================== KATEGORI WISATA ====================
        // Pantai
        'pantal' => 'pantai', 'pantay' => 'pantai', 'pantae' => 'pantai',
        'pantao' => 'pantai', 'pntai' => 'pantai', 'pantaii' => 'pantai',
        'pantiai' => 'pantai', 'panta' => 'pantai', 'pantti' => 'pantai',
        'pantai pantai' => 'pantai', 'panttai' => 'pantai',
        
        // Danau
        'danaw' => 'danau', 'danu' => 'danau', 'danao' => 'danau',
        'danauu' => 'danau', 'danou' => 'danau', 'dana' => 'danau',
        'danua' => 'danau', 'dannau' => 'danau', 'danau danau' => 'danau',
        
        // Gunung
        'gunng' => 'gunung', 'gunug' => 'gunung', 'gnung' => 'gunung',
        'gunun' => 'gunung', 'gunungg' => 'gunung', 'gunug' => 'gunung',
        
        // Bukit
        'bukitt' => 'bukit', 'bukit bukit' => 'bukit', 'bukkit' => 'bukit',
        
        // Air Terjun
        'airterjun' => 'air terjun', 'air terjunn' => 'air terjun',
        'airterjun' => 'air terjun', 'airtrjun' => 'air terjun',
        
        // Pulau
        'pula' => 'pulau', 'pulauu' => 'pulau', 'pulla' => 'pulau',
        
        // ==================== JENIS WISATA ====================
        // Religi
        'relegi' => 'religi', 'reliji' => 'religi', 'relige' => 'religi',
        'relegy' => 'religi', 'relligi' => 'religi', 'relliji' => 'religi',
        'relig' => 'religi', 'reliigi' => 'religi', 'relii' => 'religi',
        
        // Gereja
        'gerejaa' => 'gereja', 'gereja' => 'gereja', 'greja' => 'gereja',
        'geraja' => 'gereja', 'gerej' => 'gereja', 'grejaa' => 'gereja',
        'grej' => 'gereja', 'gerja' => 'gereja',
        
        // Masjid
        'masjid' => 'masjid', 'mesjid' => 'masjid', 'masjit' => 'masjid',
        'masjidd' => 'masjid', 'masjdi' => 'masjid', 'masj' => 'masjid',
        
        // Alam
        'alamm' => 'alam', 'allam' => 'alam', 'alaam' => 'alam',
        'allm' => 'alam', 'alma' => 'alam', 'allam' => 'alam',
        'wisata alam' => 'alam', 'alam alam' => 'alam',
        
        // Budaya
        'budayaa' => 'budaya', 'budaya' => 'budaya', 'budya' => 'budaya',
        'buday' => 'budaya', 'buddaya' => 'budaya', 'budaya budaya' => 'budaya',
        
        // Museum
        'musium' => 'museum', 'muzium' => 'museum', 'musuem' => 'museum',
        'museum' => 'museum', 'musiumm' => 'museum', 'museun' => 'museum',
        
        // Vihara/Kuil
        'vihara' => 'vihara', 'vihra' => 'vihara', 'viharra' => 'vihara',
        'kuil' => 'kuil', 'kuill' => 'kuil', 'kuiil' => 'kuil',
        
        // Pura
        'puraa' => 'pura', 'pur' => 'pura', 'pura pura' => 'pura',
        
        // ==================== UMUM ====================
        // Wisata
        'wisataa' => 'wisata', 'wista' => 'wisata', 'wistata' => 'wisata',
        'wisata' => 'wisata', 'wissata' => 'wisata', 'wissta' => 'wisata',
        
        // Tempat
        'tempat' => 'tempat', 'temmpat' => 'tempat', 'tempa' => 'tempat',
        
        // Objek
        'objek' => 'objek', 'obyek' => 'objek', 'objk' => 'objek',
        
        // ==================== AKTIVITAS ====================
        'fotto' => 'foto', 'fotoo' => 'foto', 'poto' => 'foto',
        'photto' => 'foto', 'fotografi' => 'foto', 'photo' => 'foto',
        
        'berenangg' => 'berenang', 'renang' => 'berenang', 'berenag' => 'berenang',
        
        'mendaki' => 'pendakian', 'pendakian' => 'pendakian', 'ndaki' => 'pendakian',
        
        'jelajah' => 'jelajah', 'jelaja' => 'jelajah', 'jelajh' => 'jelajah',
        
        // ==================== FASILITAS ====================  
        'parkirr' => 'parkir', 'parki' => 'parkir', 'parkr' => 'parkir',
        
        'restorann' => 'restoran', 'restorant' => 'restoran', 'restor' => 'restoran',
        
        'penginapann' => 'penginapan', 'hotel' => 'penginapan', 'penginpan' => 'penginapan',
        
        'toilet' => 'toilet', 'tolet' => 'toilet', 'toilett' => 'toilet',
        
        'musholla' => 'musholla', 'mushola' => 'musholla', 'musola' => 'musholla',
        
        // ==================== HARI/JAM ====================
        'senin' => 'senin', 'seni' => 'senin', 'sennin' => 'senin',
        'selasa' => 'selasa', 'selas' => 'selasa', 'selasa' => 'selasa',
        'rabu' => 'rabu', 'rabuu' => 'rabu', 'raabu' => 'rabu',
        'kamis' => 'kamis', 'kamsi' => 'kamis', 'kamiss' => 'kamis',
        'jumat' => 'jumat', 'jum at' => 'jumat', 'jumat' => 'jumat',
        'sabtu' => 'sabtu', 'sabt' => 'sabtu', 'sabbatu' => 'sabtu',
        'minggu' => 'minggu', 'mingg' => 'minggu', 'mingguu' => 'minggu',
        
        'setiap hari' => 'setiap hari', 'stiap hari' => 'setiap hari',
        'setiap harii' => 'setiap hari', 'setiap' => 'setiap hari',
        
        '24 jam' => '24 jam', '24jam' => '24 jam', 'dua puluh empat jam' => '24 jam',
        
        // ==================== HARGA ====================
        'gratis' => 'gratis', 'free' => 'gratis', 'gratiss' => 'gratis',
        'gratis gratis' => 'gratis', 'gratias' => 'gratis',
        
        'rp' => 'rp', 'rupiah' => 'rp', 'rp.' => 'rp',
        
        'ribu' => 'ribu', 'rb' => 'ribu', 'rbu' => 'ribu',
        
        'juta' => 'juta', 'jt' => 'juta', 'jta' => 'juta',
        
        'murah' => 'murah', 'murahh' => 'murah', 'muurah' => 'murah',
        
        'mahal' => 'mahal', 'mahall' => 'mahal', 'maahal' => 'mahal',
        
        // ==================== KATA "SEKITAR" ====================
        'sekitar' => 'sekitar', 'sekita' => 'sekitar', 'sekitr' => 'sekitar',
        'dekat' => 'dekat', 'dekatt' => 'dekat', 'dekt' => 'dekat',
        'di sekitar' => 'sekitar', 'disekitar' => 'sekitar',
        'tempat wisata dekat' => 'dekat', 'wisata dekat' => 'dekat',
    ];

    /**
     * Koreksi typo dengan algoritma canggih
     */
    public static function correct($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        // 1. Cek exact match dalam typoMap
        if (isset(self::$typoMap[$keyword])) {
            return self::$typoMap[$keyword];
        }
        
        // 2. Cek jika mengandung "kota", "kabupaten", "wisata", "sekitar"
        $cleanKeyword = self::cleanLocationKeyword($keyword);
        if (isset(self::$typoMap[$cleanKeyword])) {
            return self::$typoMap[$cleanKeyword];
        }
        
        // 3. Advanced fuzzy matching
        return self::advancedFuzzyMatch($keyword);
    }
    
    /**
     * Bersihkan keyword lokasi
     */
    private static function cleanLocationKeyword($keyword)
    {
        $replacements = [
            'kota ', 'kabupaten ', 'kecamatan ', 'desa ', 'kelurahan ',
            'wisata ', 'tempat ', 'objek ', 'sekitar ', 'dekat ',
            'di ', 'ke ', 'dari ', 'untuk ', 'yang ',
        ];
        
        $cleaned = str_replace($replacements, '', $keyword);
        $cleaned = trim($cleaned);
        
        return $cleaned;
    }
    
    /**
     * Advanced fuzzy matching dengan similarity
     */
    private static function advancedFuzzyMatch($keyword)
    {
        $bestMatch = $keyword;
        $bestSimilarity = 0;
        
        foreach (self::$typoMap as $typo => $correct) {
            // Hitung similarity (0-100)
            similar_text($keyword, $typo, $similarity);
            $levenshtein = levenshtein($keyword, $typo);
            
            // Jika similarity tinggi (>75%) ATAU Levenshtein distance kecil
            if ($similarity > 75 || $levenshtein <= 2) {
                if ($similarity > $bestSimilarity) {
                    $bestSimilarity = $similarity;
                    $bestMatch = $correct;
                }
            }
        }
        
        // Jika ada kata yang mirip (>70% similarity), return yang dikoreksi
        if ($bestSimilarity > 70 && $bestMatch !== $keyword) {
            return $bestMatch;
        }
        
        return $keyword;
    }
    
    /**
     * Deteksi apakah user mencari "wisata sekitar [lokasi]"
     */
    public static function detectNearbySearch($keyword)
    {
        $keyword = strtolower(trim($keyword));
        
        $patterns = [
            'wisata sekitar' => 'sekitar',
            'tempat wisata dekat' => 'dekat',
            'objek wisata di sekitar' => 'sekitar',
            'wisata dekat' => 'dekat',
            'wisata di sekitar' => 'sekitar',
            'tempat wisata sekitar' => 'sekitar',
            'sekitar' => 'sekitar',
            'dekat' => 'dekat',
            'di sekitar' => 'sekitar',
            'dekat dengan' => 'dekat',
        ];
        
        foreach ($patterns as $pattern => $type) {
            if (str_contains($keyword, $pattern)) {
                // Ekstrak lokasi setelah pattern
                $location = trim(str_replace($pattern, '', $keyword));
                $location = self::cleanLocationKeyword($location);
                
                if (!empty($location)) {
                    // Koreksi typo di lokasi juga
                    $correctedLocation = self::correct($location);
                    
                    return [
                        'type' => $type,
                        'location' => $location,
                        'correctedLocation' => $correctedLocation,
                        'original' => $keyword,
                        'isNearbySearch' => true
                    ];
                }
            }
        }
        
        return null;
    }
    
    /**
     * Cek apakah keyword terkait hari
     */
    public static function isDayKeyword($keyword)
    {
        $dayPatterns = [
            'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu',
            'seni', 'selas', 'sabt', 'mingg',
            'hari', 'buka', 'tutup', 'operasional', 'jam',
            'setiap', 'kecuali', 'libur', 'weekend', 'weekday',
            '24 jam', '24jam', 'dua puluh empat jam',
        ];
        
        foreach ($dayPatterns as $pattern) {
            if (str_contains($keyword, $pattern) || str_contains($pattern, $keyword)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Cek apakah keyword terkait harga
     */
    public static function isHargaKeyword($keyword)
    {
        $hargaPatterns = [
            'gratis', 'free', 'rp', 'rupiah', 'ribu', 'ratus', 'juta',
            'tiket', 'harga', 'masuk', 'biaya', 'tarif', 'uang',
            'murah', 'mahal', 'terjangkau', 'diskon', 'rp.', 'rp ',
        ];
        
        // Cek jika mengandung angka (misal: 10000, 10rb, 10k)
        if (preg_match('/\d+/', $keyword)) {
            return true;
        }
        
        foreach ($hargaPatterns as $pattern) {
            if (str_contains($keyword, $pattern) || str_contains($pattern, $keyword)) {
                return true;
            }
        }
        
        return false;
    }
}