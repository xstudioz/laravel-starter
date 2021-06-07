@extends('templates.master')
@section('content')
  @include('partials.hotel-search')
  <section class="hotel py-5">

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <h2 class="fw-bold text-center pb-4">Top Rated Hotels</h2>

          <div class="swiper-container top-rated-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">

              @foreach($topRated as $hotel)

                <div class="swiper-slide">
                  <x-hotel-card :hotel="$hotel"></x-hotel-card>
                </div>

              @endforeach

            </div>

            <div class="swiper-button-prev sw-btn"><i class="fa fa-long-arrow-left"></i></div>
            <div class="swiper-button-next sw-btn"><i class="fa fa-long-arrow-right"></i></div>

          </div>
          <script>
            var mySwiper = new Swiper('.top-rated-slider', {
              speed: 400,
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
              },
              breakpoints: {
                // when window width is >= 320px
                320: {
                  slidesPerView: 1,
                  spaceBetween: 20
                },
                // when window width is >= 480px
                480: {
                  slidesPerView: 3,
                  spaceBetween: 30
                },
                // when window width is >= 640px
                900: {
                  slidesPerView: 4,
                  spaceBetween: 40
                }, 1200: {
                  slidesPerView: 5,
                  spaceBetween: 40
                }
              }
            })

          </script>
        </div>
      </div>
    </div>
  </section>



@endsection
