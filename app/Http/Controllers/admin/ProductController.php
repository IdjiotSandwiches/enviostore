<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ErrorLog;
use App\Models\ProductImage;
use App\Services\Admin\ProductService;
use App\Utilities\ErrorUtility;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Interfaces\StatusInterface;
use App\Utilities\GoogleDriveUtility;

class ProductController extends Controller implements StatusInterface
{
    private $googleDriveUtility;
    private $productsUtility;
    private $productService;
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productsUtility = new ProductsUtility();
        $this->productService = new ProductService();
        $this->errorUtility = new ErrorUtility();
    }

    /**
     * Summary of productIndex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function productIndex()
    {
        $products = Product::with('productImage', 'category')
            ->get()
            ->map(function ($product) {
                return $this->productsUtility->convertAdminItem($product);
            });

        return view('admin.product.products', compact('products'));
    }

    /**
     * Summary of addProductIndex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addProductIndex()
    {
        $categories = Category::all();
        return view('admin.product.add', compact('categories'));
    }

    /**
     * Summary of editProductIndex
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editProductIndex($id)
    {
        $product = Product::with('productImage')->find($id);
        if (!$product) {
            return back()->with('error', 'Product not found.');
        }
        $productImages = $product->productImage->map(function ($image) {
            $image->converted_url = $this->googleDriveUtility->getFile($image->url);
            return $image;
        });

        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'productImages', 'categories'));
    }

    /**
     * Summary of addProduct
     * @param \App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProduct(ProductRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $this->productService->addProduct($validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to add product',
            ]);
        }

        return to_route('admin.product.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Product added successfully.',
        ]);
    }

    /**
     * Summary of addProductImages
     * @param \App\Http\Requests\ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProductImages(ProductRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->productService->addProductImages($id, $validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to add product images',
            ]);
        }

        return to_route('admin.product.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Images uploaded successfully.',
        ]);
    }

    /**
     * Summary of updateProduct
     * @param \App\Http\Requests\ProductRequest $request
     * @param int $id
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(ProductRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $this->productService->updateProduct($id, $validated);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->errorUtility->errorLog($e->getMessage());
            
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to update product',
            ]);
        }

        return to_route('admin.product.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Product update successfully.',
        ]);
    }

    /**
     * Summary of deleteProductImage
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProductImage($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return back()->with([
                'status' => self::STATUS_SUCCESS,
                'message' => 'Image not found.',
            ]);
        }

        try {
            DB::beginTransaction();

            $this->googleDriveUtility->deleteFile($image->url);

            $image->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->errorUtility->errorLog($e->getMessage());
            
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to delete image',
            ]);
        }

        return to_route('admin.product.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Image deleted successfully.',
        ]);
    }

    /**
     * Summary of deleteProduct
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->productService->deleteProduct($request->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());
            
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to delete product',
            ]);
        }

        return back()->with([
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.remove_item'),
        ]);
    }
}
