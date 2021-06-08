<?php
/** @var $booking Booking */

/** @var $room  HotelBooking */

use App\Models\Booking;
use App\Models\HotelBooking;
use App\Models\HotelRoom;

$priceLabels = [
  'amount' => 'Net Amount',
  'discount_amount' => "Discount",
  'tax_amount' => 'Tax',
  'final_price' => 'Net Payable'
]
?>
@extends('templates.account-template')
@section('account-content')
  <div class="box-with-shadow">
    <h2 class="title fw-bold">Booking #{{$booking->id}}
      <small class="d-block" style="font-size: 14px;">{{formatToIndianTime($booking->created_at,'dS M Y @ h:i a')}}</small>
    </h2>
    <div class="content">
      <table class="booking-table ">
        @if(count($booking->hotelBooking)>0)
          <tr style="background-color: #F6F6F6;">
            <td>
              <small class="d-block">HOTEL</small>
              <h5 class="fw-bold text-success mb-0"> {{$booking->hotelBooking[0]->hotel->name}}</h5>
              <small class="d-block">Check in : {{formatToIndianTime($booking->hotelBooking[0]->check_in)}}</small>
              <small class="d-block">Check out : {{formatToIndianTime($booking->hotelBooking[0]->check_out)}}</small>
            </td>
            <td>
              @foreach($booking->hotelBooking as $room)
                <div><i class="fa fa-bed me-2"></i>{{$room->room_type}} <span class="fw-bold">({{$room->number_of_rooms}}x)</span></div>
              @endforeach
            </td>
            <td class="text-end">{{amountWithSymbol($booking->getHotelTotal())}}</td>
          </tr>
        @endif
        @if($booking->cabBooking)
          <tr style="background-color: #e5e5e5;">
            <td>
              <small class="d-block">Cab</small>
              <h4 class="fw-hold text-success">{{$booking->cabBooking->cab_type}}</h4>
            </td>
            <td>
              <ul class="list-unstyled">
                <li class="justify-content-between d-flex">
                  <div>Trip Type</div>
                  <div>{{$booking->cabBooking->trip_type}}</div>
                </li>
                <li class="d-flex justify-content-between">
                  <div>Pickup Location</div>
                  <div>{{$booking->cabBooking->pickup_location}}</div>
                </li>
                <li class="d-flex justify-content-between">
                  <div>Drop Location</div>
                  <div>{{$booking->cabBooking->drop_location}}</div>
                </li>
                <li class="d-flex justify-content-between">
                  <div>Pickup Time</div>
                  <div>{{formatToIndianTime($booking->cabBooking->pickup_time,'dS M Y @ h:i a')}}</div>
                </li>
                <li class="d-flex justify-content-between">
                  <div>Return Pickup Time</div>
                  <div>{{formatToIndianTime($booking->cabBooking->return_pickup_time,'dS M Y @ h:i a')}}</div>
                </li>
                <li class="d-flex justify-content-between">
                  <div>Distance (approx)</div>
                  <div>{{ $booking->cabBooking->total_distance/1000 }}kms</div>
                </li>


              </ul>
            </td>
            <td class="text-end">{{amountWithSymbol($booking->cabBooking->getTotalAmount())}}</td>
          </tr>
        @endif

        <tr>
          <td>
          </td>
          <td colspan="2" class="plist">
            @foreach($priceLabels as $l=>$v)
              <div class="d-flex justify-content-between">
                <div>{{$v}}</div>
                <div>{{amountWithSymbol($booking->{$l})}}</div>
              </div>
            @endforeach
            <div class="d-flex justify-content-between">
              <div>Payment Mode</div>
              <div>{{$booking->payment_mode}}</div>
            </div>
            <div class="d-flex justify-content-between">
              <div>Status</div>
              <div><span class="b-label {{strtolower($booking->status)}}">{{$booking->status}}</span></div>
            </div>
          </td>
        </tr>

      </table>
    </div>
  </div>



@endsection
