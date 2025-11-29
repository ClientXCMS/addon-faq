<?php

use App\Addons\Faq\Controllers\Admin\FaqController;

Route::get('/', [FaqController::class, 'index'])->name('index');

Route::get('/create', [FaqController::class, 'create'])->name('create');
Route::post('/store', [FaqController::class, 'store'])->name('store');
Route::get('/{faq}', [FaqController::class, 'show'])->name('show');
Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
Route::post('/faq/{faq}/translations', [FaqController::class, 'translations'])->name('translations');

Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');