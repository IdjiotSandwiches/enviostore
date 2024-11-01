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
        $products = Product::with('productImage')
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category);
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    self::NEWEST => $query->orderBy('created_at', self::ASCENDING),
                    self::LOWEST_PRICE => $query->orderBy('price', self::ASCENDING),
                    self::HIGHEST_PRICE => $query->orderBy('price', self::DESCENDING),
                };
            })
            ->paginate(2, ['*'], 'products')
            ->through(function ($product) {
                $name = $product->name;
                $price = $product->price;
                $img = $product->productImage->first();
                $img = $this->googleDriveUtility->getImage($img->url);
                $link = route('getProduct', base64_encode("$name-$product->id"));

                return (object) compact('name', 'price', 'img', 'link');
            });

        return $products;
    }
}
