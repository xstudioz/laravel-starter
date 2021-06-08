<?php
/** @var  $booking App\Xstudioz\Booking\BookingModel */
?>
@extends('templates.master')
@section('content')
  <div class="container py-5">
    <div class="row" id="appReview">
      <div class="cols-sm-12">
        <h4 class="fw-bold mb-4">Review your booking</h4>
        <div class="box-with-shadow">
          <div class="content">
            @if($booking->hotelItem)
              <h4 class="title fw-bold">Hotel Booking Details</h4>
              <h5 class="fw-bold text-primary">{{$booking->hotelItem->hotel->name}}</h5>
              <small class="d-block"><i class="me-2 fa fa-arrow-right"></i>Check In : {{$booking->hotelItem->in->format('D, d M Y')}}</small>
              <small class="d-block"><i class="me-2 fa fa-arrow-left"></i>Check Out : {{$booking->hotelItem->out->format('D, d M Y')}}</small>
              <h5 class="mt-4 fw-bold">Rooms</h5>
              <ul class="list-unstyled">
                @foreach($booking->hotelItem->rooms as  $room)
                  <li class="d-flex py-2 justify-content-between">
                    <span> {{$room->name}} <strong class="text-primary">({{$room->numberOfRooms}}x)</strong></span>
                    <span>{{amountWithSymbol($room->numberOfRooms * $room->price)}}</span>
                  </li>
                @endforeach
              </ul>
            @endif

            @if($booking->cabItem)
              <h4 class="mt-5 title">Cab Booking Details</h4>
              <div class="content">
                <h5 class="fw-bold text-primary">{{$booking->cabItem->getCab()->name}}</h5>
                <small class="d-block"><i class="me-2 fa fa-car"></i>Trip Type : {{$booking->cabItem->getTripType()}}</small>
                <small class="d-block"><i class="me-2 fa fa-arrow-right"></i>Departure : {{$booking->cabItem->getStartDateTime()->format('D, d M Y h:s a')}}</small>
                @if($booking->cabItem->getTripType() === 'round')
                  <small class="d-block"><i class="me-2 fa fa-arrow-left"></i>Return : {{$booking->cabItem->getReturnDateTime()->format('D, d M Y h:s a')}}</small>
                @endif

                <i class="fa fa-map-marker me-2"></i>{{$booking->cabItem->getPickupLocation()}} <i class="fa fa-arrow-right mx-2"></i> {{$booking->cabItem->getDropLocation()}}
                <div>Distance : {{$booking->cabItem->getDistance() * $booking->cabItem->getDistanceMultiplier() /1000}} kms</div>
                <div class="d-flex justify-content-between">
                  <span>Base Charges</span>
                  <span>{{amountWithSymbol($booking->cabItem->getBaseAmount())}}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Distance Charges</span>
                  <span>{{amountWithSymbol($booking->cabItem->getDistanceAmount())}}</span>
                </div>

                <coupon @updated="updated()" :code="'{{$booking->coupon?$booking->coupon->code:''}}'" url="{{route('booking.coupon.web')}}"></coupon>


                <div class="mt-5"></div>
                <div class="d-flex justify-content-between">
                  <span>Sub Total</span>
                  <span>{{amountWithSymbol($booking->getBasePrice())}}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Discount</span>
                  <span>{{amountWithSymbol($booking->getDiscount())}}</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span>Tax</span>
                  <span>{{amountWithSymbol($booking->getTax())}}</span>
                </div>
                <div class="d-flex justify-content-between border-top mt-3 pt-3">
                  <span>Final Amount</span>
                  <span class="text-success fw-bold">{{amountWithSymbol($booking->getFinalPrice())}}</span>
                </div>
              </div>
            @endif

            <ul class="payment-gateways d-flex list-unstyled mt-3">
              <li><a @click="selectGateway('online')" :class="{active:gateway=='online'}"><i class="fa fa-check me-2"></i>Pay Online</a></li>
              <li><a @click="selectGateway('offline')" :class="{active:gateway=='offline'}"><i class="fa fa-check me-2"></i>Pay in cash</a></li>
            </ul>
            <button class="xs-btn-orange d-block w-100 text-center" @click="createOrder()">Pay Now</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer-scripts')
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

  <script>
    var appReview = new Vue({
      el: '#appReview',
      data: function () {
        return {
          gateway: 'online',
        }
      },
      methods: {
        pay: function (optionFromServer) {
          console.log(optionFromServer);
          var options = {
            ...optionFromServer,
            callback_url: '{{route('booking.payment.callback')}}',
          };
          var rzp1 = new Razorpay(options);
          rzp1.open();
        },
        createOrder: function () {
          showLoader();
          var _this = this;
          axios.post('{{route('booking.create')}}', {payment_mode: this.gateway})
            .then(function (res) {
              _this.pay(res.data)
            })
            .catch(function (e) {
            })
            .then(function () {
              hideLoader();
            })
        },
        selectGateway: function (g) {
          this.gateway = g
        },
        updated: function () {
          window.location.href = '{{route('booking.review')}}';
        }
      }
    })
  </script>
@endsection
