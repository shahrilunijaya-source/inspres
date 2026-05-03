<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// public marketing
Route::get('/', [PublicController::class, 'landing'])->name('landing');

// auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// demo switcher (unauthenticated routes — gated to demo env)
Route::get('/demo/switch', [DemoController::class, 'switchRole'])->name('demo.switch');
Route::get('/demo/walkthrough', [DemoController::class, 'walkthrough'])->name('demo.walkthrough');
Route::post('/demo/walkthrough/advance', [DemoController::class, 'advance'])->name('demo.walkthrough.advance');

// public certificate verification (no auth)
Route::get('/verify/certificate/{certNo}', [CertificateController::class, 'verify'])->name('certificate.verify');

// public status tracker (no auth)
Route::get('/track', [PublicController::class, 'track'])->name('track');

// authenticated citizen area
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PublicController::class, 'dashboard'])->name('dashboard');

    // application module forms
    Route::get('/apply/birth', [ApplicationController::class, 'createBirth'])->name('apply.birth');
    Route::post('/apply/birth', [ApplicationController::class, 'storeBirth']);
    Route::get('/apply/mykad', [ApplicationController::class, 'createMykad'])->name('apply.mykad');
    Route::post('/apply/mykad', [ApplicationController::class, 'storeMykad']);
    Route::get('/apply/marriage', [ApplicationController::class, 'createMarriage'])->name('apply.marriage');
    Route::post('/apply/marriage', [ApplicationController::class, 'storeMarriage']);

    // tracker
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
});
