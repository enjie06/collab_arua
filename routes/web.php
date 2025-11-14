<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/kategori', function () {
    return view('kategori');
});
Route::get('/wisata', function () {
    return view('wisata');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/wisata/page2', function () {
    return view('pages.wisata-page2');
});

Route::get('/wisata/page3', function () {
    return view('pages.wisata-page3');
});

Route::get('/wisata/page4', function () {
    return view('pages.wisata-page4');
});
