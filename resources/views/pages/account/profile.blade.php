@extends('templates.account-template')
@section('account-content')
  <form method="post" action="{{route('account.update')}}">
    @csrf
    <div class="row">
      @if ($errors->any())
        <div class="alert alert-danger">
          <h5>Please fix these issues</h5>
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="col-sm-8">
        <div class="form-floating mb-3">
          <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control" id="name" placeholder="name@example.com">
          <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" name="email" value="{{old('email',$user->email)}}" class="form-control" id="email" placeholder="name@example.com">
          <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
          <input readonly type="text" name="phone" value="{{old('phone',$user->phone)}}" class="form-control" id="phone" placeholder="name@example.com">
          <label for="phone">Phone</label>
          <small class="text-warning"><i class="fa fa-info me-2
"></i>Phone number cant be changed</small>
        </div>
        <div class="form-floating mb-3">
          <input type="text" name="metas[address]" value="{{old('metas.address',$metas['address'])}}" class="form-control" id="address" placeholder="name@example.com">
          <label for="address">Address</label>
        </div>
      </div>
      <div class="col-sm-4">
        <image-uploader name="profile_image"
                        value="{{old('profile_image',$user->image??resizeImage($user->profile_image,300))}}"
                        field-name="file[]"
                        upload-url="{{route('upload',['profile'])}}">
        </image-uploader>
      </div>
    </div>


    <button type="submit" class="xs-btn-orange">Update Profile</button>
  </form>
  <script>
    new Vue({
      el: '#app'
    })
  </script>
@endsection
