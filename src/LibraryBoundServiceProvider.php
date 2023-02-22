<?php

namespace Kfpl\LibraryBound;

use Illuminate\Support\ServiceProvider;
use SoapClient;

class LibraryBoundServiceProvider extends ServiceProvider
{
    protected bool $defer = true;

    public function boot(): void
    {
        $this->publishes(
            [__DIR__.'/../config/librarybound.php' => config_path('librarybound.php')],
            'librarybound'
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/librarybound.php', 'librarybound');

        $this->app->singleton('librarybound', function ($app) {
            $config = $app->make('config');

            return new LibraryBoundClient(
                new SoapClient($config->get('librarybound.url') . '?wsdl'),
                $config->get('librarybound.url'),
                $config->get('librarybound.user'),
                $config->get('librarybound.password')
            );
        });
    }

    public function provides(): array
    {
        return ['librarybound'];
    }
}
