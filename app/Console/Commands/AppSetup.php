<?php

namespace App\Console\Commands;

use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AppSetup extends Command
{
    protected $signature = 'app:setup';

    protected $description = 'Command description';

    public function handle()
    {
        $this->clearData();
        $this->setupRoles();
        $this->createAdmins();
    }

    function setupRoles()
    {
        Role::create(['name' => 'admin']);
    }

    function clearData()
    {
        Artisan::call('migrate:fresh');
    }

    private function createAdmins()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@test.com';
        $user->password = 'password';
        $user->name = 'Admin Sidhu';
        $user->save();
        $user->assignRole('admin');

    }
}
