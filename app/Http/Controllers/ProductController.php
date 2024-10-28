<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Utilities\GoogleDriveUtility;

class ProductController extends Controller
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
     * Summary of index
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = new Product;
        $products = $products->paginate(2, ['*'], 'products')
            ->through(function ($product) {
                $name = $product->name;
                $price = $product->price;
                $imgUrl = ProductImage::where('product_id', $product->id)->first()->pluck('url');
                $imgUrl = $this->googleDriveUtility->getImage($imgUrl);

                return (object) compact('name', 'price', 'imgUrl');
            });

        return view('products', compact('products'));
    }

    public function getProduct($id)
    {
        // Still on work, need to be discuss
        // $id = base64_decode($id);
        // $id = explode("_", $id)[1];
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
