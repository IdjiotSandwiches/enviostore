<?php

namespace App\Utilities;

use App\Models\ProductImage;
use App\Interfaces\SortInterface;
use App\Interfaces\SortDirectionInterface;
use App\Utilities\GoogleDriveUtility;

class ProductsUtility implements SortInterface, SortDirectionInterface
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
     * @param int $sort
     * @param string $category
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($products, $sort = self::NEWEST, $category = null)
    {
        $products = $products->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        });

        $products = match ($sort) {
            self::NEWEST => $products->orderBy('created_at', self::ASCENDING),
            self::HIGHEST_PRICE => $products->orderBy('price', self::DESCENDING),
            self::LOWEST_PRICE => $products->orderBy('price', self::ASCENDING),
        };

        $products = $products->paginate(20, ['*'], 'products')
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
