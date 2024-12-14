<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        App::setLocale($locale);
        session(['locale' => $locale]);
    
        return redirect()->back();
    }
}
