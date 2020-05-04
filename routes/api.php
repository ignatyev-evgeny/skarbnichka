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
    foreach ($objects as $object) {
        if($object->status == 1) {
            if($object->type == 0) {
                $phone = $object->phone;
            } else {
                $phone = 'Контактні дані будуть доступні після реєстрації в особистому кабінеті.';
            }
            $objectsArr[] = [
                'id' => $object->id,
                'type' => $object->type,
                'coordinates' => $object->coordinates,
                'name' => $object->name,
                'address' => $object->address,
                'phone' => $phone,
                'message' => $object->message
            ];
        }
    }
    return response()->json($objectsArr);
});
