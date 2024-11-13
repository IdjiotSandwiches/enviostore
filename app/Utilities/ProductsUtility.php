<?php

namespace App\Utilities;

use App\Models\Product;
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
     * @return object
     */
    public function getProducts($category = null, $sort = self::NEWEST)
    {
        $products = Product::with('productImage')
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category);
            })
            ->when($sort, function ($query) use ($sort) {
                return match ($sort) {
                    self::NEWEST => $query->orderBy('created_at', self::ASCENDING),
                    self::LOWEST_PRICE => $query->orderBy('price', self::ASCENDING),
                    self::HIGHEST_PRICE => $query->orderBy('price', self::DESCENDING),
                };
            })
            ->paginate(20, ['*'], 'products')
            ->through(function ($product) {
                $name = $product->name;
                $price = number_format($product->price, 0, ',', '.');
                $img = $product->productImage->first();
                $img = $this->googleDriveUtility->getImage($img->url);
                $link = route('getProduct', base64_encode("$name-$product->id"));

                return (object) compact('name', 'price', 'img', 'link');
            });

        $products = (object) [
            'products' => $products->items(),
            'hasPage' => $products->hasPages(),
            'nextPageUrl' => $products->nextPageUrl(),
            'previousPageUrl' => $products->previousPageUrl(),
            'count' => $products->count(),
            'total' => $products->total(),
            'firstItem' => $products->firstItem(),
            'lastItem' => $products->lastItem(),
        ];

        return $products;
    }
}
