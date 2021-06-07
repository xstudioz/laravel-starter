<?php


namespace App\Repositories;


use App\Http\Requests\AddHotelRequest;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use App\Xstudioz\HotelFilter;
use Arr;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

  function topHotels() { return Hotel::front()->with(['city', 'amenities'])->limit(10)->get(); }

  public function search(HotelFilter $filter): LengthAwarePaginator
  {
    $in = $filter->getCheckInDate();
    $out = $filter->getCheckOutDate();

    //
    $bookedRooms = HotelBooking::query()
      ->booked($in, $out)
      ->select(['hotel_id', DB::raw('sum(number_of_rooms) as bookedTotal')])
      ->groupBy('hotel_id');
    $totalRoomsQuery = HotelRoom::query()->select(['hotel_id', DB::raw('sum(number_of_rooms) as totalRooms')])->groupBy('hotel_id');
    $query = Hotel::query();
    $query->select(['hotels.*', 'totalRooms', 'bookedTotal',
      DB::raw('(totalRooms-bookedTotal) as available_rooms'),
    ]);
    // $query->with(['city']);
    $query->joinSub($bookedRooms, 'bookedRooms', 'hotels.id', '=', 'bookedRooms.hotel_id', 'left');
    $query->joinSub($totalRoomsQuery, 'totalRooms', 'hotels.id', '=', 'totalRooms.hotel_id');
    $query->where(function ($query) use ($filter) {
      $query->where(DB::raw('(totalRooms-bookedTotal)'), '>', count($filter->getRooms()));
      $query->orWhereNull(DB::raw('(totalRooms-bookedTotal)'));
    });
    return $query->latest('id')->paginate(12); //


  }

  public function similarHotels($cityId, array $excludeHotelId, $count = 10)
  {
    return Hotel::front()->where(['city_id' => $cityId])->whereNotIn('id', [$excludeHotelId])->limit($count)->get();
  }

  public function hotelBySlug($hotelSlug, Carbon $checkInDate = null, Carbon $checkOutDate = null)
  {
    $hotel = Hotel::front()->with(['rooms'])
      ->where(['slug' => $hotelSlug])
      ->first();
    if (empty($hotel)) throw new NotFoundHttpException();

    //get available rooms
    if ($checkInDate && $checkOutDate) {
      $hotel->rooms->each(function (HotelRoom $room) use ($checkInDate, $checkOutDate) {
        $bookedRoom = HotelBooking::whereHotelId($room->hotel_id)
          ->booked($checkInDate, $checkOutDate)
          ->where('hotel_room_id', $room->id)
          ->count();
        $room->available_rooms = $room->number_of_rooms - $bookedRoom;
      });
    }

    return $hotel;
  }
}
