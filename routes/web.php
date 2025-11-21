<?php

use Illuminate\Support\Facades\Route;

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
