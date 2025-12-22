<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;


Route::group(['middleware' => 'guest'],function() {
    Route::controller(AuthenticationController::class)->group(function(){
        require __DIR__ . '/web_routes/auth_routes.php'; 
    });
});

Route::middleware(['checkedloggedin'])->group(function () {
    require __DIR__ . '/web_routes/home_routes.php'; 
    require __DIR__ . '/web_routes/globaladmincontoller_routes.php'; 
    require __DIR__ . '/web_routes/profile_routes.php';
    require __DIR__ . '/web_routes/bill_routes.php';
    require __DIR__ . '/web_routes/shop_dashboard_routes.php';
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');









