<?php

namespace App\Http\Middleware;

use App\Models\ClockingDeviceLog;
use Closure;
use Illuminate\Http\Request;

class ClockingDeviceLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = collect($request->header())->transform(function ($item) {
            return $item[0];
        });
        $body = $request->all();
        $clocking_device_log = new ClockingDeviceLog();
        $clocking_device_log->payload = json_encode([
            'headers' => $headers,
            'body' => $body
        ]);
        $clocking_device_log->save();
        return $next($request);
    }
}
