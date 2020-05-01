<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Objects extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'status']);
    }

    public function saveObject(Request $request)
    {
        try {

            if (!empty($request->coordinates)) {
                $coordinates = str_replace('(','', $request->coordinates);
                $coordinates = str_replace(')','', $coordinates);
                $coordinates = explode(', ', $coordinates);
            } else {
                return view('add.object', ['save_status' => 2]);
            }

            $object = new \App\Models\Objects();
            $object->type = $request->type;
            $object->status = $request->status;
            $object->user_id = $request->user_id;
            $object->coordinates = json_encode($coordinates);
            $object->name = $request->name;
            $object->address = $request->address;
            $object->phone = json_encode($request->phone);
            $object->message = $request->message;
            $object->save();
            return view('add.object', ['save_status' => 1]);
        } catch (\Throwable $e) {
            report($e);
            return view('add.object', ['save_status' => 0]);
        }
    }

    public function updateObject(Request $request)
    {
        try {
            if (!empty($request->coordinates)) {
                $coordinates = str_replace('(','', $request->coordinates);
                $coordinates = str_replace(')','', $coordinates);
                $coordinates = explode(', ', $coordinates);
            } else {
                return view('edit.object', ['save_status' => 2]);
            }

            $object = \App\Models\Objects::find($request->object_id);
            $object->status = 0;
            $object->coordinates = json_encode($coordinates);
            $object->name = $request->name;
            $object->address = $request->address;
            $object->phone = json_encode($request->phone);
            $object->message = $request->message;
            $object->save();
            return view('edit.object', ['id' => $request->object_id, 'object' => $object, 'save_status' => 1]);
        } catch (\Throwable $e) {
            report($e);
            return view('edit.object', ['id' => $request->object_id, 'object' => $object, 'save_status' => 0]);
        }
    }

    public function statusObject($objectID, $status)
    {
        switch ($status) {
            case 'stop':
                $status_id = 10;
                break;
            case 'play':
            case 'active':
                $status_id = 1;
                break;
        }

        $object = \App\Models\Objects::find($objectID);
        if($status == 'play') {
            $object->status = 0;
        } else {
            $object->status = $status_id;
        }
        $object->save();
        return back();
    }


    public function infoObject($objectID)
    {
        $object = \App\Models\Objects::find($objectID);
        return view('info.object', ['object' => $object]);
    }

    public function editObject($objectID)
    {
        $object = \App\Models\Objects::find($objectID);
        return view('edit.object', ['object' => $object]);
    }


}

