<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function populate($fields, &$object, $setToNullIfEmpty = false)
    {
        foreach ($fields as $field) {
            if (request()->exists($field)) {
                $object[$field] = request()->input($field);
            } else {
                if ($setToNullIfEmpty) $object[$field] = null;
            }
        }
    }
}
