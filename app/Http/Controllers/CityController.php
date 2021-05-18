<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class CityController extends Controller
{
    use SortNSearch;

    function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = City::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['banner', 'content', 'name', 'seo', 'slug', 'state_id', 'status'];
        $city = $id ? City::findOrFail($id) : new City();
        $this->populate($fields, $city);

        $city->save();
        return ResponseHelper::success("City Updated", ['item' => $city]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            City::findOrFail($id)->delete();
            return ResponseHelper::success("City Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
