<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\AttendanceDevice;

class SmackBioBiometricDeviceController extends Controller
{
    public function createAttendance(Request $request)
    {
        $request_message = $request->msg;
        if(empty($request_message)) {
            return response()->json(['error' => 'No Command Sent', 'code' => 404], 404);
        }
        $request_message_array = preg_split('/, ?/', $request_message);
        $request_command = $request_message_array[0];
        $csv_headers_by_command = [
            "LOG" => "Command,TerminalType,TerminalID,SerialNumber,TransactionID,LogTime,UserID,DoorID,AttendanceStatus,VerifyMode,JobCode,Antipass,DeviceSecret",
            "AdminLog" => "Command,SerialNumber,TerminalID,LogTime,AdminID,UserID,Action,Result",
            "AlarmLog" => "Command,SerialNumber",
            "KeeyAlive" => "Command,SerialNumber",
        ];
        $allowed_commands = array_keys($csv_headers_by_command);
        $enabled_commands = ["LOG"];
        if(in_array($request_command, $allowed_commands) === FALSE) {
            return response()->json(['error' => 'Command Not Found', 'code' => 404], 404);
        }

        if(in_array($request_command, $enabled_commands) === FALSE) {
            return response()->json(['error' => 'Command Not Enabled', 'code' => 404], 404);
        }

        $request_message_body_csv = str_getcsv($request_message);
        $request_message_header_csv = str_getcsv($csv_headers_by_command[$request_command]);
        $request_message_map = array_combine($request_message_header_csv, $request_message_body_csv);

        $timestamp = !empty($request_message_map['LogTime']) ? $request_message_map['LogTime'] : now()->format("Y-m-d H:i:s");
        $registered_attendance = AttendanceDevice::register_attendance(
            $request_message_map['UserID'],
            $request_message_map['SerialNumber'],
            $request_message_map['TerminalID'],
            $request_message_map['DeviceSecret'],
            $request->ip(),
            $timestamp
        );
        return response()->json($registered_attendance, $registered_attendance['code']);
    }
}
