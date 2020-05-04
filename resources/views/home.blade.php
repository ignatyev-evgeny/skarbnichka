@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content')
{{--    {{ dd(Auth::user()->status) }}--}}
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
    <div class="container mw-100 no-padding">
    @endif
    {{--    <div class="content-header">--}}
    {{--        <div class="{{config('adminlte.classes_content_header', 'container-fluid')}}">--}}
    {{--            <h1>Dashboard</h1>--}}
    {{--        </div>--}}
    {{--    </div>--}}

        <div class="content" id="map" style="height: 94vh">
{{--            <div class="{{config('adminlte.classes_content', 'container-fluid')}}">--}}
{{--                <p>Welcome to this beautiful admin panel.</p>--}}
{{--            </div>--}}
        </div>
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
    </div>
    @endif
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJdJJRd3HojKrk0U_qs5cKPKdqlRx9hQ&callback=initMap"></script>
    <script>

        function initMap() {

            var locations = [
                @foreach($objects as $object)
                    [
                        @php($coordinates = json_decode($object->coordinates))
                        "{{ $object->name }}",
                        "{{ $coordinates[0] }}",
                        "{{ $coordinates[1] }}",
                        "https://skarbnychka.in.ua/assets/img/help.png",
                        "{{ $object->message }}",
                        "{{ $object->id }}",
                        "{{ implode('|', json_decode($object->phone, true)) }}"
                    ],
                @endforeach
            ];

            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: new google.maps.LatLng(46.467733953874486, 30.740540027618408),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var coordinates = {lat: position.coords.latitude, lng: position.coords.longitude};
                    map.setCenter(coordinates);
                    var me = new google.maps.Marker({
                        position: coordinates,
                        map: map,
                        icon: 'https://skarbnychka.in.ua/assets/img/me.png'
                    });

                });
            }

            var infoWindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < locations.length; i++) {
                var lat = locations[i][1];
                var lng = locations[i][2];
                var pin = locations[i][3];
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lat, lng),
                    animation: google.maps.Animation.DROP,
                    icon: pin,
                    map: map
                });
                google.maps.event.addListener(marker, "click", (function(marker, i) {

                    var phoneArr = locations[i][6].split('|');
                    var phone = '', j;
                    for (j = 0; j < phoneArr.length; j++) {
                        phone += '<b>' + phoneArr[j] + '</b><br>';
                    }

                    console.log(phone);
                        var html = "<h6>" + locations[i][0] + "</h6><h7>" + locations[i][4] + "</h7><br><br><h7>" + phone + "</h7><br><a href='/info_object/" + locations[i][5] + "'>Докладніше</a>";

                        return function() {
                            infoWindow.setOptions({
                                content:html
                            });
                            infoWindow.open(map, marker);
                        };
                    })(marker, i)
                );
            }
        }

    </script>
@stop
