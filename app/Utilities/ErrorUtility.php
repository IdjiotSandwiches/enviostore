<?php

namespace App\Utilities;

use App\Models\ErrorLog;

class ErrorUtility
{
    public function errorLog($message)
    {
        $errorLog = new ErrorLog();
        $errorLog->error = $message;
        $errorLog->save();
    }
}