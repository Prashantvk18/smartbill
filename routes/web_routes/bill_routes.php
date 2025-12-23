<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::middleware(['shopPaid'])->group(function () {
    Route::get('/bill/{bill}/pdf/internal', [BillController::class, 'generatePdfInternal'])
        ->name('bill.pdf.internal');

    Route::get('/bill/{bill}/pdf/send', [BillController::class, 'generateAndSendPdf'])
        ->name('bill.pdf.send');
});

Route::post('/bill/store', [BillController::class, 'store'])
    ->name('bill.store');

Route::post('/bill/{bill}/pdf/remove', [BillController::class, 'removePdf'])
    ->name('bill.pdf.remove');

