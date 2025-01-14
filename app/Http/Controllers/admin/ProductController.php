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

    public function addProduct(ProductRequest $request)
    {
        $validate = $request->validated();
    
        try {
            DB::beginTransaction();

            $lastProduct = Product::latest()->first();
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

            if (isset($validate['product_images'])) {
                $fileExtension = $validate['product_images']->getClientOriginalExtension();
                $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;
    
                $this->googleDriveUtility->storeFile($fileName, $validate['product_images']);
    
                $productImage = new ProductImage();
                $productImage->url = $fileName;
                $productImage->product_id = $newProduct->id;
                $productImage->save();
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
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editProductIndex($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.product.list')->with('error', 'Product not found.');
        }

        $categories = Category::all(); // Assuming categories are needed for the dropdown.
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(EditProductRequest $request, $id)
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

            if ($request->hasFile('product_images')) {
                $fileExtension = $validated['product_images']->getClientOriginalExtension();
                $fileName = 'product_images/' . uniqid('product_') . '.' . $fileExtension;

                $this->googleDriveUtility->storeFile($fileName, $validated['product_images']);
                $product->image_url = $fileName; // Assuming your `products` table has an `image_url` column.
            }

            $product->save();

            DB::commit();

            return redirect()->route('admin.product.list')->with('success', 'Product updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
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
            
            $product = Product::find($id);
    
            if (!$product) {
                throw new Exception(__('message.invalid'));
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
