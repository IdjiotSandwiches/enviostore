<?php

use App\Helper\StringHelper;

if(!function_exists('parseNumberFormat')) {
    /**
     * Summary of parseNumberFormat
     * @param string $input
     * @return string
     */
    function parseNumberFormat($input) {
        return StringHelper::parseNumberFormat($input);
    }
}
