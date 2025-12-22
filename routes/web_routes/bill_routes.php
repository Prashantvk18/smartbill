<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::post('/bill/store', [BillController::class, 'store'])
    ->name('bill.store');

Route::get('/bill/{bill}/pdf', [BillController::class, 'generatePdf'])
    ->name('bill.pdf.generate');

Route::get('/bill/{bill}/pdf/send', [BillController::class, 'generateAndSendPdf'])
    ->name('bill.pdf.send');


