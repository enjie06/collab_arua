<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
