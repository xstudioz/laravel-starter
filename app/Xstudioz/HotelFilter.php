<?php


namespace App\Xstudioz;


use App\Models\City;
use Carbon\Carbon;
use Session;
use stdClass;
use Str;
use function Aws\filter;

class HotelFilter
{
  private ?Carbon $checkInDate = null;
  private ?Carbon $checkOutDate = null;
  private ?City $city = null;
  private array $rooms;
  private $combo;
  private $filterKey = 'hotel-filter-x';

  function load()
  {
    $s = Session::get($this->filterKey);
    if ($s == null) {
      $this->setCheckInDate(Carbon::now()->timezone('Asia/Kolkata'));
      $this->setCheckOutDate(Carbon::now()->timezone('Asia/Kolkata')->addDay());
      return $this;
    }
    return $s;
  }

  function save()
  {
    $c = $this;
    Session::put($this->filterKey, $this);
    Session::save();
  }

  public function clear()
  {
    Session::forget($this->filterKey);
  }

  public function __construct()
  {
    //$this->init();
  }

  /**
   * @param Carbon|null $checkInDate
   * @return HotelFilter
   */
  public function setCheckInDate(?Carbon $checkInDate): HotelFilter
  {
    $this->checkInDate = $checkInDate;
    return $this;
  }

  /**
   * @param Carbon|null $checkOutDate
   * @return HotelFilter
   */
  public function setCheckOutDate(?Carbon $checkOutDate): HotelFilter
  {
    $this->checkOutDate = $checkOutDate;
    return $this;
  }

  /**
   * @param City|null $city
   * @return HotelFilter
   */
  public function setCity(?City $city): HotelFilter
  {
    $this->city = $city;
    return $this;
  }

  /**
   * @param mixed $combo
   * @return HotelFilter
   */
  public function setCombo($combo)
  {
    $this->combo = $combo;
    return $this;
  }

  /**
   * @param array $rooms
   * @return HotelFilter
   */
  public function setRooms(array $rooms): HotelFilter
  {
    $this->rooms = $rooms;
    return $this;
  }

  private function init()
  {
    $exists = session()->exists($this->filterKey);
    if ($exists) {
      $this->_initProperties();;
      return;
    }

    $room = new stdClass();
    $room->id = 'x';
    $room->guests = 1;

    $freshFilter = [
      'city' => null,
      'check_in_date' => Carbon::now('Asia/Kolkata'),
      'check_out_date' => Carbon::now('ASIA/Kolkata')->addDay(),
      'rooms' => [
        $room
      ],
    ];
    session()->put($this->filterKey, $freshFilter);
    session()->save();
    $this->_initProperties();;

  }

  public function getCheckInDate(): Carbon
  {
    return $this->checkInDate ?? Carbon::now()->timezone('Asia/Kolkata');
  }

  public function getCheckOutDate(): Carbon
  {
    return $this->checkOutDate ?? Carbon::now()->timezone('Asia/Kolkata')->addDay();
  }

  public function getCity()
  {
    return $this->city;
  }

  public function isCombo(): bool
  {
    return $this->combo ?? false;
  }

  public function getRooms()
  {
    $r = new stdClass();
    $r->id = 'x';
    $r->guests = 1;
    $x = $this->rooms ?? [$r];
    return $x;
  }

  function update($city, $rooms, Carbon $checkInDate, Carbon $checkOutDate, $combo)
  {
    session()->put($this->filterKey, [
      'city' => $city,
      'checkInDate' => $checkInDate,
      'checkOutDate' => $checkOutDate,
      'rooms' => $rooms,
      'combo' => $combo
    ]);
    session()->save();

    $this->_initProperties();;

  }

  private function _initProperties()
  {
    $filter = Session::get($this->filterKey);
    foreach ($filter as $k => $item) {
      $this->{\Illuminate\Support\Str::camel($k)} = $item;
    }
  }

}
