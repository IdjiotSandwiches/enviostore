<?php

namespace App\Traits;

use App\Interfaces\LocaleInterface;
use Illuminate\Support\Facades\App;

trait LangTrait 
{
    /**
     * Summary of getLangVariant
     * @param string $base
     * @return string
     */
    public function getLangVariant($base)
    {
        if (App::isLocale(LocaleInterface::ID)) {
            return $this->{"{$base}_id"};
        }

        return $this->{"{$base}_en"};
    }
}