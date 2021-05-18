<?php

namespace App\Http\Controllers;
use App\Models\Amenity;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class AmenityController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Amenity::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['icon','name','type'];
        $amenity = $id ? Amenity::findOrFail($id) : new Amenity();
        $this->populate($fields,$amenity);

        $amenity->save();
        return ResponseHelper::success("Amenity Updated", ['item' => $amenity]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Amenity::findOrFail($id)->delete();
            return ResponseHelper::success("Amenity Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
