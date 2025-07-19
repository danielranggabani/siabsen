<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KantorController;
use App\Http\Controllers\QrCodeController;
use PhpParser\Node\Stmt\Return_;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('kantor', KantorController::class);
    Route::get('/scan-qr', function () {
        return view('scanner');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
