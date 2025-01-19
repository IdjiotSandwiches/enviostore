<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductImage;
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
     * Summary of addProduct
     * @param array $validated
     * @return void
     */
    public function addProduct($validated)
    {
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $lastSerialNumber = 0;

        if ($lastProduct && preg_match('/PRODUCT_(\d+)/', $lastProduct->product_serial_code, $matches)) {
            $lastSerialNumber = (int) $matches[1];
        }

        $newSerialNumber = $lastSerialNumber + 1;
        $newProductSerialCode = 'PRODUCT_' . str_pad($newSerialNumber, 3, '0', STR_PAD_LEFT);

        $newProduct = new Product();
        $newProduct->name_en = $validated['name_en'];
        $newProduct->name_id = $validated['name_id'];
        $newProduct->description_en = $validated['description_en'];
        $newProduct->description_id = $validated['description_id'];
        $newProduct->price = $validated['price'];
        $newProduct->stocks = $validated['stocks'];
        $newProduct->category_id = $validated['category_id'];
        $newProduct->sustainability_score = $validated['sustainability_score'];
        $newProduct->product_serial_code = $newProductSerialCode;

        $newProduct->save();

        if (isset($validated['product_images']) && is_array($validated['product_images'])) {
            foreach ($validated['product_images'] as $file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;

                $this->googleDriveUtility->storeFile($fileName, $file);

                $productImage = new ProductImage();
                $productImage->url = $fileName;
                $productImage->product_id = $newProduct->id;
                $productImage->save();
            }
        }
    }

    /**
     * Summary of addProductImages
     * @param int $id
     * @param array $validated
     * @throws \Exception
     * @return void
     */
    public function addProductImages($id, $validated)
    {
        $product = Product::find($id);
        if (!$product)
            throw new \Exception('Product not found.');

        if (isset($validated['product_images']) && is_array($validated['product_images'])) {
            foreach ($validated['product_images'] as $file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;

                $this->googleDriveUtility->storeFile($fileName, $file);

                $productImage = new ProductImage();
                $productImage->url = $fileName;
                $productImage->product_id = $product->id;
                $productImage->save();
            }
        }
    }

    /**
     * Summary of updateProduct
     * @param int $id
     * @param array $validated
     * @throws \Exception
     * @return void
     */
    public function updateProduct($id, $validated)
    {
        $product = Product::find($id);
        if (!$product)
            throw new \Exception('Product not found.');

        $product->name_en = $validated['name_en'];
        $product->name_id = $validated['name_id'];
        $product->description_en = $validated['description_en'];
        $product->description_id = $validated['description_id'];
        $product->price = $validated['price'];
        $product->stocks = $validated['stocks'];
        $product->category_id = $validated['category_id'];
        $product->sustainability_score = $validated['sustainability_score'];

        $product->save();
    }

    /**
     * Summary of deleteProduct
     * @param int $id
     * @throws \Exception
     * @return void
     */
    public function deleteProduct($id)
    {
        $product = Product::with('productImage')->find($id);

        if (!$product) throw new \Exception(__('message.invalid'));

        foreach ($product->productImage as $image) {
            $this->googleDriveUtility->deleteFile($image->url);
            $image->delete();
        }

        $product->delete();
    }
}