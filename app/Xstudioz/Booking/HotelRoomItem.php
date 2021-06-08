<?php


namespace App\Xstudioz\Booking;


class HotelRoomItem
{
  public int $roomId;
  public int $numberOfRooms;
  public float $price;
  public string $name;

  /**
   * HotelRoomItem constructor.
   * @param int $roomId
   * @param int $numberOfRooms
   * @param float $price
   */
  public function __construct(int $roomId, int $numberOfRooms, float $price, string $name)
  {
    $this->roomId = $roomId;
    $this->numberOfRooms = $numberOfRooms;
    $this->price = $price;
    $this->name = $name;
  }
}
