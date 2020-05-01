@extends('adminlte::page')
@section('title', "Список $lable об'єктів")
@section('content')
    @if(config('adminlte.layout_topnav') || View::getSection('layout_topnav'))
        <div class="container">
            @endif
            <section class="content mt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Список {{ $lable }} об'єктів</h3>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th class="text-center">Назва</th>
                                            <th class="text-center">Власник</th>
                                            <th class="text-center">Дата додавання</th>
                                            <th style="width: 140px" class="text-center">Статус</th>
                                            <th style="width: 130px" class="text-center">Управління</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(\App\Models\Objects::where('type', $type)->count() == 0)
                                            <tr>
                                                <td class="align-middle text-center" colspan="6">Немає ніякої інформації</td>
                                            </tr>
                                        @else
                                            @foreach(\App\Models\Objects::where('type', $type)->get() as $object)
                                                <tr>
                                                    <td class="align-middle text-center">{{ $object->id }}</td>
                                                    <td class="align-middle text-center">{{ $object->name }}</td>
                                                    <td class="align-middle text-center">{{ Auth::user($object->user_id)->email }}</td>

                                                    <td class="align-middle text-center">{{ $object->created_at }}</td>
                                                    @if($object->status == 0)
                                                    <td class="align-middle text-center">
                                                        <span class="badge bg-warning w-100">Ца модерації</span>
                                                        <button type="button" onclick="location.href = '/status_object/{{ $object->id }}/active'" class="btn btn-block btn-success btn-xs">Підтвердити об'єкт</button>
                                                    </td>
                                                    @elseif($object->status == 10)
                                                    <td class="align-middle text-center">
                                                        <span class="badge bg-danger w-100">Вимкнений</span>
                                                    </td>
                                                    @elseif($object->status == 1)
                                                    <td class="align-middle text-center">
                                                        <span class="badge bg-success w-100">Активний</span>
                                                    </td>
                                                    @endif
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group">
                                                            <button type="button" onclick="location.href = '/info_object/{{ $object->id }}'" class="btn btn-danger"><i class="fas fa-info"></i></button>
                                                            <button type="button" onclick="location.href = '/edit_object/{{ $object->id }}'" class="btn btn-danger"><i class="fas fa-edit"></i></button>
                                                            @if($object->status == 10)
                                                                <button type="button" onclick="location.href = '/status_object/{{ $object->id }}/play'" class="btn btn-danger"><i class="fas fa-play"></i></button>
                                                            @else
                                                                <button type="button" onclick="location.href = '/status_object/{{ $object->id }}/stop'" class="btn btn-danger"><i class="fas fa-stop"></i></button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
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
