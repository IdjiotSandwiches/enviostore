<?php

namespace App\Utilities;

use App\Models\ProductImage;
use App\Interfaces\SortDirectionInterface;

class ProductsUtility implements SortDirectionInterface
{
    private $googleDriveUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    /**
     * Summary of getProducts
     * @param \App\Models\Product $products
     * @param string $category
     * @param mixed $column
     * @param mixed $sortDirection
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($products, $category = null, $column = 'created_at', $sortDirection = self::ASCENDING)
    {
        $products = $products->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->orderBy($column, $sortDirection)
            ->paginate(20, ['*'], 'products')
            ->through(function ($product) {
                $name = $product->name;
                $price = $product->price;
                $imgUrl = ProductImage::where('product_id', $product->id)->first();
                $img = $this->googleDriveUtility->getImage($imgUrl->url);
                $link = route('getProduct', base64_encode("$name-$product->id"));

                return (object) compact('name', 'price', 'img', 'link');
            });

        return $products;
    }
}
