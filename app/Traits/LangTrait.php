<?php

namespace App\Traits;

trait LangTrait 
{
    /**
     * Summary of getLangVariant
     * @param string $base
     * @return string
     */
    public function getLangVariant($base)
    {
        if (app()->isLocale('id')) {
            return $this->{"{$base}_id"};
        }

        return empty($this->{"{$base}_id"}) ? $this->{"{$base}_en"} : $this->{"{$base}_id"};
    }
}