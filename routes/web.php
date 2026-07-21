<?php

use App\Services\ThemeService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/theme.css', function (ThemeService $theme) {
    return response($theme->cssVariables(), 200, ['Content-Type' => 'text/css']);
})->name('theme.css');
