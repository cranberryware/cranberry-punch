<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Enums\CheckInMode;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ClockingDevice;
use App\Support\AttendanceDevice;

class GenericBiometricDeviceController extends Controller
{
    //
    public function createAttendance(Request $request)
    {
        // Check if api key matches environment variable
        $apiKey = request()->header('X-Api-Key');
        $envSecretKey = config('app.api_secret_key');

        if ($apiKey !== $envSecretKey) {
            return response()->json(['error' => 'Unauthorized', 'code' => 401], 401);
        }
        // Check if required fields are present in the request
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
