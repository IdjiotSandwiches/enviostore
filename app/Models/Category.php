<?php

namespace App\Models;

use App\Traits\LangTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    use LangTrait;

    /**
     * Summary of getName
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->getLangVariant('name');
    }
    
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
