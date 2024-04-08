<?php

namespace BeraniDigital\LibraryLaravelLogtoIo;

use BeraniDigital\LibraryLaravelLogtoIo\Commands\LibraryLaravelLogtoIoCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LibraryLaravelLogtoIoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('library-laravel-logto-io')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_library-laravel-logto-io_table')
            ->hasCommand(LibraryLaravelLogtoIoCommand::class);
    }
}
