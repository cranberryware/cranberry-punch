<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClockInDevice;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiometricsController extends Controller
{
    //
    public function createAttendance(Request $request)
    {
        // Check if secret key matches environment variable
        $secretKey = $request->input('secret_key');
        $envSecretKey = env('API_SECRET_KEY');

        if ($secretKey !== $envSecretKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Check if required fields are present in the request
        if (!$request->has('employee_code') || !$request->has('device_serial_number') || !$request->has('device_identifier')) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }
        // search clock in device
        $device = ClockInDevice::where([['device_serial', $request->device_serial_number], ['device_identifier', $request->device_identifier], ['device_status', 'active']])->first();

        if (!$device) return response()->json(['error' => 'Device not found or not active'], 404);
        // search employee
        $employee = Employee::where('employee_code', $request->employee_code)->first();

        if (!$employee) return response()->json(['error' => 'Employee not found'], 404);
        // search last attendance
        $employeeAttendance = $employee->attendances()->latest()->first();

        try {
            switch ($device->device_mode) {
                case 'check_in':
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = now()->format("Y-m-d H:i:s");
                        $employeeAttendance->check_out_ip = $request->ip();
                        $employeeAttendance->save();
                    }
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'user_id' => $employee->user->id,
                        'check_in' => now()->format("Y-m-d H:i:s"),
                        'check_in_ip' => $request->ip(),
                    ]);
                    return response()->json(['success' => true, 'message' => 'Check In successful'], 201);
                case 'check_out':
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = now()->format("Y-m-d H:i:s");
                        $employeeAttendance->check_out_ip = $request->ip();
                        $employeeAttendance->save();
                    } else {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'user_id' => $employee->user->id,
                            'check_in' => now()->format("Y-m-d H:i:s"),
                            'check_in_ip' => $request->ip(),
                            'check_out' => now()->format("Y-m-d H:i:s"),
                            'check_out_ip' => $request->ip(),
                        ]);
                    }
                    return response()->json(['success' => true, 'message' => 'Check Out successful'], 201);
                default:
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = now()->format("Y-m-d H:i:s");
                        $employeeAttendance->check_out_ip = $request->ip();
                        $employeeAttendance->save();
                        return response()->json(['success' => true, 'message' => 'Check Out successful'], 201);
                    } else {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'user_id' => $employee->user->id,
                            'check_in' => now()->format("Y-m-d H:i:s"),
                            'check_in_ip' => $request->ip(),
                        ]);
                        return response()->json(['success' => true, 'message' => 'Check In successful'], 201);
                    }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
