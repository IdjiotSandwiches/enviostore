<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LangTrait;

class Shipping extends Model
{
    use LangTrait;

    /**
     * Summary of getProductDescription
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->getLangVariant('description');
    }
}
