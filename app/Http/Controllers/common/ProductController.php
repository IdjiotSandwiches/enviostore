<?php

namespace App\Http\Controllers\common;

use App\Models\ErrorLog;
use App\Models\Category;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utilities\ProductsUtility;
use App\Interfaces\StatusInterface;
use App\Http\Controllers\Controller;

class ProductController extends Controller implements StatusInterface
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
     * Summary of getProduct
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getProduct($product_serial, ProductService $productService)
    {
        try {
            $product_serial = base64_decode($product_serial);
        } catch (\Exception $e) {
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            abort(404);
        }

        [$product, $productImgs] = $productService->getProduct($product_serial);

        return view('product', compact('product', 'productImgs'));
    }

    /**
     * Summary of sortProducts
     * @param \Illuminate\Http\Request $request
     * @param string $category
     * @param string $sort
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function sortProducts($category, $sort)
    {
        if (!request()->ajax()) abort(404);

        $category = Category::where('name', $category)->first();

        if (!$category) abort(404);

        $products = $this->productUtility->getProducts($category->id, (int) $sort);
        
        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Data sorted!',
            'data' => $products,
        ], Response::HTTP_OK);
    }
}
