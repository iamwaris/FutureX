<?php

use App\Models\MediaKit;
use App\Models\PageSection;
use App\Models\ProductClick;
use App\Models\SnapshotStat;
use App\Models\Sponsor;
use App\Services\Shop\ShopManager;
use App\Services\ThemeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/theme.css', function (ThemeService $theme) {
    return response($theme->cssVariables(), 200, ['Content-Type' => 'text/css']);
})->name('theme.css');

// Only real, customer-facing pages get logged for the admin Traffic widget —
// theme.css and the shop click-redirect below are excluded deliberately.
Route::middleware(['log.pageview'])->group(function () {
    Route::get('/', function () {
        return view('home', [
            'sections' => PageSection::query()->enabled()->ordered()->get(),
        ]);
    })->name('home');

    Route::get('/media-kit', function () {
        return view('media-kit', [
            'mediaKit' => MediaKit::current(),
            'snapshot' => SnapshotStat::current(),
            'sponsors' => Sponsor::query()->where('is_featured', true)->ordered()->get(),
        ]);
    })->name('media-kit');

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
});

Route::get('/media-kit/pdf', function () {
    $pdf = Pdf::loadView('media-kit-pdf', [
        'mediaKit' => MediaKit::current(),
        'snapshot' => SnapshotStat::current(),
        'sponsors' => Sponsor::query()->where('is_featured', true)->ordered()->get(),
    ]);

    return $pdf->download('media-kit.pdf');
})->name('media-kit.pdf');

/**
 * Outbound shop-link tracker for the admin Merch Clicks widget. Signed so
 * only links this app generates itself are valid — accepting a raw ?url=
 * without a signature would be an open redirect (anyone could craft a link
 * through our domain pointing anywhere).
 */
Route::get('/shop/out', function (Request $request) {
    ProductClick::create([
        'product_name' => $request->string('name'),
        'destination_url' => $request->string('url'),
        'clicked_at' => now(),
    ]);

    return redirect()->away($request->string('url'));
})->name('shop.out')->middleware('signed');
