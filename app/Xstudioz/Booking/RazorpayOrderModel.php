<?php


namespace App\Xstudioz\Booking;


use App\Xstudioz\Traits\FromArray;

class RazorpayOrderModel
{
  use FromArray;

  public $id; //String
  public $entity; //String
  public $amount; //int
  public $amount_paid; //int
  public $amount_due; //int
  public $currency; //String
  public $receipt; //String
  public $offer_id; //array( undefined )
  public $status; //String
  public $attempts; //int
  public $notes;  //array( undefined )
  public $created_at; //int

}
