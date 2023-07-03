<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClockingDeviceAuth
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
        // Check if api key matches environment variable
        $apiKey = request()->header('X-Api-Key');
        $envSecretKey = config('app.api_secret_key');

        if ($apiKey !== $envSecretKey) {
            return response()->json(['error' => 'Unauthorized', 'code' => 401], 401);
        }

        return $next($request);
    }
}
