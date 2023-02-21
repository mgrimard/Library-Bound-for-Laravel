<?php

namespace Kfpl\LibraryBound;

use Illuminate\Support\ServiceProvider;

class LibraryBoundServiceProvider extends ServiceProvider
{
    protected bool $defer = true;

    public function boot(): void
    {
        $this->publishes(
            [__DIR__.'/../config/librarybound.php' => config_path('librarybound.php')],
            'LibraryBound'
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/librarybound.php', 'LibraryBound');

        $this->app->singleton('LibraryBound', function ($app) {
            $config = $app->make('config');

            return new LibraryBoundClient(
                $config->get('LibraryBound.url'),
                $config->get('LibraryBound.user'),
                $config->get('LibraryBound.password')
            );
        });
    }

    public function provides(): array
    {
        return ['LibraryBound'];
    }
}
