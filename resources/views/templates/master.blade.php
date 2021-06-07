<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{asset('images/favicon.png')}}">
  <link rel="stylesheet" href="{{asset('css/b5.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;700&display=swap" rel="stylesheet">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyL1fTGBCCPmVObWpNFHjbxt7BzZctJG4&libraries=places"></script>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <!-- -->
  @if(isset($seo))
    <title>{{$seo['title']}}</title>
    <meta name="description" content="{{$seo['description']}}">
    <meta name="keywords" content="{{$seo['keywords']}}">
    <meta name="canonical_link" href="{{$seo['canonical_link']}}">
    <meta name="robots" content="{{$seo['robot']}}">
    <!-- og -->

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$seo['title']}}">
    <meta property="og:description" content="{{$seo['description']}}">
    <meta property="og:image" content="{{$seo['image']}}">
    <meta property="og:url" content="PERMALINK">
    <meta name="twitter:title" content="TITLE OF POST OR PAGE">
    <meta name="twitter:description" content="DESCRIPTION OF PAGE CONTENT">
    <meta name="twitter:image" content="LINK TO IMAGE">
    <meta name="twitter:site" content="@USERNAME">
    <meta name="twitter:creator" content="@USERNAME">
  @endif
  <meta property="og:site_name" content="{{MyAppSettings::get('site_name','Bookyourown')}}">

  <!-- JS CODE -->
  {!! isset($og) ? $og->renderTags() :''!!}
  <script src="{{asset('js/bundle.js')}}"></script>
  <script src="{{asset('js/xs-lib.min.js')}}"></script>
  @yield('scripts')

  <script>
    axios.defaults.withCredentials = true;
    console.log(axios.defaults);
    if (typeof vueperslides != 'undefined') {
      Vue.component('slide', vueperslides.VueperSlides);
      Vue.component('vueper-slide', vueperslides.VueperSlide);
    }
    Vue.component('counter', xs.counter);
    Vue.component('overlay', xs.overlay);
    Vue.component('coupon', xs.CouponCode);
    Vue.component('date-range-picker', xs.datepicker);
    Vue.component('image-uploader', xs.uploader);

    function amount(amount) {
      return '{{MyAppSettings::currency()}}' + amount;
    }

    function showLoader() {
      document.body.classList.add('loading');
    }

    function hideLoader() {
      document.body.classList.remove('loading');
    }
  </script>
</head>
<body>
@include('templates.header')
@yield('content')
@include('templates.footer')
@yield('footer-scripts')
</body>
</html>
