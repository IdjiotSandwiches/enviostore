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
            $name = ucwords($category->name);
            $url = $category->url;
            $image = $this->googleDriveUtility->getFile($url);
            $link = route('categoryPage', base64_encode($category->category_serial_code));

            return (object) compact('name', 'image', 'link');
        });

        return $categories;
    }

    /**
     * Summary of getImgs
     * @param string $path
     * @return array
     */
    public function getImgs($path)
    {
        $urls = $this->googleDriveUtility->getAllFilePaths($path);
        $imgs = [];
        foreach($urls as $url){
            $imgs[] = $this->googleDriveUtility->getFile($url);
        }

        return $imgs;
    }
}
