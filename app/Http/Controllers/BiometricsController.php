<?php

namespace App\Http\Controllers;

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
        if (!$request->has('employee_email') || !$request->has('employee_id') || !$request->has('device_serial_number') || !$request->has('device_identifier')) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

    }
}
