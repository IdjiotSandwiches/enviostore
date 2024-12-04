<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Helpers\StringHelper;
use App\Utilities\GoogleDriveUtility;

class ProductService
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
     * Summary of getProduct
     * @param string $product_serial
     * @return array
     */
    public function getProduct($product_serial)
    {
        $product = Product::with('productImage')->where('product_serial_code', $product_serial)
            ->first();
        if (!$product) abort(404);

        $productImgUrls = $product->productImage->pluck('url');
        $productImgs = [];
        foreach($productImgUrls as $url) {
            $productImgs[] = $this->googleDriveUtility->getFile($url);
        }

        $product = (object) [
            'name' => $product->name,
            'product_serial' => $product->product_serial_code,
            'price' => StringHelper::parseNumberFormat($product->price),
            'stocks' => $product->stocks,
            'description' => $product->description,
            'images' => $productImgs,
        ];

        return [$product, $productImgs];
    }
}
