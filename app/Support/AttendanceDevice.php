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
        $employee_code = $device->emp_prefix . $employee_code;
        // search employee
        $employee = Employee::where('employee_code', $employee_code)->first();

        if (!$employee) return ['error' => 'Employee not found', 'code' => 404];

        // check employee checkin mode.
        $check_in_mode_override = app(\App\Settings\AttendanceSettings::class)->check_in_mode_override;
        $check_in_mode = !empty($check_in_mode_override) ? $check_in_mode_override : $employee->check_in_mode;
        if ($check_in_mode == CheckInMode::WEB) return ['error' => 'Employee checkin mode is only web', 'code' => 405];
        // search last attendance
        $employee_attendance = $employee->attendances()->latest()->first();

        $is_active_attendance = $employee_attendance && !$employee_attendance->check_out;

        $attendance_data = [
            'check_in' => [
                'employee_id' => $employee->id,
                'user_id' => $employee->user->id,
                'check_in' => $timestamp,
                'check_in_ip' => $request_ip,
            ],
            'check_out' => [
                'employee_id' => $employee->id,
                'user_id' => $employee->user->id,
                'check_in' => $timestamp,
                'check_in_ip' => $request_ip,
                'check_out' => $timestamp,
                'check_out_ip' => $request_ip,
            ],
            'both' => [
                'employee_id' => $employee->id,
                'user_id' => $employee->user->id,
                'check_in' => $timestamp,
                'check_in_ip' => $request_ip,
            ]
        ];
        // if any active attendance update that first.
        if ($is_active_attendance) {
            $employee_attendance->check_out = $timestamp;
            $employee_attendance->check_out_ip = $request_ip;
            $employee_attendance->save();
        }
        // after updating active attendance, if device mode is check in then we create new attendance.
        if ($device->device_mode == 'check_in') {
            Attendance::create($attendance_data[$device->device_mode]);
            return ['success' => true, 'message' => 'Check In successful', 'code' => 201];
        }
        // if device mode is not check_in and no active attendance.
        // if device mode is check_out, then we create a new attendance with check_out time.
        // if device mode is both then we create a attendance only with check_in data.
        if (!$is_active_attendance) {
            Attendance::create($attendance_data[$device->device_mode]);
            return ['success' => true, 'message' => ($device->device_mode == 'both' ? 'Check In' : 'Check Out' ) .' successful', 'code' => 201];
        }
        return ['success' => true, 'message' => 'Check Out successful', 'code' => 201];
    }
}
