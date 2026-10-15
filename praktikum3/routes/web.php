<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome1');
});

Route::get('/tentang-kami', function () {
    return view('about');
});

Route::get('/kontak', function () {
    return view('kontak');
});