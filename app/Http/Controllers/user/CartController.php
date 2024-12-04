<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Interfaces\SessionKeyInterface;
use App\Services\Product\CartService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller implements StatusInterface, SessionKeyInterface
{
    private $cartService;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->cartService = new CartService();
    }

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cart');
    }

    public function getCartItems()
    {
        $items = $this->cartService->getCartItems();

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => '',
            'data' => $items,
        ], Response::HTTP_OK);
    }

    /**
     * Summary of addToCart
     * @param \App\Http\Requests\CartRequest $cartRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(CartRequest $cartRequest)
    {
        $item = $cartRequest->validated();

        try {
            DB::beginTransaction();
            
            $this->cartService->addToCart($item);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'Invalid operation.',
            ];

            return back()->withInput()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Product added to cart.',
        ];

        return back()->with($response);
    }
}
