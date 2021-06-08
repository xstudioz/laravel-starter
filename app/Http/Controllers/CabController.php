<?php

namespace App\Http\Controllers;
use App\Models\Cab;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class CabController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Cab::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['banner','capacity','distance_price','halting_charges','name'];
        $cab = $id ? Cab::findOrFail($id) : new Cab();
        $this->populate($fields,$cab);

        $cab->save();
        return ResponseHelper::success("Cab Updated", ['item' => $cab]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Cab::findOrFail($id)->delete();
            return ResponseHelper::success("Cab Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
