<?php

namespace App\Utilities;

use App\Models\Product;
use App\Helpers\StringHelper;
use App\Utilities\GoogleDriveUtility;
use App\Interfaces\SortInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\SortDirectionInterface;
use Illuminate\Support\Facades\App;

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
    public function getProducts($category = null, $sort = self::NEWEST, $perPage = 20)
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
            ->paginate($perPage, ['*'], 'products')
            ->through(function ($product) {
                return $this->convertItem($product);
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

    /**
     * Summary of convertItem
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     * @return object
     */
    public function convertItem($product)
    {
        $name = $product->name;
        $price = StringHelper::parseNumberFormat($product->price);
        $rating = $product->sustainability_score;
        $img = $product->productImage->first();
        $img = $this->googleDriveUtility->getFile($img->url);
        $link = route('getProduct', base64_encode($product->product_serial_code));

        return (object) compact('name', 'rating', 'price', 'img', 'link');
    }
    
    /**
     * Summary of convertAdminItem
     * @param mixed $product
     * @return object
     */
    public function convertAdminItem($product)
    {
        $name = $product->name;
        $price = StringHelper::parseNumberFormat($product->price);
        $rating = $product->sustainability_score;
        $img = $product->productImage->first();
        $img = $this->googleDriveUtility->getFile($img->url);
        $stocks = $product->stocks;
        $category_name = $product->category ? $product->category->name : 'Unknown'; 

        return (object) compact('name', 'rating', 'price', 'img', 'stocks', 'category_name');
    }
}
