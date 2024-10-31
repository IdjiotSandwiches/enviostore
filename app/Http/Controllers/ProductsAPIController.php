<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utilities\ProductsUtility;
use App\Http\Controllers\Controller;

class ProductsAPIController extends Controller
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
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = $this->productUtility->getProducts();

        return response()->json([
            'status' => 200,
            'message' => 'Data sorted!',
            'data' => $products,
        ], Response::HTTP_OK);
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
            'status' => 200,
            'message' => 'Data sorted!',
            'data' => $products,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
