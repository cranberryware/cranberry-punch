<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\AttendanceDevice;

class GenericBiometricDeviceController extends Controller
{
    //
    public function createAttendance(Request $request)
    {
        $timestamp = !empty($request->device_timestamp) ? $request->device_timestamp : now()->format("Y-m-d H:i:s");
        $registered_attendance = AttendanceDevice::register_attendance(
            $request->employee_code,
            $request->device_serial_number,
            $request->device_identifier,
            $request->device_secret,
            $request->ip(),
            $timestamp
        );
        return response()->json($registered_attendance, $registered_attendance['code']);
    }
}
