<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Utilities\ProductsUtility;
use Illuminate\Http\Request;
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
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = new Product;
        $products = $this->productsUtility->getProducts($products);

        return view('products', compact('products'));
    }

    /**
     * Summary of getProduct
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getProduct($id)
    {
        // Still on work, need to be discuss
        $id = base64_decode($id);
        $id = explode("-", $id)[1];
        $product = Product::find($id);
        $productImgUrls = ProductImage::where('product_id', $id)->pluck('url');
        $productImgs = [];
        foreach($productImgUrls as $url) {
            $img = $this->googleDriveUtility->getImage($url);
            array_push($productImgs, $img);
        }

        return view('product', compact('product', 'productImgs'));
    }
}
