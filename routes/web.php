<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('times', \App\Http\Controllers\TimesController::class)->name('times');

Route::name('iapi.')->prefix('iapi')->group(function () {
    Route::get('times', \App\Http\Controllers\Api\TimesController::class)->name('times');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
