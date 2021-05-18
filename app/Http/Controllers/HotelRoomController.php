<?php

namespace App\Http\Controllers;
use App\Models\HotelRoom;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class HotelRoomController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = HotelRoom::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['capacity','hotel_id','name','number_of_rooms','price'];
        $hotelRoom = $id ? HotelRoom::findOrFail($id) : new HotelRoom();
        $this->populate($fields,$hotelRoom);

        $hotelRoom->save();
        return ResponseHelper::success("HotelRoom Updated", ['item' => $hotelRoom]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            HotelRoom::findOrFail($id)->delete();
            return ResponseHelper::success("HotelRoom Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
