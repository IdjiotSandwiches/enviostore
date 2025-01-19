<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ErrorLog;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\ProductRequest;
use App\Interfaces\StatusInterface;
use App\Utilities\GoogleDriveUtility;
use Exception;

class ProductController extends Controller implements StatusInterface
{
    private $googleDriveUtility;
    private $productsUtility;
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productsUtility = new ProductsUtility();
    }
    /**
     * Display a listing of the resource.
     */
    public function productIndex()
    {
        $products = Product::with('productImage', 'category')
        ->get()
        ->map(function($product) {
            return $this->productsUtility->convertAdminItem($product);
        });
        
        return view('admin.product.products', compact('products'));
    }
    
    public function addProductIndex()
    {
        $categories = Category::all();
        return view('admin.product.add', compact('categories'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function editProductIndex($id)
    {
        $product = Product::with('productImage')->find($id);
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }
        $productImages = $product->productImage->map(function ($image) {
            $image->converted_url = $this->googleDriveUtility->getFile($image->url);
            return $image;
        });

        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'productImages', 'categories'));
    }

    public function addProduct(ProductRequest $request)
    {
        $validate = $request->validated();
    
        try {
            DB::beginTransaction();

            $lastProduct = Product::orderBy('id', 'desc')->first();
            $lastSerialNumber = 0;
    
            if ($lastProduct && preg_match('/PRODUCT_(\d+)/', $lastProduct->product_serial_code, $matches)) {
                $lastSerialNumber = (int)$matches[1];
            }
    
            $newSerialNumber = $lastSerialNumber + 1;
            $newProductSerialCode = 'PRODUCT_' . str_pad($newSerialNumber, 3, '0', STR_PAD_LEFT);
    
            $newProduct = new Product();
            $newProduct->name_en = $validate['name_en'];
            $newProduct->name_id = $validate['name_id'];
            $newProduct->description_en = $validate['description_en'];
            $newProduct->description_id = $validate['description_id'];
            $newProduct->price = $validate['price'];
            $newProduct->stocks = $validate['stocks'];
            $newProduct->category_id = $validate['category_id'];
            $newProduct->sustainability_score = $validate['sustainability_score'];
            $newProduct->product_serial_code = $newProductSerialCode;
    
            $newProduct->save();

            if (isset($validate['product_images']) && is_array($validate['product_images'])) {
                foreach ($validate['product_images'] as $file) {
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;
            
                    $this->googleDriveUtility->storeFile($fileName, $file);
            
                    $productImage = new ProductImage();
                    $productImage->url = $fileName;
                    $productImage->product_id = $newProduct->id;
                    $productImage->save();
                }
            }
    
            DB::commit();
    
            return to_route('admin.addProductIndex')->with('success', 'Product added successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();
    
            return back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }
    
    public function addProductImages(ProductRequest $request, $id)
    {
        try{      
            $product = Product::find($id);
            
            $validate = $request->validated();
            
            if (isset($validate['product_images']) && is_array($validate['product_images'])) {
                foreach ($validate['product_images'] as $file) {
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;
                    
                    $this->googleDriveUtility->storeFile($fileName, $file);
                    
                    $productImage = new ProductImage();
                    $productImage->url = $fileName;
                    $productImage->product_id = $product->id;
                    $productImage->save();
                }
            }
            return redirect()->route('admin.editProduct', $product->id)->with('success', 'Images uploaded successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();
            
            return back()->with('error', 'Failed to add product images: ' . $e->getMessage());
        }
    }
    
    
    
    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(ProductRequest $request, $id)
    {
        $validated = $request->validated();
        
        try {
            DB::beginTransaction();
            
            $product = Product::find($id);
            if (!$product) {
                throw new Exception('Product not found.');
            }
            
            $product->name_en = $validated['name_en'];
            $product->name_id = $validated['name_id'];
            $product->description_en = $validated['description_en'];
            $product->description_id = $validated['description_id'];
            $product->price = $validated['price'];
            $product->stocks = $validated['stocks'];
            $product->category_id = $validated['category_id'];
            $product->sustainability_score = $validated['sustainability_score'];
            
            $product->save();
            
            DB::commit();
            
            return back()->with('success', 'Product update successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();
            
            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }
    public function deleteProductImage($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return back()->with('error', 'Image not found.');
        }

        try {
            $this->googleDriveUtility->deleteFile($image->url);

            $image->delete();

            return back()->with('success', 'Image deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $id = $request->id;
            
            $product = Product::with('productImage')->find($id);
    
            if (!$product) {
                throw new Exception(__('message.invalid'));
            }

            foreach ($product->productImage as $image) {
                $this->googleDriveUtility->deleteFile($image->url); 
                $image->delete(); 
            }
    
            $product->delete();
    
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
    
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();
    
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.remove_item'),
        ];

        return back()->with($response);
    }
}
