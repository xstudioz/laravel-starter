<?php


namespace App\Xstudioz\Booking;


use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Room;
use Carbon\Carbon;
use MongoDB\Driver\Session;

class HotelItem
{
  public Hotel $hotel;
  public Carbon $in;
  public Carbon $out;
  public array $rooms;

  private int $days;
  private float $price;

  /**
   * HotelItem constructor.
   * @param Hotel $hotel
   * @param Carbon $in
   * @param Carbon $out
   * @param HotelRoomItem[] $rooms
   */
  public function __construct(Hotel $hotel, Carbon $in, Carbon $out, array $rooms)
  {
    $this->hotel = $hotel;
    $this->in = $in;
    $this->out = $out;
    $this->rooms = $rooms;

    $this->days = $this->in->diffInDays($out);
    $this->calculatePrice();

  }

  private function calculatePrice()
  {
    $amount = 0;
    foreach ($this->rooms as $room) {
      $amount += $room->price * $this->days * $room->numberOfRooms;
    }
    $this->price = $amount;
  }

  public function getPrice(): float
  {
    return $this->price;
  }

  public function addOrUpdateRooms($updatedRooms)
  {
    foreach ($updatedRooms as $updatedRoom) {
      $exist = false;
      $rr = null;
      foreach ($this->rooms as &$room) {
        if ($room->roomId == $updatedRoom['id']) {
          $exist = true;
          $rr = $room;
          break;
        }
      }
      if ($exist) {
        $rr->numberOfRooms = $updatedRoom['number_of_rooms'];
      } else {
        //we will create a room
        $roomModel = HotelRoom::whereId($updatedRoom['id'])->first();
        $this->rooms[] = new HotelRoomItem($roomModel->id, $updatedRoom['number_of_rooms'], $roomModel->price, $roomModel->name);
      }
    }
    $this->calculatePrice();
  }

}
