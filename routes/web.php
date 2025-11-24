<?php

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/wisata', function () {
    return view('wisata');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    // Untuk sementara kita redirect ke home dulu
    return redirect('/')->with('search', $query);
});

Route::get('/wisata/search', [SearchController::class, 'search']);        // Ganti dari /search
Route::get('/wisata/category/{category}', [SearchController::class, 'byCategory']);
Route::get('/wisata/all', [SearchController::class, 'allWisata']);  

// Tambahkan di web.php - bagian paling bawah
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