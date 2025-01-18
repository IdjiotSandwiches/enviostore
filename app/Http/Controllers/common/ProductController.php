<?php

namespace App\Http\Controllers\common;

use App\Models\Category;
use App\Services\Product\ProductService;
use App\Utilities\ErrorUtility;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utilities\ProductsUtility;
use App\Interfaces\StatusInterface;
use App\Http\Controllers\Controller;

class ProductController extends Controller implements StatusInterface
{
    private $productUtility;
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->productUtility = new ProductsUtility();
        $this->errorUtility = new ErrorUtility();
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
            $this->errorUtility->errorLog($e->getMessage());

            abort(404);
        }

        [$product, $productImgs] = $productService->getProduct($product_serial);

        return view('product.index', compact('product', 'productImgs'));
    }

    /**
     * Summary of sortProducts
     * @param \Illuminate\Http\Request $request
     * @param string $category
     * @param string $sort
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function sortProducts($category_serial, $sort)
    {
        if (!request()->ajax()) abort(404);

        $category = Category::where('category_serial_code', $category_serial)->first();

        if (!$category) abort(404);

        $products = $this->productUtility->getProducts($category->id, (int) $sort);
        
        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Data sorted!',
            'data' => $products,
        ], Response::HTTP_OK);
    }
}
