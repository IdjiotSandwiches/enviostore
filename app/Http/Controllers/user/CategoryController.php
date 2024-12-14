<?php

namespace App\Http\Controllers\user;

use App\Models\Category;
use App\Models\ErrorLog;
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
    public function index($category_serial)
    {
        try {
            $category_serial = base64_decode($category_serial);
        } catch (\Exception $e) {
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            abort(404);
        }

        $category = Category::where('category_serial_code', $category_serial)->first();

        if (!$category) abort(404);
      
        return view('category.index', compact('category'));
    }
}
