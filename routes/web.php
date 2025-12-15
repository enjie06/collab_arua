<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Halaman semua wisata
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata');

// Search dengan FUZZY SEARCH & TYPO CORRECTION
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Halaman about (static)
Route::get('/about', function () {
    return view('about');
});

/*
|--------------------------------------------------------------------------
| TEST ROUTES - Bisa dihapus setelah semua berjalan
|--------------------------------------------------------------------------
*/

// Test koneksi Fuseki
Route::get('/test-fuseki', function() {
    $service = new \App\Services\FusekiService();
    $result = $service->testConnection();
    
    return response()->json($result);
});

// Test data dari Fuseki
Route::get('/test-data', function() {
    $service = new \App\Services\FusekiService();
    $data = $service->getAllWisata();
    
    return response()->json([
        'total' => count($data),
        'sample' => $data[0] ?? 'No data'
    ]);
});

// Test Fuzzy Search Service
Route::get('/test-fuzzy', function() {
    $fuzzyService = new \App\Services\FuzzySearchService();
    
    // Test typo correction
    $tests = [
        'niass' => $fuzzyService->findClosestMatch('niass'),
        'meadn' => $fuzzyService->findClosestMatch('meadn'),
        'pantaii' => $fuzzyService->findClosestMatch('pantaii'),
        'danaw' => $fuzzyService->findClosestMatch('danaw'),
    ];
    
    return response()->json([
        'message' => 'Fuzzy Search Test',
        'tests' => $tests
    ]);
});

// Route debug untuk wisata
Route::get('/debug-wisata-data', [WisataController::class, 'debug']);
Route::get('/debug-wisata-view', [WisataController::class, 'debugView']);