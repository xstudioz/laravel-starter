<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MakePermissions extends Command
{
  protected $signature = 'make:per';

  protected $description = 'Command description';

  public function handle()
  {
    $admin = Role::where(['name' => 'admin'])->first();


    $permissions = [
      'settings:save'
    ];
    foreach ($permissions as $permission) {
      try {
        Permission::create(['name' => $permission, 'guard_name' => 'api']);
        $admin->givePermissionTo($permission);
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }


  }
}
