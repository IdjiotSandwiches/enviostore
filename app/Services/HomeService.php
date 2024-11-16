<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Utilities\GoogleDriveUtility;


class HomeService
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
     * Summary of getHomeProduct
     * @return mixed
     */
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
    
    /**
     * Summary of getCategoryAll
     * @return mixed
     */
    public function getCategoryAll()
    {
        $categories = Category::take(4)->get()
        ->map(function($category){
            $name = $category->name;
            $url = $category->url;

            $image = $this->googleDriveUtility->getImage($url);
            //TODO: added when merge with category
            //$link = route()

            return (object) compact('name', 'image');
        });
        return $categories;
    }

    /**
     * Summary of getBanner
     * @return string[]
     */
    public function getBanner()
    {
        $bannerUrls = ['home_carousel_images/Banner1.png', 'home_carousel_images/Banner2.png', 'home_carousel_images/Banner3.png', 'home_carousel_images/Banner4.png'];
        $banners = [];
        foreach($bannerUrls as $url){
            $banners[] = $this->googleDriveUtility->getImage($url);
        }
        return $banners;
    }
}