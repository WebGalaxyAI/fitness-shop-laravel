<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect']
], function () {
    Route::controller(IndexController::class)->group(function () {
        Route::get('/', 'index')->name('home');

        Route::controller(CatalogController::class)->group(function () {
            Route::get('catalog/{category}', 'index')->name('catalog');
            Route::get('catalog-load-more/{category}', 'loadMore')->name('catalog-load-more');
        });

        Route::get('product/{slug}', ProductController::class)->name('product');
    });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
