@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content')
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        <div class="container">
            @endif
            <div class="content-header">
                <div class="{{config('adminlte.classes_content_header', 'container-fluid')}}">
                    <h1>Редагування об'єкта</h1>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($save_status) && $save_status == 0)
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Увага!</h5>
                                    Сталася помилка при оновлені об'єкта, перевірте правильність введених даних і спробуйте знову. В іншому випадку зв'яжіться з адміністрацією проекту.
                                </div>
                            @endif

                            @if(isset($save_status) && $save_status == 1)
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Успішно</h5>
                                    Об'єкт був успішно оновлений в системі, і з'явиться в доступі після проходження перевірки адміністрацією ресурсу.
                                </div>
                            @endif

                            @if(isset($save_status) && $save_status == 2)
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Увага!</h5>
                                    Вкажіть місце розташування об'єкта на карті.
                                </div>
                            @endif


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Вкажіть місце на карті</h3>
                                </div>
                                <form role="form" class="map-add-administrative-object">
                                    <div class="card-body min-vh-30 h-100" id="map_select"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Інформація по даному об'єкту</h3>
                                </div>
                                <form action="{{ route('updateObject') }}" method="POST" role="form" class="form-add-administrative-object">
                                    @csrf
                                    <input type="hidden" name="object_id" value="{{ $object->id }}">
                                    <input type="hidden" class="coordinates" name="coordinates">
                                    @if(Auth::user()->access == 0)
                                        <input type="hidden" name="type" value="1">
                                    @endif
                                    <div class="card-body">
                                        @if(Auth::user()->access == 1)
                                            <div class="form-group">
                                                <label>Тип об'єкта</label>
                                                <select class="custom-select" name="type">
                                                    <option {{ $object->type == 0 ? 'selected' : '' }} value="0">Адміністративний</option>
                                                    <option {{ $object->type == 1 ? 'selected' : '' }} value="1">Цивільний</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="name">Назва об'єкту</label>
                                            <input required type="text" class="form-control" name="name" id="name" value="{{ $object->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Адреса об'єкту</label>
                                            <input required type="text" class="form-control" name="address" id="address" value="{{ $object->address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Номер телефону</label>
                                            @php($phoneArr = json_decode($object->phone))
                                            @foreach($phoneArr as $phone)
                                                <input required type="text" class="form-control mb-2" name="phone[]" id="phone" value="{{ $phone }}">
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Ваше звернення</label>
                                            <textarea required name="message" class="form-control" rows="3">{{ $object->message }}</textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Зберегти об'єкт</button>
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
            var markers = [];
            var map = new google.maps.Map(document.getElementById('map_select'), {zoom: 16, center: myLatlng});
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });
            markers.push(marker);
            $('.coordinates').val('({{ $coordinates[0] }}, {{ $coordinates[1] }})');
            map.addListener('click', function (mapsMouseEvent) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
                marker = new google.maps.Marker({
                    position: mapsMouseEvent.latLng,
                    map: map
                });
                markers.push(marker);
                $('.coordinates').val(mapsMouseEvent.latLng.toString());
            });
        }
    </script>
@stop
