<?php

namespace App\Addons\Faq;

use App\Addons\Faq\Console\Commands\CleanupOrphanedSectionMetadataCommand;
use App\Addons\Faq\Services\FaqSectionRegistry;
use App\Extensions\BaseAddonServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Addons\Faq\Controllers\Admin\FaqController;
use App\Addons\Faq\Database\Seeders\FaqSeeder;

class FaqServiceProvider extends BaseAddonServiceProvider
{
    protected string $uuid = "faq";
    protected string $name = 'faq';
    protected string $version = '1.0.0';

    public function register(): void
    {
        // Singleton allowing themes to register FAQ sections: app('faq.sections')->register(...)
        $this->app->singleton('faq.sections', function () {
            return new FaqSectionRegistry();
        });
    }

    public function boot(): void
    {
        $this->loadRoutes();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadViews();
        $this->registerSettingsRoutes();
        $this->registerCommands();
        $this->app['extension']->addSeeder(FaqSeeder::class);
        $this->app['settings']->addCardItem(
            'personalization',
            'faq',
            'faq::messages.settings.title',
            'faq::messages.settings.description',
            'bi bi-gear',
            [FaqController::class, 'index'],
            'admin.settings.manage'
        );
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CleanupOrphanedSectionMetadataCommand::class,
            ]);
        }
    }
    public function loadRoutes(): void
    {
        try {
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
        } catch (\Throwable $e) {
            Log::error('FAQ addon: Failed to load routes', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }

    protected function registerSettingsRoutes(): void
    {
        try {
            Route::middleware(['web', 'admin'])
                ->prefix(admin_prefix('settings/extensions'))
                ->name('admin.')
                ->group(function () {
                    require __DIR__.'/../routes/settings.php';
                });
        } catch (\Throwable $e) {
            Log::error('FAQ addon: Failed to load settings routes', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
