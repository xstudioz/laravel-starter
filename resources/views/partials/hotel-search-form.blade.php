<div id="app" class="header-search-box">
  <form class="" method="post">
    <div class="d-flex py-2 align-items-center justify-content-start text-white combo ">
      <label>
        <input value="1" name="combo" type="checkbox">
        Book a cab as well
      </label>
    </div>
    <div class="white-bg bg-white d-flex rounded-1 hotel-search-form-fields">
      @csrf
      <input type="hidden" name="hotel_search" value="1">
      <div v-click-outside="closeCitySearch" class="ps-3 d-block d-lg-flex flex-x-2 align-items-center position-relative" id="city-search">
        <i class="fa text-dark fa-search"></i>
        <input name="city" @focus="openSearch()" v-model="city" class="city-search-input w-100" type="text" placeholder="Search Cities">
        <div v-if="loading" style="position: absolute;right: 0;">Loading...</div>

        <div class="location-show" v-if="popup">
          <input type="text" ref="csearch" id="city-search-in" v-on:input="search">
          <div class="alert mt-2 alert-info" v-if="!loading && cities.length==0">No Cities Found</div>
          <ul class="list-unstyled">
            <li v-for="city in cities">
              <a class="d-flex align-items-center" @click="select(city)">
                <i class="fa fa-map-marker me-3"></i>
                <div> @{{city.name}} <small class="pl-0">India</small></div>
              </a>
            </li>
          </ul>

        </div>

      </div>
      <div class="labeled-input">
        <label for=""><i class="fa text-dark fa-calender"></i>Check In - Check Out</label>
        <input type="hidden" name="check_in_date" v-model="dateRange.startDate.toISOString()" id="">
        <input type="hidden" name="check_out_date" v-model="dateRange.endDate.toISOString()" id="">
        <date-range-picker @update="setDate()"
                           :ranges="false"
                           :opens="'center'"
                           :min-date="minDate"
                           :locale-data="{ firstDay: 1, format: 'ddd, dd mmm yyyy' }"
                           :auto-apply="true" v-model="dateRange"
                           :date-range="dateRange">
        </date-range-picker>

      </div>

      <div class="labeled-input" id="guestSelector" v-click-outside="closeGuestPopUp">
        <label for="">Guests</label>
        <input @focus="showGuestPopup=true" :value="rooms.length +' Rooms, Guests '+totalGuests" type="text" placeholder="search">
        <input type="hidden" name="rooms" v-model="JSON.stringify(rooms)">
        <div class="guest-popup" v-if="showGuestPopup==true">
          <div class="row mb-3">
            <div class="col-6 text-left"><strong>Rooms</strong></div>
            <div class="col-6"><strong>Guests</strong></div>
          </div>
          <div v-for="(room,index) in rooms" class="row room-row text-left  mb-3">
            <div class="col-6">Room @{{index + 1}}</div>
            <div class="col-6">

              <div class="d-flex guest-counter">
                <button type="button" @click="decrement(room)">-</button>
                <div>@{{room.guests}}</div>
                <button type="button" @click="increment(room)">+</button>
              </div>

            </div>
          </div>
          <div class="row text-left">
            <div class="col-6">
              <a type="button" @click="deleteRoom()" class="btn text-danger btn-outline btn-sm"><i class="fa fa-times me-2"></i>Delete</a>
            </div>
            <div class="col-6">
              <a type="button" @click="addRoom()" class="btn text-success btn-outline btn-sm"><i class="fa fa-plus me-2"></i>Add Room</a>
            </div>
          </div>
        </div>

      </div>
      <button type="submit" class="btn bg-orange search-btn submit-btn">Search <i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
  </form>
</div>
<script>
  var app1 = new Vue({
    el: '#app',
    methods: {
      decrement(room) {
        if (room.guests == 1) return;
        room.guests--;
        this.calculateTotalGuests();
      },
      increment(room) {
        if (room.guests == 4) return;
        room.guests++;
        this.calculateTotalGuests();

      },
      addRoom: function () {
        if (this.rooms.length == 4) return;
        this.rooms.push({id: 'x', guests: 1});
        this.calculateTotalGuests();

      },
      deleteRoom: function () {
        if (this.rooms.length == 1) return;
        this.rooms.splice(-1, 1);
        this.calculateTotalGuests();
      },
      calculateTotalGuests: function () {
        this.totalGuests = 0;
        for (i = 0; i < this.rooms.length; i++) {
          this.totalGuests += +this.rooms[i].guests;
        }
      },
      closeGuestPopUp: function () {
        this.showGuestPopup = false;
      },
      closeCitySearch: function () {
        this.popup = false;
        this.cities = [];
      },
      debounce: function (fn, delay) {
        var timeoutID = null;
        var _this = this;
        return function () {
          clearTimeout(timeoutID)
          var args = arguments;
          var that = _this;
          timeoutID = setTimeout(function () {
            fn.apply(that, args);
          }, delay);
        }
      },
      openSearch: function () {
        this.popup = true;
        this.search();
        var _this = this;
        this.$nextTick(() => {
          _this.$refs.csearch.focus();
          this.search();
        })
      },
      //
      hide: function () {
        this.popup = false
      },
      select: function (city) {
        this.popup = false;
        this.city = city.name;
      },
      hidePopup: function () {
        var _this = this;
        setTimeout(function () {
          _this.popup = false;
        }, 100)
      },
      search: function () {
        if (!this.$refs.csearch) return;
        var _this = this;
        this.loading = true;
        axios.get('{{url("/cities?city=")}}' + _this.$refs.csearch.value).then(function (d) {
          _this.cities = d.data;
          _this.popup = true;
          _this.loading = false;
        })

      },
      setDate: function () {
        this.dates = JSON.stringify(this.dateRange);
      }
    },
    mounted: function () {
      this.calculateTotalGuests()
    },
    data() {
      return {
        dates: '',
        minDate: new Date('{{Carbon::now()->timezone('Asia/Kolkata')}}'),
        totalGuests: 1,
        showGuestPopup: false,
        totalRooms: 1,
        rooms: [
            @foreach($hotelFilter->getRooms() as $room)
          {
            id: '{{$room->id}}',
            guests: {{$room->guests}}
          },
          @endforeach
        ],
        //
        loading: false,
        popup: false,
        city: "{{$hotelFilter->getCity()?$hotelFilter->getCity()->name:''}}",
        cities: [],
        dateRange: {
          startDate: new Date('{{$hotelFilter->getCheckInDate()->format(DATE_ATOM)}}'),
          endDate: new Date('{{$hotelFilter->getCheckOutDate()->format(DATE_ATOM)}}')
        }
      }
    },


  });
</script>
