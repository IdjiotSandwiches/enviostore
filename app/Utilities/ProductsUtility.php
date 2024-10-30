<?php

namespace App\Utilities;

use App\Models\Product;
use App\Models\ProductImage;
use App\Utilities\GoogleDriveUtility;
use App\Interfaces\SortInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\SortDirectionInterface;

class ProductsUtility implements SortInterface, SortDirectionInterface, CategoryInterface
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
     * @param string $category
     * @param int $sort
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($category = null, $sort = self::NEWEST)
    {
        $products = Product::when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        });

        $products = match ($sort) {
            self::NEWEST => $products->orderBy('created_at', self::ASCENDING),
            self::LOWEST_PRICE => $products->orderBy('price', self::ASCENDING),
            self::HIGHEST_PRICE => $products->orderBy('price', self::DESCENDING),
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

    //without pagination, for homepage
    public function getHomeProduct()
    {
        $products = Product::take(8)->get()
        ->map(function($product) {
            $name = $product->name;
            $price = $product->price;
            $rating = $product->sustainability_score;

            $imgUrl = ProductImage::where('product_id', $product->id)->first();
            $img = $this->googleDriveUtility->getImage($imgUrl->url);
            
            $link = route('getProduct', base64_encode("$name-$product->id"));

            return (object) compact('name', 'rating', 'price', 'img', 'link');
        });
        return $products;
    }
}
