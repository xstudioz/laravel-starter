<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class IdeHelper extends Command
{
    protected $signature = 'ide:setup';

    protected $description = 'Command description';

    public function handle()
    {
        Artisan::call('ide-helper:models', ['W']);
    }
}
