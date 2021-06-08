@extends('templates.account-template')
@section('account-content')
  <h4 class="mb-4 fw-bold">My Bookings</h4>
  <div class="row">
    @foreach($bookings as $booking)
      <div class="col-sm-6">
        <x-user-booking-card :booking="$booking"></x-user-booking-card>
      </div>
    @endforeach
  </div>
@endsection
