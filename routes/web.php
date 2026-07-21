<?php

use App\Models\MediaKit;
use App\Models\PageSection;
use App\Models\SnapshotStat;
use App\Models\Sponsor;
use App\Services\Shop\ShopManager;
use App\Services\ThemeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'sections' => PageSection::query()->enabled()->ordered()->get(),
    ]);
})->name('home');

Route::get('/theme.css', function (ThemeService $theme) {
    return response($theme->cssVariables(), 200, ['Content-Type' => 'text/css']);
})->name('theme.css');

Route::get('/media-kit', function () {
    return view('media-kit', [
        'mediaKit' => MediaKit::current(),
        'snapshot' => SnapshotStat::current(),
        'sponsors' => Sponsor::query()->where('is_featured', true)->ordered()->get(),
    ]);
})->name('media-kit');

Route::get('/media-kit/pdf', function () {
    $pdf = Pdf::loadView('media-kit-pdf', [
        'mediaKit' => MediaKit::current(),
        'snapshot' => SnapshotStat::current(),
        'sponsors' => Sponsor::query()->where('is_featured', true)->ordered()->get(),
    ]);

    return $pdf->download('media-kit.pdf');
})->name('media-kit.pdf');

Route::get('/sponsors', function () {
    return view('sponsors-page', [
        'sponsors' => Sponsor::query()->ordered()->get(),
    ]);
})->name('sponsors');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/content', function () {
    return view('content-library');
})->name('content-library');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/events', function () {
    return view('events');
})->name('events');

Route::get('/shop', function (ShopManager $shop) {
    return view('shop', [
        'products' => $shop->products(),
    ]);
})->name('shop');
