<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\SearchController;

// Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Halaman semua wisata
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Halaman about (static)
Route::get('/about', function () {
    return view('about');
});

// TEST ROUTES - Bisa dihapus setelah semua berjalan
Route::get('/test-fuseki', function() {
    $service = new \App\Services\FusekiService();
    $result = $service->testConnection();
    
    return response()->json($result);
});

Route::get('/test-data', function() {
    $service = new \App\Services\FusekiService();
    $data = $service->getAllWisata();
    
    return response()->json([
        'total' => count($data),
        'sample' => $data[0] ?? 'No data'
    ]);
});

// Route debug untuk wisata
Route::get('/debug-wisata-data', [WisataController::class, 'debug']);
Route::get('/debug-wisata-view', [WisataController::class, 'debugView']);