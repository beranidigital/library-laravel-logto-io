<?php

namespace BeraniDigital\LibraryLaravelLogtoIo\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use BeraniDigital\LibraryLaravelLogtoIo\LibraryLaravelLogtoIoServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BeraniDigital\\LibraryLaravelLogtoIo\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LibraryLaravelLogtoIoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_library-laravel-logto-io_table.php.stub';
        $migration->up();
        */
    }
}
