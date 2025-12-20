<?php
use App\Http\Controllers\Admin\GlobalAdminController;

Route::middleware(['globaladmin'])->group(function () {

    Route::get('/admin/settings', [GlobalAdminController::class, 'index'])
    ->name('admin.settings');

    Route::post('/admin/update-user-password', [GlobalAdminController::class, 'updateUserPassword'])
    ->name('admin.user.password.update');

    Route::post('/admin/activate-shop',[GlobalAdminController::class, 'activateshop'])
    ->name('admin.shop.activate');

    Route::post('/admin/deactivate-shop',[GlobalAdminController::class, 'deactivateshop'])
    ->name('admin.shop.deactivate');

    Route::get('/admin/payment-history',[GlobalAdminController::class, 'paymentHistory'])
    ->name('admin.payment.history');

});
