<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Utilities\GoogleDriveUtility;

class ProductController extends Controller
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

    public function addProduct(ProductRequest $request )
    {
        $validate = $request->validated();

        try{
            DB::beginTransaction();

            $newProduct = new Product;
            $newProduct->product_serial_code = 'PRODUCT_00' . $newProduct->id;
            $newProduct->name_en = $validate['name_en'];
            $newProduct->name_id = $validate['name_id'];
            $newProduct->description_en = $validate['description_en'];
            $newProduct->description_id = $validate['description_id'];
            $newProduct->price = $validate['price'];
            $newProduct->stocks = $validate['stocks'];
            $newProduct->category_id = $validate['category_id'];
            $newProduct->sustainability_score = $validate['sustainability_score'];
            $newProduct->save();
            
            DB::commit();

            return redirect()->route('admin.product.add')->with('success', 'Product added successfully.');
        }catch(\Exception $e){
            DB::rollBack();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
