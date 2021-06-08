<?php


namespace App\Repositories;


use App\Models\Cab;
use App\Xstudioz\CabFilter;

class CabRepository
{

  public function search(CabFilter $cabFilter)
  {
    $q = Cab::front();
    $q->where('capacity', '>=', $cabFilter->getPassengers());
    return $q->get();

  }
}
