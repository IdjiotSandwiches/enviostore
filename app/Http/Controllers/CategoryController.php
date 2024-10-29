<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use App\Interfaces\CategoryInterface;

class CategoryController extends Controller implements CategoryInterface
{
    private $productUtility;

    public function __construct()
    {
        $this->productUtility = new ProductsUtility();
    }

    /**
     * Summary of index
     * @param string $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($category)
    {
        $category = Category::where('name', $category)->first();

        if(!$category) abort(404);

        $products = $this->productUtility->getProducts($category->id);
        $categoryName = ucfirst($category->name);

        return view('category', compact('categoryName', 'products'));
    }

    public function sortProducts($category, $sort)
    {

    }
}
