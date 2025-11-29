<?php

namespace App\Addons\Faq;

use \App\Extensions\BaseAddonServiceProvider;
use App\Core\Menu\AdminMenuItem;
use App\Core\Admin\Dashboard\AdminCountWidget;
use Illuminate\Support\Facades\Route;
use App\Addons\Faq\Controllers\Admin\FaqController;
use App\Addons\Faq\Database\Seeders\FaqSeeder;

class FaqServiceProvider extends BaseAddonServiceProvider
{
    protected string $uuid = "faq";
    protected string $name = 'faq';
    protected string $version = '1.0.0';

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadTranslations(); 
        $this->loadMigrations();
        $this->loadViews();
        $this->addSeeder(FaqSeeder::class);
        $this->app['settings']->addCardItem('personalization','faq','faq::messages.settings.title','faq::messages.settings.description','bi bi-gear',[FaqController::class, 'index'],'admin.settings.manage');
    }
    public function loadRoutes()
    {
        Route::middleware('web')->group(function () {
            require __DIR__.'/../routes/web.php';
        });

        Route::middleware(['web', 'admin'])
            ->prefix(admin_prefix())
            ->name('admin.')
            ->group(function () {
                Route::prefix('faq')->name('faq.')->group(function () {
                    require __DIR__.'/../routes/admin.php';
                });
            });
    }
}
