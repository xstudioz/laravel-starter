{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<a href="{{$getLink}}" class="d-block text-decoration-none text-dark">
  <article class="hotel-card">

    <div class="d-block overflow-hidden">
      @if($hotel->available_rooms || $hotel->totalRooms)
        <div class="room-count"><span>{{$hotel->available_rooms ?? $hotel->totalRooms}}  Rooms Left</span></div>
      @endif
      <img alt="{{htmlspecialchars($hotel->name)}}" class="img-fluid" src="{{$image(400)}}">
    </div>

    <div class="p-3">
      <h3 class="listing-title">{{$hotel->name}}</h3>
      <div class="d-flex">
        <small>0 Reviews </small>
        <div class="wrapper-star-average-rating pt-0">
          <div class="star-average-rating">
            <div class="star-average-inner" style="width: 86%"></div>
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center mt-2 justify-content-between">
        <div class="pr-3">
          <div class="price">₹ {{$displayPrice}} (inc. gst)</div>
          <div class="badge d-block bg-orange">Per Night</div>
        </div>
        <div class="amenities">
          @foreach($threeAmenties as $amenty)
            <i class="{{$amenty->icon}}"></i>
          @endforeach
        </div>
      </div>
    </div>

    <footer class="d-flex border-top align-items-center p-3">
      <i class="fa fa-map-marker me-2"></i>
      <div class="text-truncate">{{$hotel->address}}</div>
    </footer>
  </article>

</a>
