<?php
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['globaladmin'])->group(function () {

    Route::get('/admin/settings', [SettingsController::class, 'index'])
        ->name('admin.settings');

    Route::post('/admin/user/update-password', [SettingsController::class, 'updateUserPassword'])
        ->name('admin.user.password');

    Route::post('/admin/shop/payment', [SettingsController::class, 'updateShopPayment'])
        ->name('admin.shop.payment');

    Route::post('/admin/shop/deactivate', [SettingsController::class, 'deactivateShop'])
        ->name('admin.shop.deactivate');

});
