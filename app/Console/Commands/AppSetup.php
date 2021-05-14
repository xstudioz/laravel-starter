<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AppSetup extends Command
{
    protected $signature = 'command:name';

    protected $description = 'Command description';

    public function handle()
    {
        $this->createAdmins();
    }

    private function createAdmins()
    {
        
    }
}
