<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified', 'status'])->group(function () {
    Route::get('/', 'MainController@index')->name('home');

    Route::view('/add_object', 'add.object');
    Route::view('/administrative_object', 'list.objects', ['type' => 0, 'lable' => 'адміністративних'])->middleware('access');
    Route::view('/civilian_object', 'list.objects', ['type' => 1, 'lable' => 'цивільних'])->middleware('access');
    Route::view('/my_object', 'list.my_objects');
    Route::post('/save_object', 'Objects@saveObject')->name('saveObject');
    Route::post('/update_object', 'Objects@updateObject')->name('updateObject');
    Route::get('/info_object/{id}', 'Objects@infoObject')->name('infoObject');
    Route::get('/edit_object/{id}', 'Objects@editObject')->name('editObject');
    Route::get('/status_object/{id}/{status}', 'Objects@statusObject')->name('statusObject');
});


