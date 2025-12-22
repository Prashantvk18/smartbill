<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])
        ->name('profile.change.password');

