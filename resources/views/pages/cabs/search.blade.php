@extends('templates.master')
@section('content')
  @include('partials.cab-search')

  <div class="container py-5">
    <div class="row">
      @foreach($cabs as $cab)
        <div class="col-sm-4 mb-5">
          <x-cab-card :cab="$cab"></x-cab-card>
        </div>
      @endforeach

    </div>
  </div>


@endsection
