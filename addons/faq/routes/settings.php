<?php

use App\Addons\Faq\Controllers\Admin\FaqSettingsController;

Route::get('/faq', [FaqSettingsController::class, 'settings'])->name('faq.settings');
Route::put('/faq', [FaqSettingsController::class, 'update'])->name('faq.settings.update');
