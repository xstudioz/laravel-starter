<?php

use App\Xstudioz\CabFilter;
use App\Xstudioz\HotelFilter;

/** @var HotelFilter $hotelFilter */
/** @var CabFilter $cabFilter */

?>
<div class="py-5 header-style  d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row ">
      <div class="col-sm-12">
        <div id="app2">
          @if($booking->isCombo())
            <a class="py-2 d-block" href="{{request()->url().'?clear=hotel'}}">Clear hotel booking</a>
          @else
            <label class="text-white" class="mb-2">
              <input value="1" name="combo" type="checkbox">
              Book a cab as well
            </label>
          @endif

          <form method="post" class="header-search-box">
            @csrf
            <input type="hidden" name="cab" value="1">
            <input type="hidden" :value="distance" name="distance">
            <input type="hidden" :value="time" name="journeyTime">
            <input type="hidden" name="pickupTimestamp" :value="pickup_timestamp.startDate.toISOString()">
            <input type="hidden" name="dropTimestamp" :value="drop_timestamp.startDate.toISOString()">
            <div class="bg-white rounded-1 mb-2 d-flex">
              <div class="d-flex flex-fill align-items-center border-right ms-3" style="border-right: 1px solid #e5e5e5;">
                <i aria-hidden="true" class="fa mr-2 fa-search"></i>
                <input type="text" value="{{$cabFilter->getPickup()}}" autocomplete="off" name="pickup" id="pickup-location" placeholder="Enter Pickup Location*" required="required">
              </div>
              <div class="d-flex flex-fill align-items-center border-right ms-3">
                <i aria-hidden="true" class="fa mr-2 fa-search"></i>
                <input type="text" value="{{$cabFilter->getDrop()}}" autocomplete="off" name="drop" id="drop-location" placeholder="Enter Drop Location*" required="required">
              </div>
              <div class="flex-fill labeled-input">
                <label for="">Trip Type</label>
                <select class="flex-fill" name="tripType" v-model="tripType">
                  <option value="single">One Way Trip</option>
                  <option value="round">Two Way Trip</option>
                </select>
              </div>
            </div>
            <div class="bg-white d-flex  rounded-1">
              <div class="flex-fill labeled-input">
                <label for="">Depart Date & Time</label>
                <date-range-picker
                  v-model="pickup_timestamp"
                  :locale-data="{ firstDay: 1, format: 'dd mmm yyyy @ hh:M TT' }"
                  :auto-apply="true"
                  :date-range="{startDate:new Date(),endDate: new Date()}"
                  :show-ranges="false"
                  :ranges="false"
                  :opens="'center'"
                  :time-picker="true"
                  :time-picker24-hour="false"
                  :show-week-numbers="true"
                  :single-date-picker="true">
                </date-range-picker>
              </div>
              <div class="flex-fill labeled-input" :class="{'d-none':tripType=='single'}">
                <label for="">Depart Date & Time</label>
                <date-range-picker
                  v-model="drop_timestamp"
                  :locale-data="{ firstDay: 1, format: 'dd mmm yyyy @ hh:M TT' }"
                  :auto-apply="true"
                  :date-range="{startDate:new Date(),endDate: new Date()}"
                  :show-ranges="false"
                  :ranges="false"
                  :opens="'center'"
                  :time-picker="true"
                  :time-picker24-hour="false"
                  :show-week-numbers="true"
                  :single-date-picker="true">asdas
                </date-range-picker>
              </div>
              <div class="flex-fill labeled-input">
                <label for="">Passengers</label>
                <input type="text" value="{{$cabFilter->getPassengers()??0}}" name="passengers">
              </div>


              <button type="submit" class="flex-fill btn bg-orange search-btn submit-btn">Search <i class="fa fa-search" aria-hidden="true"></i></button>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

  var app2 = new Vue({
    el: '#app2',
    data: function () {
      return {
        tripType: '{{$cabFilter->getTripType() ?? 'single'}}',
        pickup_timestamp: {
          startDate: new Date('{{$cabFilter->getPickupTimestamp()->timezone('Asia/Kolkata')->toISOString()}}'),
          endDate: new Date()
        },
        drop_timestamp: {
          startDate: new Date('{{$cabFilter->getDropTimestamp()->timezone('Asia/Kolkata')->toISOString()}}'),
          endDate: new Date()
        },
        distance: {{$cabFilter->getDistance()??0}},
        time: {{$cabFilter->getJourneyTime()??0}}
      }
    }
  });

  function calculateDistance(origin, destination) {
    showLoader();
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
      {
        origins: [origin],
        destinations: [destination],
        travelMode: 'DRIVING',

      }, function (response, status) {
        app2._data.time = response.rows[0].elements[0].duration.value;
        app2._data.distance = response.rows[0].elements[0].distance.value;
        hideLoader();
      });


  }

  var pickLocation = document.getElementById('pickup-location');
  var dropLocation = document.getElementById('drop-location');
  var pick = new google.maps.places.Autocomplete(pickLocation);
  var drop = new google.maps.places.Autocomplete(dropLocation);
  pick.setComponentRestrictions({
    country: ["in"],
  });
  drop.setComponentRestrictions({
    country: ["in"],
  });
  pick.addListener("place_changed", function () {
    $('#pickup-location').val();
    if (dropLocation.value) calculateDistance(pickLocation.value, dropLocation.value);
  });
  drop.addListener("place_changed", function () {
    $('#drop-location').val();
    calculateDistance(pickLocation.value, dropLocation.value);
  });

</script>
