<?php // Code within app\Helpers\Helper.php

namespace App\Helpers\Helper;

use Closure;
use Illuminate\Support\Facades\Log;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function manageRoll(Closure $get) {
        return (auth()->user()->hasRole(['hr-manager', 'super-admin'])) ? false : ($get('employee_id') !== auth()->user()->employee->id);
    }

    public static function getRedirectUrl($request): string
    {
        return $request->getResource()::getUrl('index');
    }
}