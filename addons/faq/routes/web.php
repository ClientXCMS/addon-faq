<?php

use App\Addons\Faq\Controllers\Client\FaqController;

Route::prefix('faq')->name('client.faq.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('index');
    Route::get('/group/{group:slug}', [FaqController::class, 'group'])->name('group');
    Route::get('/product/{product}', [FaqController::class, 'product'])->name('product');
    Route::post('/{faq}/usefulness', [FaqController::class, 'usefulness'])->name('usefulness')->middleware('throttle:10,1');
});
