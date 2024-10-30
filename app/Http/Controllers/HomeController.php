<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use App\Utilities\GoogleDriveUtility;

class HomeController extends Controller
{
    private $googleDriveUtilty;
    private $productsUtilty;

    public function __construct() 
    {
        $this->googleDriveUtilty = new GoogleDriveUtility;
        $this->productsUtilty = new ProductsUtility();
    }

    public function getAllProduct ()
    {
        $products = $this->productsUtilty->getHomeProduct();
        // $product = Product::all()->toArray();
        // dd($product);
        return view('Welcome', compact('products'));
    }

}
