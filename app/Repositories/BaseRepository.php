<?php


namespace App\Repositories;


class BaseRepository
{
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
