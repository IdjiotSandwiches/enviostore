<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use App\Utilities\GoogleDriveUtility;
use Faker\Core\File;

class HomeController extends Controller
{
    private $googleDriveUtility;
    private $productsUtility;

    public function __construct() 
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productsUtility = new ProductsUtility();
    }
    
    public function getHomeProduct()
    {
        //hitung product kelipatan 4
        $totalProducts = Product::count();
        $limit = $totalProducts - ($totalProducts%4);
        if($limit == 0 && $totalProducts >0){
            $limit = $totalProducts;
        }
        
        $products = Product::take($limit)->get()
        ->map(function($product) {
            $name = $product->name;
            $price = $product->price;
            $rating = $product->sustainability_score;

            $imgUrl = ProductImage::where('product_id', $product->id)->first();
            $img = $this->googleDriveUtility->getImage($imgUrl->url);
            
            $link = route('getProduct', base64_encode("$name-$product->id"));

            return (object) compact('name', 'rating', 'price', 'img', 'link');
        });
        return $products;
    }


    public function getAllProduct ()
    {
        $bannerUrls = ['home_carousel_images/Banner1.png', 'home_carousel_images/Banner2.png', 'home_carousel_images/Banner3.png', 'home_carousel_images/Banner4.png'];
        $banners = [];
        foreach($bannerUrls as $url){
            $banners[] = $this->googleDriveUtility->getImage($url);
        }
        $products = $this->getHomeProduct();
        return view('Welcome', compact('banners', 'products'));
    }

}
