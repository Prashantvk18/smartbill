<?php 

use App\Http\Controllers\Shop\ShopDashboardController;
use App\Http\Controllers\BillController;
use Illuminate\Support\Facades\Route;

Route::middleware(['shopPaid'])->group(function () {

    Route::get('/shop/{shop}/dashboard', 
        [ShopDashboardController::class, 'index']
    )->name('shop.dashboard');

});
       Route::post('/bill/update-balance', 
        [BillController::class, 'updateBalance']
    )->name('bill.update.balance');
