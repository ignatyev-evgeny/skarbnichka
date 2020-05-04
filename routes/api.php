<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('objects', function () {
    $objects = \App\Models\Objects::all();
    $objects = $objects->toJson();
    return response($objects, 200)->header('Content-Type', 'application/json');
});
