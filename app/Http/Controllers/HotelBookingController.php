<?php

namespace App\Http\Controllers;
use App\Models\HotelBooking;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class HotelBookingController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = HotelBooking::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['booking_id','check_in','check_out','hotel_id','hotel_room_id','number_of_rooms','room_price','room_type','tax_amount','tax_rate','total_days','user_id'];
        $hotelBooking = $id ? HotelBooking::findOrFail($id) : new HotelBooking();
        $this->populate($fields,$hotelBooking);

        $hotelBooking->save();
        return ResponseHelper::success("HotelBooking Updated", ['item' => $hotelBooking]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            HotelBooking::findOrFail($id)->delete();
            return ResponseHelper::success("HotelBooking Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
