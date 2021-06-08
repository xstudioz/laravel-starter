<?php
/** @var $payment Payment */

use Razorpay\Api\Payment;

?>@extends('templates.master')
@section('content')
  @if($booking->status=='paid')
    <h1 class="pay-success">Payment Successful</h1>
    <div class="container py-5">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img src="{{asset('images/checked.svg')}}" style="width: 100px;" class="d-block mx-auto" alt="">
          <h3 class="fw-bold mt-4">Thank You!</h3>
          <p>Your booking has been confirmed.</p>
          <a href="{{route('booking.view',[$booking->guid])}}" class="xs-btn-orange">View Your Booking</a>
        </div>
      </div>
    </div>
  @elseif($booking->status=='booked')
    <h1 class="pay-success">Booking Successful</h1>
    <div class="container py-5">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img src="{{asset('images/checked.svg')}}" style="width: 100px;" class="d-block mx-auto" alt="">
          <h3 class="fw-bold mt-4">Thank You!</h3>
          <p>Your booking has been confirmed.</p>
          <a href="{{route('booking.view',[$booking->guid])}}" class="xs-btn-orange">View Your Booking</a>
        </div>
      </div>
    </div>
  @else
    <h1 class="pay-failed">Payment Failed</h1>
    <div class="container py-5">
      <div class="row">
        <div class="col-sm-12 text-center">
          <img src="{{asset('images/close.svg')}}" style="width: 100px;" class="d-block mx-auto" alt="">
          <h3 class="fw-bold mt-4 text-danger">OOPs Somthing went wrong!</h3>
          <p>Your payment was not processed.Pleas try again</p>
        </div>
      </div>
    </div>
  @endif

@endsection
