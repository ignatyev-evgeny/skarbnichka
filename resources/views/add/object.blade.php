@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content')
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        <div class="container">
    @endif
            <div class="content-header">
                <div class="{{config('adminlte.classes_content_header', 'container-fluid')}}">
                    <h1>Додавання нового об'єкта</h1>
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
                                    Сталася помилка при додаванні об'єкта, перевірте правильність введених даних і спробуйте знову. В іншому випадку зв'яжіться з адміністрацією проекту.
                                </div>
                            @endif

                            @if(isset($save_status) && $save_status == 1)
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Успішно</h5>
                                Об'єкт був успішно доданий в систему, і з'явиться в доступі після проходження перевірки адміністрацією ресурсу.
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
                                <form action="{{ route('saveObject') }}" method="POST" role="form" class="form-add-administrative-object">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="status" value="0">
                                    <input type="hidden" class="coordinates" name="coordinates">
                                    @if(Auth::user()->access == 0)
                                    <input type="hidden" name="type" value="1">
                                    @endif
                                    <div class="card-body">
                                        @if(Auth::user()->access == 1)
                                        <div class="form-group">
                                            <label>Тип об'єкта</label>
                                            <select class="custom-select" name="type">
                                                <option value="0">Адміністративний</option>
                                                <option value="1">Цивільний</option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="name">Вкажіть назву</label>
                                            <input required type="text" class="form-control" name="name" id="name" placeholder="Вкажіть назву">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Вкажіть адресу</label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input required type="text" class="form-control" name="address" id="address" placeholder="Вкажіть адресу">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="search_address" class="btn btn-primary w-100">Шукати</button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Вкажіть номер телефону</label>
                                            <input required type="text" class="phone-masked form-control" name="phone[]" id="phone" placeholder="Вкажіть номер телефону">
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Ваше звернення</label>
                                            <textarea required name="message" class="form-control" rows="3" placeholder=""></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Додати об'єкт</button>
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

    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Помилка при виявленні об'єкта</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вкажіть точку на карті вручну.</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light w-100" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJdJJRd3HojKrk0U_qs5cKPKdqlRx9hQ&callback=initMap"></script>
    <script src="{{ asset('vendor/map/map_select.js') }}"></script>
    <script src="{{ asset('vendor/masked/masked.js') }}"></script>
@stop
