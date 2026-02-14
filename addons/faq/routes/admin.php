<?php

use App\Addons\Faq\Controllers\Admin\FaqController;
use App\Addons\Faq\Controllers\Admin\FaqCategoryController;

Route::get('/', [FaqController::class, 'index'])->name('index');

Route::get('/create', [FaqController::class, 'create'])->name('create');
Route::post('/store', [FaqController::class, 'store'])->name('store');
Route::post('/faq/{faq}/translations', [FaqController::class, 'translations'])->name('translations');

// Category routes — must be before /{faq} to avoid wildcard capture
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [FaqCategoryController::class, 'index'])->name('index');
    Route::get('/create', [FaqCategoryController::class, 'create'])->name('create');
    Route::post('/store', [FaqCategoryController::class, 'store'])->name('store');
    Route::get('/{category}', [FaqCategoryController::class, 'show'])->name('show');
    Route::put('/{category}', [FaqCategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [FaqCategoryController::class, 'destroy'])->name('destroy');
});

Route::get('/{faq}', [FaqController::class, 'show'])->name('show');
Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');
