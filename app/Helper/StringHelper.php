<?php

namespace App\Helper;

class StringHelper
{
    /**
     * Summary of parseNumberFormat
     * @param string $input
     * @return string
     */
    public static function parseNumberFormat($input)
    {
        return number_format($input, 0, ',', '.');
    }
}
