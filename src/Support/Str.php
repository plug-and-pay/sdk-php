<?php

namespace PlugAndPay\Sdk\Support;

class Str
{
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    public static function random(int $length = 16): string
    {
        return (static function ($length) {
            $string = '';

            while (($len = strlen($string)) < $length) {
                $size = $length - $len;

                $bytesSize = (int) ceil($size / 3) * 3;

                $bytes = random_bytes($bytesSize);

                $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
            }

            return $string;
        })($length);
    }
}
