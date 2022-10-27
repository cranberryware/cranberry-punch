<?php

namespace App\Support;

use OpaqueEncoder;

class Encoders
{
    public static function base62_encode($data)
    {
        $output = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i += 8) {
            $chunk = substr($data, $i, 8);
            $output_len = ceil((strlen($chunk) * 8) / 6); //8bit/char in, 6bits/char out, round up
            $x = bin2hex($chunk);  //gmp won't convert from binary, so go via hex
            $w = gmp_strval(gmp_init(ltrim($x, '0'), 16), 62); //gmp doesn't like leading 0s
            $pad = str_pad($w, $output_len, '0', STR_PAD_LEFT);
            $output .= $pad;
        }
        return $output;
    }
    public static function base62_decode($data)
    {
        $output = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i += 11) {
            $chunk = substr($data, $i, 11);
            $output_len = floor((strlen($chunk) * 6) / 8); //6bit/char in, 8bits/char out, round down
            $y = gmp_strval(gmp_init(ltrim($chunk, '0'), 62), 16); //gmp doesn't like leading 0s
            $pad = str_pad($y, $output_len * 2, '0', STR_PAD_LEFT); //double output length as as we're going via hex (4bits/char)
            $output .= pack('H*', $pad); //same as hex2bin
        }
        return $output;
    }

    public static function encode_id($id)
    {
        $encoder = new OpaqueEncoder(0x1ce3f59e);
        return $encoder->encode($id);
    }

    public static function decode_id($encoded_id)
    {
        $encoder = new OpaqueEncoder(0x1ce3f59e);
        return $encoder->decode($encoded_id);
    }

    public static function short_code_from_id($id)
    {
        return self::base62_encode(self::encode_id($id));
    }

    public static function id_from_short_code($id)
    {
        return self::decode_id(self::base62_decode($id));
    }
}
