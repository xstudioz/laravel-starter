{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<?php
/** @var HotelRoom $room */
use App\Models\HotelRoom;
?>
@foreach($rooms as $room)
  <div class="row border-bottom py-4">
    <div class="col-sm-4">
      <slide fade :slide-ratio="1 / 1.5" :visible-slides="1" :slide-multiple="false">
        <vueper-slide v-for="(slide, i) in [@foreach($room->roomImages(500) as $i){ content:  '{{$i}}' }, @endforeach]"
                      :content="'<img src=&quot;'+slide.content+'&quot;/>'"/>
      </slide>
    </div>
    <div class="col-sm-8">
      <div class="d-flex mb-2 justify-content-between">
        <h5 class="fw-bold mb-0 lh-1">{{$room->name}}</h5>
        <div class="badge bg-success d-inline-block">{{$room->available_rooms}} rooms Left</div>
      </div>
      <div>Room Capacity : {{$room->capacity}}</div>
      <div class="  justify-content-between  mt-4">
        <div class="room-price">{{$room->price}} /Night</div>
        <div class="mt-2">
          <div>Number of rooms</div>
          <counter :max="{{$room->available_rooms}}" initial-value="{{$getInitRooms($room->id)}}" @updated="roomSelectionChanged($event,'{{json_encode($room)}}')" min="0"></counter>
        </div>
      </div>
    </div>
  </div>


@endforeach
