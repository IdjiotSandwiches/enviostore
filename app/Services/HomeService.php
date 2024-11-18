<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Helpers\StringHelper;
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
     * Summary of getCategoryAll
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
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
