{{-- You can change this template using File > Settings > Editor > File and Code Templates > Code > Laravel Ideal Blade View Component --}}
<div class="box-with-shadow mb-4">
  <div class="d-flex justify-content-between">
    <div>
      <h5 class="mb-1 fw-bold">Booking #{{$booking->id}}</h5>
      <small class="d-block mb-4"><i class="fa fa-clock-o me-2"></i>{{$booking->created_at->timezone('Asia/Kolkata')->format('d M Y')}}</small>
      <span class="b-label {{strtolower($booking->status)}}">{{$booking->status}}</span>
      <span class="b-label {{strtolower($booking->payment_mode)}}">{{$booking->payment_mode}}</span>
    </div>
    <div><a href="{{route('booking.view',[$booking->guid])}}" class="xs-btn-sm xs-btn-orange"><i class="fa fa-eye"></i></a></div>
  </div>
</div>
