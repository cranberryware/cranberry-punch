<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function create(Request $request)
    {
        
        $device = new Device();
        $device->name = $request->name;
        $device->location = $request->location;
        $device->user_id = $request->user_id;
        $device->user_email = User::find($request->user_id)->email;
        $device->serial_number = $request->serial_number;
        $device->identifier = $request->identifier;
        $device->status = $request->status;
        $device->mode = $request->mode;
        $device->save();
        if ($device->save()) {
            return response()->json(['data'=>$device], 200);
        } else {
            return response()->json([
                'message' => 'web is not created',
            ]);
        }

    }
    public function allDevice()
    {
      $data = Device::all();
    
     return $data;
    }
}
