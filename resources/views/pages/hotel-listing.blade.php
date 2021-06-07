@extends('templates.master')
@section('content')
  <div class="sticky-filter">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">@include('partials.hotel-search-form')</div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row no-gutters">
      <div class="col-sm-5 p-0">
        <div class=" map-container map"></div>
      </div>
      <div class="col-sm-7">
        <div class="p-4">
          <div class="row">
            @foreach($hotels as $h)
              <div class="col-sm-4 mb-4">
                <x-hotel-card :hotel="$h"></x-hotel-card>
              </div>
            @endforeach

            <div class="col-sm-12 pagination-div">
              {{ $hotels->links('vendor.pagination.bootstrap-4')}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer-scripts')
  <script>
    function gmap_clear_markers() {
      $('.infobox').each(function () {
        $(this).remove();
      });
    }

    var infowindow = null;

    $('.map')
      .gmap3({
        center: [48.8620722, 2.352047],
        zoom: 4,
        zoomControlOptions: {
          position: google.maps.ControlPosition.TOP_RIGHT,
        },
      })
      .cluster({
        size: 50,
        markers: [
            @foreach($hotels as  $hotel)
          {
            position: [{{$hotel->map_location['lat']??''}}, {{$hotel->map_location['lng']??''}}],
            icon: {
              url: '{{asset('images/map.png')}}',
              labelOrigin: new google.maps.Point(40, 20)
              // anchor: new google.maps.Point(200, 34),
            },
            label: {
              text: '₹',
              color: 'black',
              fontSize: '14px',
              id: {{$hotel->id}},
              html: "<div class='xs-info'><a href='{{$hotel->web_link}}' class='d-block'><img class='img-fluid' src='{{resizeImage($hotel->banner,150)}}'>" +
                "<div class='p-2 text-dark font-weight-bold' >{{$hotel->name}}</a> </div > </div>",
              x: '0',
              y: '-30'
            },

          },
          @endforeach
        ],
        cb: function (markers) {
          if (markers.length > 1) { // 1 marker stay unchanged (because cb returns nothing)
            if (markers.length < 20) {
              return {
                content: "<div class='cluster cluster-1'>" + markers.length + "</div>",
              };
            }
          }
        }
        ,

      })
      .on(
        {
          'click': function (marker, cluster, map) {
            if (cluster) {
              var bounds = new google.maps.LatLngBounds();
              for (var i = 0; i < cluster.markers.length; i++) {
                console.log(cluster.markers[i].position);
                bounds.extend(cluster.markers[i].position)
              }
              this.get(0).fitBounds(bounds);
            }
          },
          'mouseover': function (marker) {
            if (!marker) return;
            if (infowindow) infowindow.close();

            infowindow = new google.maps.InfoWindow({
              content: marker.label.html,
            });
            infowindow.open(this.get(0), marker);
            //  console.log(marker);
          },

        })
      .then(function () {
        var m = this.get(0);
        google.maps.event.addListenerOnce(m, 'idle', function (map) {
          console.log(map);
          var bounds = new google.maps.LatLngBounds();
          @foreach($hotels as $hotel)
          bounds.extend(new google.maps.LatLng({{$hotel->map_location['lat']}}, {{$hotel->map_location['lng']}}));
          @endforeach
          m.fitBounds(bounds);

        });
      })
  </script>
  <script>
    (function ($) {
      $(".map-container,.sticky-filter").stick_in_parent();
    })(jQuery)
  </script>
@endsection
