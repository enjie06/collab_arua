<?php

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WisataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/wisata', [WisataController::class, 'index'])->name('wisata');

Route::get('/about', function () {
    return view('about');
});

Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    return redirect('/')->with('search', $query);
});

Route::get('/wisata/search', [SearchController::class, 'search']);
Route::get('/wisata/category/{category}', [SearchController::class, 'byCategory']);
Route::get('/wisata/all', [SearchController::class, 'allWisata']);  

// Debug routes
Route::get('/debug-wisata', function() {
    try {
        $controller = new App\Http\Controllers\WisataController();
        $data = $controller->index();
        
        return response()->json([
            'wisataAlam_count' => count($data['wisataAlam']),
            'wisataBudaya_count' => count($data['wisataBudaya']),
            'wisataReligi_count' => count($data['wisataReligi']),
            'wisataAlam_sample' => $data['wisataAlam'][0] ?? 'No data',
            'files_exist' => [
                'alam' => file_exists(public_path('data/wisata_alam_1.xml')),
                'religi' => file_exists(public_path('data/wisata_religi_1.xml'))
            ]
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

Route::get('/test-view', function() {
    // Test langsung dengan data dummy
    $data = [
        'wisataAlam' => [
            [
                'nama' => 'Danau Toba Test',
                'gambar' => 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Danau_Toba%2C_Sumatera.jpg',
                'kategori' => 'Danau',
                'alamat' => 'Parapat',
                'kota' => 'Simalungun',
                'harga_tiket' => 'Gratis'
            ]
        ],
        'wisataBudaya' => [
            [
                'nama' => 'Istana Maimun Test',
                'gambar' => null,
                'kategori' => 'Istana', 
                'alamat' => 'Medan',
                'kota' => 'Medan',
                'harga_tiket' => 'Rp 10.000'
            ]
        ],
        'wisataReligi' => [
            [
                'nama' => 'Masjid Test',
                'gambar' => null,
                'kategori' => 'Masjid',
                'alamat' => 'Medan',
                'kota' => 'Medan', 
                'harga_tiket' => 'Gratis'
            ]
        ]
    ];
    
    return view('wisata', $data);
});

Route::get('/test-sparql', function() {
    try {
        $client = new \EasyRdf\Sparql\Client('http://localhost:3030/arua/sparql');
        $result = $client->query('SELECT * WHERE { ?s ?p ?o } LIMIT 1');
        
        $count = 0;
        foreach ($result as $row) {
            $count++;
        }
        
        return response()->json([
            'status' => 'success', 
            'message' => 'Connected to Fuseki successfully!',
            'data_count' => $count
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => $e->getMessage()
        ]);
    }
});

Route::get('/debug-duplicate', function() {
    $sparqlService = new \App\Services\SparqlService();
    $results = $sparqlService->debugDuplicateData('pantai');
    
    echo "<pre>";
    print_r($results);
    echo "</pre>";
});