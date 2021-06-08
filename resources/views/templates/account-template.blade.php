@extends('templates.master')
@section('content')
  <div class="container py-5">
    <div class="row">
      <div class="col-sm-3">
        @include('pages.account.menu')
      </div>
      <div class="col-sm-9" id="app">
        @yield('account-content')
      </div>
    </div>
  </div>

@endsection
