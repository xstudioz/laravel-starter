<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddHotelRequest;
use App\Models\Hotel;
use App\Models\User;
use App\Repositories\HotelRepository;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class HotelController extends Controller
{
    use SortNSearch;

    function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Hotel::query();
        $query->with(['city', 'rooms', 'rooms.amenities']);
        // sample is test
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create(AddHotelRequest $request, HotelRepository $hotelRepository)
    {
        $hotel = $hotelRepository->addNewHotel($request);

        return ResponseHelper::success("Hotel Updated", ['item' => $hotel]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Hotel::findOrFail($id)->delete();
            return ResponseHelper::success("Hotel Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
