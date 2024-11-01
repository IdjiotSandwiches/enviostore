<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ErrorLog;
use App\Models\ProductImage;
use App\Utilities\GoogleDriveUtility;

class ProductController extends Controller
{
    private $googleDriveUtility;
    private $productsUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
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
            $img = $this->googleDriveUtility->getImage($url);
            array_push($productImgs, $img);
        }

        return view('product', compact('product', 'productImgs'));
    }
}
