<?php

namespace App\Console\Commands;

use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
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
    $this->customSetup();
    $this->seeders();
  }

  function setupRoles()
  {
    //create permisssions
    Permission::create(['name' => 'backend:login']);
    Permission::create(['name' => 'settings:save']);

    /** @var Role $role */
    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo('backend:login');
    $role->givePermissionTo('settings:save');

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

  private function customSetup()
  {

  }

  private function seeders()
  {
    Artisan::call('db:seed --class=CitySeeder', []);
    Artisan::call('db:seed --class=AmenitySeeder', []);
    Artisan::call('db:seed --class=HotelSeeder', []);
    Artisan::call('db:seed --class=CouponSeeder', []);
    Artisan::call('db:seed --class=CabSeeder', []);

    //
    settings()->set(['tax' => 18, 'currency' => '₹'])->save();

  }
}
