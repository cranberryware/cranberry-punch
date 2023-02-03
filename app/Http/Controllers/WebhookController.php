<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Device;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebhookController extends Controller
{
    public function create(Request $request)
    {
        $device = Device::where([['id', '=',$request->device_id],['serial_number','=',$request->device_serial_number ],['identifier','=',$request->device_identifier ],['status', '=','active'],['mode', '=','check-in']])->first();
        $user = User::where([['id','=',$request->user_id],['email','=','user_email']]);
        if(!$device){
            return response()->json([
               'meassage'=> '404 not found'
              ],404);
         }
        $web = Device::where([['status','=','active'],['mode','=','check-in']])->latest()->first();
        $check_out=Attendance::where('check_out','=',null)->latest()->first();
        if(!$check_out){
         return $check_out;
       }
       
        $web = new Webhook();
        $web->user_email = $request->user_email;
        $web->device_serial_number = $device->serial_number;
        $web->device_identifier = $device->identifier;
        $web->time = $request->time;
        $web->save();
      
        if ($web->save()) {
          return response()->json(['data'=>$web], 200);
      } else {
          return response()->json([
              'message' => 'web is not created',
          ]);
      }
        

    }
}


  
     

