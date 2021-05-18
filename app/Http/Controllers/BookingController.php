<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class BookingController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Booking::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = [/*field*/];
        $booking = $id ? Booking::findOrFail($id) : new Booking();
        $this->populate($fields,$booking);

        $booking->save();
        return ResponseHelper::success("Booking Updated", ['item' => $booking]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Booking::findOrFail($id)->delete();
            return ResponseHelper::success("Booking Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
