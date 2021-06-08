<?php
/** @var $cabFilter \App\Xstudioz\CabFilter */
/** @var $booking App\Xstudioz\Booking\BookingModel */
/** @var $cabPriceCalculator App\Xstudioz\Cab\CabPriceCalculator */

?>
@extends('templates.master')
@section('content')

  <div class="container py-5">
    <div class="row">
      <div class="col-sm-8">
        <div class="bg-white box-with-shadow">
          <h4 class="title">{{$cab->name}}</h4>
          <div class="content">
            <img src="{{resizeImage($cab->banner,1000)}}" class="img-fluid mb-4" alt="">
            {!! $cab->content !!}
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="box-with-shadow" id="cab-booking">
          <div class="labeled-div">
            <label for="">Pickup</label>
            <div>{{$booking->cabItem->getPickupLocation()}}</div>
          </div>
          <div class="labeled-div">
            <label for="">Drop Location</label>
            <div>{{$booking->cabItem->getDropLocation()}}</div>
          </div>
          <div class="d-flex justify-content-between">
            <div class="labeled-div">
              <label for="">Trip Type</label>
              <div>{{strtoupper($booking->cabItem->getTripType())}}</div>
            </div>
            <div class="labeled-div">
              <label for="">Passengers</label>
              <div>{{$booking->cabItem->getPassengers()}}</div>
            </div>
          </div>
          <div class="labeled-div">
            <label for="">Departure Date & Time</label>
            <div>{{$booking->cabItem->getStartDateTime()->timezone('Asia/Kolkata')->format('D, d M Y @ h:i a')}}</div>
          </div>
          @if($booking->cabItem->getTripType()=='round')
            <div class="labeled-div">
              <label for="">Return Date & Time</label>
              <div>{{$booking->cabItem->getReturnDateTime()->timezone('Asia/Kolkata')->format('D, d M Y @ h:i a')}}</div>
            </div>
          @endif

          <div class="d-flex justify-content-between">
            <div class="labeled-div">
              <label for="">Distance(approx)</label>
              <div>{{$booking->cabItem->getDistance()/1000}} Kms</div>
            </div>
            <div class="labeled-div">
              <label for="">Journey Time</label>
              <div>{{ secondsToTime( $booking->cabItem->getJourneyTime())}}</div>
            </div>

          </div>
          @if(!$booking->isCombo())
            <coupon @updated="updated()" code="{{$booking->coupon?$booking->coupon->code:''}}" url="{{route('booking.coupon.web')}}"></coupon>
          @endif
          <h5 class="fw-bold">Charges</h5>
          <div class="d-flex py-2 justify-content-between">
            <div>Base Charges</div>
            <div>{{amountWithSymbol($booking->cabItem->getBaseAmount())}}</div>
          </div>
          <div class="d-flex py-2 justify-content-between">
            <div>Distance Charges</div>
            <div>{{amountWithSymbol($booking->cabItem->getDistanceAmount())}}</div>
          </div>

          @if($booking->isCombo())
            @if($booking->hotelItem==null)
              <a href="" class="btn w-100 text-white mt-4 btn-primary p-3">Continue to hotel booking</a>
            @else
              <a href="{{route('booking.review')}}" class="btn w-100 text-white mt-4 btn-primary p-3">Review & Pay</a>
            @endif
          @else
            <div class="border my-2"></div>
            <div class="d-flex py-2 justify-content-between" v-for="(l,key) in labels" v-if="prices[key]>0">
              <div>@{{l}}</div>
              <div>@{{ amount(prices[key]) }}</div>
            </div>

            <ul class="payment-gateways d-flex list-unstyled mt-3">
              <li><a @click="selectGateway('online')" :class="{active:gateway=='online'}"><i class="fa fa-check me-2"></i>Pay Online</a></li>
              <li><a @click="selectGateway('offline')" :class="{active:gateway=='offline'}"><i class="fa fa-check me-2"></i>Pay in cash</a></li>
            </ul>
            <button class="xs-btn-orange d-block w-100 text-center" @click="createOrder()">Pay Now</button>
          @endif


        </div>
      </div>

    </div>
  </div>
  <script>
    new Vue({
      el: '#cab-booking',
      data: function () {
        return {
          gateway: 'online',
          labels: {
            basePrice: 'Total Price',
            discount: 'Discount',
            tax: 'Tax',
            finalPrice: 'Net Payable'
          },
          prices: {}
        }
      },
      mounted: function () {
        this.updated()
      },
      methods: {
        selectGateway: function (g) {
          this.gateway = g;
        },
        amount: function (amount) {
          return '{{MyAppSettings::currency()}}' + ' ' + amount
        },
        updated() {
          showLoader();
          var _this = this;
          axios.post('{{route('booking.calculate.web')}}')
            .then(function (res) {
              _this.prices = res.data;
            })
            .catch(function () {
            })
            .finally(function () {
              hideLoader();
            })
        },
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
        }
      }
    })
  </script>

@endsection
@section('scripts')
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endsection
