<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;

class CategoryController extends Controller
{
    private $productUtility;

    public function __construct()
    {
        $this->productUtility = new ProductsUtility();
    }

    public function index()
    {
        return view('category');
    }

    // nanti ganti ke index
    public function indexProducts($category)
    {

    }

    public function sortProducts($category, $sort)
    {

    }
}
