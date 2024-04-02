<?php

namespace App\Console\Commands\Basic;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'app:install';

    protected $description = 'Install app';

    public function handle()
    {
        $this->call('storage:link');
        $this->call('migrate');

        return self::SUCCESS;
    }
}
