@extends('adminlte::page')
@section('title', 'Перегляд існуючого об\'єкта')
@section('content')
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        <div class="container">
            @endif
            <div class="content-header">
                <div class="{{config('adminlte.classes_content_header', 'container-fluid')}}">
                    <h1>Перегляд існуючого об'єкта</h1>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Місце на карті</h3>
                                </div>
                                <form role="form" class="map-add-administrative-object">
                                    <div class="card-body min-vh-30 h-100" id="map_select">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Інформація по даному об'єкту</h3>
                                </div>
                                <form action="{{ route('saveObject') }}" method="POST" role="form" class="form-add-administrative-object">
                                    <div class="card-body">
                                        @if(Auth::user()->access == 1)
                                        <div class="form-group">
                                            <label>Тип об'єкта</label>
                                            <select disabled class="custom-select" name="type">
                                                <option value="0">Адміністративний</option>
                                                <option value="1">Цивільний</option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="name">Назва</label>
                                            <input readonly type="text" class="form-control" value="{{ $object->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Адреса</label>
                                            <input readonly type="text" class="form-control" value="{{ $object->address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Номер телефону</label>
                                            @php($phoneArr = json_decode($object->phone))
                                            @foreach($phoneArr as $phone)
                                                <input readonly type="text" class="form-control mb-2" value="{{ $phone }}">
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Звернення</label>
                                            <textarea readonly class="form-control" rows="3">{{ $object->message }}</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        </div>
    @endif
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJdJJRd3HojKrk0U_qs5cKPKdqlRx9hQ&callback=initMap"></script>
    @php($coordinates = json_decode($object->coordinates))
    <script>
        $( document ).ready(function() {
            if ($("#map_select").length) {
                initMap();
                var form_height = $('.form-add-administrative-object').height();
                $('.map-add-administrative-object').height(form_height);
            }
        });

        function initMap() {
            var myLatlng = {lat: {{ $coordinates[0] }}, lng: {{ $coordinates[1] }}};
            var marker;
            var map = new google.maps.Map(document.getElementById('map_select'), {zoom: 16, center: myLatlng});
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });
        }
    </script>
@stop
