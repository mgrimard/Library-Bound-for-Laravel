<?php

namespace Kfpl\LibraryBound\Test;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Kfpl\LibraryBound\LibraryBoundFacade;
use Kfpl\LibraryBound\LibraryBoundServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../', '.env.test');
        $dotenv->load();

        parent::setUp();
//        Http::preventStrayRequests();
    }

    protected function getPackageProviders($app)
    {
        return [
            LibraryBoundServiceProvider::class,
        ];
    }

    /**
     * Load package alias
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app) {
        return [
            'LibraryBound' => LibraryBoundFacade::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //
    }
}
