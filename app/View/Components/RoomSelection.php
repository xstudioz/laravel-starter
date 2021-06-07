<?php

namespace App\View\Components;

use App\Models\HotelRoom;
use App\Xstudioz\Booking\BookingModel;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RoomSelection extends Component
{

  public Collection $rooms;
  public BookingModel $booking;

  /**
   * RoomSelection constructor.
   * @param Collection $rooms
   * @param BookingModel $booking
   */
  public function __construct(Collection $rooms, BookingModel $booking)
  {
    $this->rooms = $rooms;
    $this->booking = $booking;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('components.room-selection');
  }

  public function getInitRooms($roomId): int
  {
    if (!$this->booking->hotelItem) return 0;
    $rooms = $this->booking->hotelItem->rooms;
    if (count($rooms) == 0) return 0;
    foreach ($rooms as $r) {
      if ($r->roomId == $roomId) return $r->numberOfRooms;
    }
    return 0;
  }
}
