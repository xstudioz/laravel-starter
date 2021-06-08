{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<div class="box-shadow bg-white">
  <img src="{{resizeImage($cab->banner,800)}}" class="img-fluid" alt="">
  <div class="p-3">
    <div class="d-flex mb-2 car-features">
      <div class="me-3 pe-2 border-end"><i class="fa me-2 fa-user"></i>Luxury</div>
      <div class="me-3 pe-2 border-end"><i class="fa me-2 fa-user"></i>AC</div>
      <div class="me-3 pe-2 border-end"><i class="fa me-2 fa-user"></i>Wifi</div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5 class="fw-bold mb-0">{{$cab->name}}</h5>
        <x-star-rating :rating="2"></x-star-rating>
        | 10 Reviews
      </div>
      <div>
        <a href="{{route('booking.cab.book',[$cab->slug])}}" class="xs-btn-orange xs-btn-sm">Book Now</a>
      </div>
    </div>
  </div>
</div>
