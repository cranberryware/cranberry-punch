<?php

namespace App\Support;

use Illuminate\Support\Str as IStr;

class Str extends IStr
{
    public static function generate_fld_key($value)
    {
        return substr("fld_" . str_replace('-', '_', IStr::slug($value)), 0, 64);
    }

    public static function remove_prefix($str, $prefix)
    {
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            $str = substr($str, strlen($prefix));
        }
        return $str;
    }

    public static function subscript_decimal($num)
    {
        if (!is_numeric($num)) {
            return "";
        }
        $num = number_format($num, 2, '.', '');
        $num_parts = explode('.', $num);
        return $num_parts[0] . '<sub>.' . $num_parts[1] . '</sub>';
    }

}
