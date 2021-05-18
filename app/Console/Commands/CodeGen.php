<?php

namespace App\Console\Commands;

use App;
use App\Models\User;
use Artisan;
use File;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Route;

class CodeGen extends Command
{
    protected $signature = 'make:item {name}';

    protected $description = 'Command description';

    public function handle()
    {
        $name = $this->argument('name');
        $items = explode(',', $name);

        foreach ($items as $name2) {
            $this->createModels($name2);
            $this->createController($name2);
            $this->createRepository($name2);
            $this->createApiRules($name2);
            $this->fillColumns($name2);
        }


    }

    function createController($name)
    {
        $content = File::get(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'file.txt');
        $content = str_replace('#class#', $name, $content);
        $content = str_replace('#snakeClass#', '$' . Str::camel($name), $content);
        $content = str_replace('#name#', $name, $content);

        if (!file_exists(app_path('Http/Controllers/' . $name . 'Controller.php'))) {
            File::put('app/Http/Controllers/' . $name . 'Controller.php', $content);
        } else {
            echo 'Controller Exist' . "\n";
        }
    }

    private function createRepository($name)
    {
        $repoContent = File::get(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'repo.txt');
        $repoContent = str_replace('#name#', $name, $repoContent);
        if (!file_exists(app_path('Repositories/' . $name . 'Repository.php'))) {
            File::put('app/Repositories/' . $name . 'Repository.php', $repoContent);
        } else {
            echo 'Repo Exist' . "\n";
        }
    }

    private function createModels($name)
    {
        if (!file_exists(app_path('Models/' . $name . '.php'))) {
            Artisan::call("make:model {$this->argument('name')}");
            Artisan::call('ide-helper:models -W');
        } else {
            echo 'Model Exist' . "\n";
        }
    }

    private function createApiRules($name)
    {
        $apiPath = base_path('routes/api.php');
        $api = file_get_contents($apiPath);
        $dashed = Str::snake($name, '-');

        if (strpos($api, "$dashed/index") > -1) return;


        $r = [];
        $r[] = "Route::post('$dashed/index',[App\\Http\\Controllers\\{$name}Controller::class,'index']);";
        $r[] = "Route::post('$dashed/create',[App\\Http\\Controllers\\{$name}Controller::class,'create']);";
        $r[] = "Route::post('$dashed/destroy',[App\\Http\\Controllers\\{$name}Controller::class,'destroy']);";
        $r[] = "//admin";
        $newContent = str_ireplace('//admin', implode("\n", $r), $api);
        file_put_contents($apiPath, $newContent);
    }

    private function fillColumns($name)
    {
        $nameSpace = "App\\Models\\$name";
        $table = (new $nameSpace())->getTable();
        $columns = array_values(DB::getSchemaBuilder()->getColumnListing($table));
        $controllerFile = app_path('Http/Controllers/' . $name . 'Controller.php');
        $content = file_get_contents($controllerFile);
        $excluded = ['created_at', 'updated_at', 'id', 'deleted_at'];
        $finalFields = array_diff($columns, $excluded);
        $finalFields = array_map(function ($i) { return "'$i'"; }, $finalFields);
        file_put_contents($controllerFile, str_ireplace('/*field*/', implode(',', $finalFields), $content));

    }
}
