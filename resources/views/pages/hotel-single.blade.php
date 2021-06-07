<?php
use App\Xstudioz\Booking\BookingModel;
use App\Xstudioz\HotelFilter;
/** @var $booking BookingModel */
/** @var $hoteFilter HotelFilter */
?>
@extends('templates.master')
@section('content')

  <div id="wrapper" class="hotel-listing-wrapper">
    <!--  content-->
    <div class="content">
      <!--  carousel-->
      <div class="swiper-container" id="main-hotel-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
          <?php foreach ($roomImages as $image): ?>
          <div class="swiper-slide">
            <img class="img-fluid" src="{{resizeImage($image,700,400)}}" alt="">
          </div>
          <?php endforeach; ?>
        </div>
        <div class="sw-btn swiper-button-prev"><i class="fa fa-long-arrow-left"></i></div>
        <div class="sw-btn  swiper-button-next"><i class="fa fa-long-arrow-right"></i></div>
      </div>
    </div>
  </div>
  <script>
    new Swiper('#main-hotel-slider', {
      speed: 400, slidesPerView: 3,
      spaceBetween: 0,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>

  <div class="container py-4" id="app">
    <div class="row scon">
      <div class="col-lg-8 col-sm-8">
        <div class="mb-4 box-with-shadow">
          <h4 class="title">{{$hotel->name}}</h4>
          <div class="details"> {{$hotel->content}}</div>
        </div>
        <div class="mb-4 box-with-shadow">
          <h4 class="title">Select Your Rooms</h4>
          <div class="content">
            <x-room-selection :booking="$booking" :rooms="$hotel->rooms"></x-room-selection>
          </div>
        </div>
        <div class="mb-4 box-with-shadow">
          <h4 class="title">Hotel Policy</h4>
          <div class="content">
            {!! $hotel->policy !!}
          </div>
        </div>
        <div class="mb-4 box-with-shadow">
          <h4 class="title">Nearby Places</h4>
          <div class="content">
            <ul class="list-unstyled row">
              @foreach($hotel->nearby_places as $p)
                <li class="col-sm-6 ">
                  <div class="py-2 px-4 mb-2  d-flex justify-content-between rounded" style="background-color: #F6F6F6;">
                    <span><i class="fa fa-map-marker me-2"></i>{{$p['name']}}</span>
                    <span>{{$p['distance']}}kms</span>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="box-with-shadow">
          <h4 class="title">Similar Hotels</h4>
          <div class="content">
            <div class="row">
              @foreach($similarHotels as $hotel)
                <div class="col-sm-6 mb-4">
                  <x-hotel-card :hotel="$hotel"></x-hotel-card>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-4">
        <div class="sidebar">
          <div class="box-with-shadow">
            <div class="booking-dates position-relative">
              <label for="">Check In - Check Out</label>
              <date-range-picker
                :locale-data="{ firstDay: 1, format: 'dd mmm yyyy' }"
                :auto-apply="true"
                :ranges="false"
                :append-to="'body'"
                :date-range="dateRange"
                @update="datesUpdated($event)"
                format="mm/dd/yyyy">
              </date-range-picker>
            </div>
            <div v-if="Object.keys(booking.hotel.rooms).length===0" class="alert alert-info">Please select your rooms</div>
            <ul class="list-unstyled">
              <li v-for="(room,k) in booking.hotel.rooms">
                <div class="p-3 d-flex selected-rooms" v-if="room.number_of_rooms>0">
                  <div><i class="fa me-2 fa-bed"></i>@{{room.name}} <span class="room-count">(@{{ room.number_of_rooms }}x)</span></div>
                  <div>@{{room.price*room.number_of_rooms}} / Night</div>
                </div>
              </li>
            </ul>
            @if(!$booking->isCombo())

              <coupon @updated="somethingChanged()" code="{{$booking->coupon?$booking->coupon->code:''}}" url="{{route('booking.coupon.web')}}"></coupon>

              <div class="d-flex py-2 justify-content-between" v-for="(l,key) in labels" v-if="prices[key]>0">
                <div>@{{l}}</div>
                <div>@{{ amount(prices[key]) }}</div>
              </div>

              <ul class="payment-gateways d-flex list-unstyled">
                <li><a @click="selectGateway('online')" :class="{active:gateway=='online'}"><i class="fa fa-check me-2"></i>Pay Online</a></li>
                <li><a @click="selectGateway('offline')" :class="{active:gateway=='offline'}"><i class="fa fa-check me-2"></i>Pay in cash</a></li>
              </ul>
              <button :disabled="!terms" class="xs-btn-orange d-block w-100 text-center" @click="createOrder()">Pay</button>
              <div class="d-flex mt-3"><span class="me-2"><input v-model="terms" type="checkbox" name="" id=""></span>
                <span>By proceeding, you agree to our <a href="{{route('pages',['slug'=>'policy'])}}">Guest Policies</a></span></div>
            @else
              <a v-if="Object.keys(booking.hotel.rooms).length>0" href="{{route('booking.cab')}}" :disabled="Object.keys(booking.hotel.rooms).length===0" class="btn p-3 w-100  text-white
              btn-primary">Continue to cab booking</a>
              <button
                disabled v-if="Object.keys(booking.hotel.rooms).length===0" class="btn p-3 w-100  text-white btn-primary">Continue to cab booking
              </button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>




@endsection
@section('footer-scripts')
  <script>
    new Vue({
      el: '#app',
      data: function () {
        return {
          labels: {
            basePrice: 'Total Price',
            discount: 'Discount',
            tax: 'Tax',
            finalPrice: 'Net Payable'
          },

          coupon: '{{$booking->coupon->code??''}}',
          couponError: null,
          gateway: 'online',
          terms: true,
          dateRange: {
            startDate: new Date('{{$hotelFilter->getCheckInDate()->toISOString()}}'),
            endDate: new Date('{{$hotelFilter->getCheckOutDate()->toISOString()}}')
          },
          booking: {
            hotel: {
              id: {{$hotel->id}},
              check_in_date: '{{$hotelFilter->getCheckInDate()->format('d-m-y')}}',
              check_out_date: '{{$hotelFilter->getCheckOutDate()->format('d-m-y')}}',
              rooms: {
                @if($booking->hotelItem)
                  @foreach($booking->hotelItem->rooms as $r)
                room_{{$r->roomId}}: {
                  id: {{$r->roomId}},
                  name: '{{$r->name}}',
                  number_of_rooms: {{$r->numberOfRooms}},
                  price: {{$r->price}}
                },
                @endforeach
                @endif
              }
            },
            cab: {},
            coupon_code: null,
            settings: {
              coupon_code: null,
            }
          },
          prices: {}
        }
      },

      methods: {
        datesUpdated: function (e) {
          console.log(e);
          window.location.href = '{{Request::url()}}' + '?action=dates_update&d1=' + e.startDate.toISOString() + '&d2=' + e.endDate.toISOString();
        },
        amount: function (amount) {
          return '{{MyAppSettings::currency()}}' + ' ' + amount
        },
        selectGateway: function (gateway) {
          this.gateway = gateway
        },
        roomSelectionChanged: function ($event, roomJson) {
          const room = JSON.parse(roomJson);
          if ($event.value === 0) {//remove the room
            console.log('removing oom');
            delete this.booking.hotel.rooms['room_' + room.id];
          } else {
            this.booking.hotel.rooms['room_' + room.id] = {
              price: room.price,
              name: room.name,
              id: room.id,
              number_of_rooms: $event.value
            };
          }
          this.booking = {...this.booking};
          //update on server
          this.somethingChanged();
        },
        somethingChanged: function () {
          var _this = this;
          document.body.classList.add('loading');
          axios.post('{{route('booking.calculate.web')}}', this.booking)
            .then(function (d) {
              _this.prices = Object.assign({}, d.data);
              document.body.classList.remove('loading');

            }).catch(function (e) {
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
              if (res.data.guid) {
                window.location.href = '{{route('booking.payment.callback')}}/' + res.data.guid;
              }
              _this.pay(res.data)
            })
            .catch(function (e) {
            })
            .then(function () {
              hideLoader();
            })
        }
      },
      mounted: function () {
        this.somethingChanged()
      }
    });
  </script>
@endsection
@section('scripts')
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script src="https://unpkg.com/vueperslides"></script>
  <link href="https://unpkg.com/vueperslides/dist/vueperslides.css" rel="stylesheet">
@endsection
