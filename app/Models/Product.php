<?php

namespace App\Models;

use App\Traits\LangTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    use LangTrait;

    /**
     * Summary of getProductName
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->getLangVariant('name');
    }

    /**
     * Summary of getProductDescription
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->getLangVariant('description');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cart()
    {
        return $this->hasOne(Product::class);
    }
}
