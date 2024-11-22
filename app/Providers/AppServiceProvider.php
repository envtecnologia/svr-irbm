<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Blade::directive('selected', function ($expression) {
            return "<?php echo ($expression) ? 'selected' : ''; ?>";
        });

        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
    }
}
