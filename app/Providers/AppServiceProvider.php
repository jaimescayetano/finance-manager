<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

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
        FilamentColor::register([
            'danger' => '#f9321a',
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => '#0CB7F2',
            'success' => '#72f205',
            'warning' => Color::Amber,
        ]);
    }
}
