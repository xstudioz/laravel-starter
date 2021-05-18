<?php


namespace App\Repositories;


use App\Http\Requests\AddHotelRequest;
use App\Models\Hotel;
use App\Models\HotelRoom;
use Arr;
use Illuminate\Database\Eloquent\Model;

class HotelRepository extends BaseRepository
{
    function addNewHotel(AddHotelRequest $request)
    {
        $id = request()->id;
        $fields = [
            'address', 'available', 'banner', 'city_id', 'seo', 'content', 'couple_friendly', 'manager_email',
            'map_location', 'name', 'nearby_places', 'policy', 'rating', 'slug', 'status', 'contact_information'
        ];

        $hotel = $id ? Hotel::findOrFail($id) : new Hotel();
        $this->populate($fields, $hotel);
        $hotel->save();

        // hotel saved now we save  rooms
        foreach ($request->rooms as $room) {
            $attributes = Arr::only($room, (new HotelRoom)->getFillable());
            $attributes['hotel_id'] = $hotel->id;
            if ($room['id']) {
                $createdRoom = HotelRoom::findOrFail($room['id']);
                $createdRoom->update($attributes);
            } else {
                $createdRoom = HotelRoom::create($attributes);
            }
            // we sync the amenities
            $createdRoom->amenities()->sync($room['amenities']);

        }

//all good
        return $hotel;
    }

}
