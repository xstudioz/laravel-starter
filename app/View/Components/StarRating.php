<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StarRating extends Component
{
  public $rating;

  /**
   * StarRating constructor.
   */
  public function __construct($rating)
  {
    $this->rating = $rating;
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('components.star-rating');
  }
}
