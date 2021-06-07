<?php

namespace App\View\Components;

use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Xstudioz\ImageResize;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use MyAppSettings;
use URL;

class HotelCard extends Component
{
  public Hotel $hotel;

  /**
   * HotelCard constructor.
   * @param $hotel
   */
  public function __construct($hotel) { $this->hotel = $hotel; }

  public function getLink(): string
  {
    return URL::to('hotels-in-' . $this->hotel->city->slug, [$this->hotel->slug]);
  }

  public function threeAmenties()
  {
    return $this->hotel->amenities()->limit(3)->get();
  }

  public function extraAmenties()
  {
    return $this->hotel->amenities->count() - 3;
  }

  public function image($width = 400)
  {
    return ImageResize::resize($this->hotel->banner, $width);
  }

  public function displayPrice()
  {
    $p = HotelRoom::whereHotelId($this->hotel->id)->select([DB::raw('min(price) as price')])->first()->price;
    $tax = $p * MyAppSettings::taxRate() / 100;
    return ($p + $tax);
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('components.hotel-card');
  }
}
