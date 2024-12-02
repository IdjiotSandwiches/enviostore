<?php

namespace App\Http\Controllers\common;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use App\Interfaces\CategoryInterface;
use App\Http\Controllers\Controller;

class CategoryController extends Controller implements CategoryInterface
{
    private $productUtility;

    /**
     * Summary of __construct
     */
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

        if (!$category) abort(404);
      
        return view('category', compact('category'));
    }
}
