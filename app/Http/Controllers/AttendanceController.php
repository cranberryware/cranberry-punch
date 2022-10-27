<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function kiosk()
    {
        return view('attendance.kiosk', ['title' => 'Attendance']);
    }
}
