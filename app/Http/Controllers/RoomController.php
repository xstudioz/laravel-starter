<?php

namespace App\Http\Controllers;
use App\Models\Room;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class RoomController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Room::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = [];
        $room = $id ? Room::findOrFail($id) : new Room();
        $this->populate($fields,$room);

        $room->save();
        return ResponseHelper::success("Room Updated", ['item' => $room]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Room::findOrFail($id)->delete();
            return ResponseHelper::success("Room Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
