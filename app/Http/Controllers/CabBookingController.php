<?php

namespace App\Http\Controllers;
use App\Models\CabBooking;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class CabBookingController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = CabBooking::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['booking_id','cab_id','cab_type','days','distance','distance_charge','drop_location','halting_charge','number_of_passengers','pickup_location','pickup_time','return_pickup_time','tax_amount','tax_rate','trip_type','user_id'];
        $cabBooking = $id ? CabBooking::findOrFail($id) : new CabBooking();
        $this->populate($fields,$cabBooking);

        $cabBooking->save();
        return ResponseHelper::success("CabBooking Updated", ['item' => $cabBooking]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            CabBooking::findOrFail($id)->delete();
            return ResponseHelper::success("CabBooking Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
