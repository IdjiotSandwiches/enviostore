<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Utilities\ProductsUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utilities\GoogleDriveUtility;

class AdminController extends Controller
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
    public function index()
    {
        return view('admin.index');
    }

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
        return view('admin.product.add');
    }

    public function categoryIndex()
    {
        return view('admin.category.category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
