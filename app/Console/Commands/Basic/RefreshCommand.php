<?php

namespace App\Console\Commands\Basic;

use Illuminate\Console\Command;

class RefreshCommand extends Command
{
    protected $signature = 'app:refresh';

    protected $description = 'Refresh app';

    public function handle()
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

//        \Storage::deleteDirectory('images/comments');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
    }
}
