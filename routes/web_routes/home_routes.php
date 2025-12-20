<?php

use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;

   Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.home');

   Route::post('/shop/store', [HomeController::class, 'storeShop'])->name('shop.store');


