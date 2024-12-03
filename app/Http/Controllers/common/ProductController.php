<?php

namespace App\Http\Controllers\common;

use App\Models\Product;
use App\Models\ErrorLog;
use App\Models\Category;
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utilities\GoogleDriveUtility;
use App\Utilities\ProductsUtility;
use App\Interfaces\StatusInterface;
use App\Http\Controllers\Controller;

class ProductController extends Controller implements StatusInterface
{
    private $googleDriveUtility;
    private $productUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productUtility = new ProductsUtility();
    }

    /**
     * Summary of getProduct
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getProduct($id)
    {
        // Still on work, need to be discuss
        try {
            $id = base64_decode($id);
            $id = explode("-", $id)[1];
        } catch (\Exception $e) {
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            abort(404);
        }

        $product = Product::with('productImage')->find($id);
        if (!$product) abort(404);

        $productImgUrls = $product->productImage->pluck('url');
        $productImgs = [];
        foreach($productImgUrls as $url) {
            $productImgs[] = $this->googleDriveUtility->getFile($url);
        }

        $product = (object) [
            'name' => $product->name,
            'product_serial' => $product->product_serial_code,
            'price' => StringHelper::parseNumberFormat($product->price),
            'stocks' => $product->stocks,
            'description' => $product->description,
            'images' => $productImgs,
        ];

        return view('product', compact('product', 'productImgs'));
    }

    /**
     * Summary of sortProducts
     * @param \Illuminate\Http\Request $request
     * @param string $category
     * @param string $sort
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function sortProducts(Request $request, $category, $sort)
    {
        if (!$request->ajax()) abort(404);

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
