<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Utilities\GoogleDriveUtility;
use App\Utilities\ProductsUtility;

class HomeService
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
     * Summary of getHomeProduct
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getHomeProduct()
    {
        $products = Product::with('productImage')
            ->take(8)
            ->get()
            ->map(function($product) {
                return $this->productsUtility->convertItem($product);
            });

        return $products;
    }

    /**
     * Summary of getCategories
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $categories = Category::all()->map(function($category){
            $name = $category->name;
            $url = $category->url;
            $image = $this->googleDriveUtility->getFile($url);
            $link = route('categoryPage', $category->name);

            return (object) compact('name', 'image', 'link');
        });

        return $categories;
    }

    // Take all item inside the folder
    /**
     * Summary of getBanner
     * @return string[]
     */
    public function getBanner()
    {
        $bannerUrls = ['home_carousel_images/Banner1.png', 'home_carousel_images/Banner2.png', 'home_carousel_images/Banner3.png', 'home_carousel_images/Banner4.png'];
        $banners = [];
        foreach($bannerUrls as $url){
            $banners[] = $this->googleDriveUtility->getFile($url);
        }

        return $banners;
    }
}
