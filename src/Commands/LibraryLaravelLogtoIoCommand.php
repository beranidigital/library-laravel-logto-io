<?php

namespace BeraniDigital\LibraryLaravelLogtoIo\Commands;

use Illuminate\Console\Command;

class LibraryLaravelLogtoIoCommand extends Command
{
    public $signature = 'library-laravel-logto-io';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
