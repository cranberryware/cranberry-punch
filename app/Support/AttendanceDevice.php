<?php

namespace App\Support;

use App\Models\Employee;
use App\Enums\CheckInMode;
use App\Models\Attendance;
use App\Models\ClockingDevice;

class AttendanceDevice
{
    public static function register_attendance($employee_code, $device_serial_number, $device_identifier, $device_secret, $request_ip, $timestamp = null)
    {
        if (empty($employee_code) || empty($device_serial_number) || empty($device_identifier) || empty($device_secret)) {
            return ['error' => 'Missing required fields', 'code' => 400];
        }

        // search clock in device
        $device = ClockingDevice::where([['device_serial', $device_serial_number], ['device_identifier', $device_identifier], ['device_secret', $device_secret], ['device_status', 'active']])->first();

        if (!$device) return ['error' => 'Device not found or not active', 'code' => 404];

        // employee code with prefix.
        $employee_code = $device->emp_prefix.$employee_code;
        // search employee
        $employee = Employee::where('employee_code', $employee_code)->first();

        if (!$employee) return ['error' => 'Employee not found', 'code' => 404];

        // check employee checkin mode.
        $check_in_mode_override = app(\App\Settings\AttendanceSettings::class)->check_in_mode_override;
        $check_in_mode = !empty($check_in_mode_override) ? $check_in_mode_override : $employee->check_in_mode;
        if ($check_in_mode == CheckInMode::WEB) return ['error' => 'Employee checkin mode is only web', 'code' => 405];
        // search last attendance
        $employeeAttendance = $employee->attendances()->latest()->first();

        try {
            switch ($device->device_mode) {
                case 'check_in':
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = $timestamp;
                        $employeeAttendance->check_out_ip = $request_ip;
                        $employeeAttendance->save();
                    }
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'user_id' => $employee->user->id,
                        'check_in' => $timestamp,
                        'check_in_ip' => $request_ip,
                    ]);
                    return ['success' => true, 'message' => 'Check In successful', 'code' => 201];
                case 'check_out':
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = $timestamp;
                        $employeeAttendance->check_out_ip = $request_ip;
                        $employeeAttendance->save();
                    } else {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'user_id' => $employee->user->id,
                            'check_in' => $timestamp,
                            'check_in_ip' => $request_ip,
                            'check_out' => $timestamp,
                            'check_out_ip' => $request_ip,
                        ]);
                    }
                    return ['success' => true, 'message' => 'Check Out successful', 'code' => 201];
                default:
                    if ($employeeAttendance && !$employeeAttendance->check_out) {
                        $employeeAttendance->check_out = $timestamp;
                        $employeeAttendance->check_out_ip = $request_ip;
                        $employeeAttendance->save();
                        return ['success' => true, 'message' => 'Check Out successful', 'code' => 201];
                    } else {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'user_id' => $employee->user->id,
                            'check_in' => $timestamp,
                            'check_in_ip' => $request_ip,
                        ]);
                        return ['success' => true, 'message' => 'Check In successful', 'code' => 201];
                    }
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }
}
