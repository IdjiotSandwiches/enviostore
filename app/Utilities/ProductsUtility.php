<?php

namespace App\Utilities;

use App\Models\ProductImage;

class ProductsUtility
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
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts($products, $category = null)
    {
        $products = $products->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })
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
