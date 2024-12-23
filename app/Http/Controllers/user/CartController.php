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
        return view('cart.index');
    }

    /**
     * Summary of delete
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->cartService->delete($request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ];

            return back()->withInput()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.remove_item'),
        ];

        return back()->with($response);
    }

    /**
     * Summary of getCartItems
     * @param string|null $shipping
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getCartItems($shipping = null)
    {
        $cart = (object) [
            'items' => $this->cartService->getCartItems(),
            'summary' => $this->cartService->getCartSummary($shipping),
        ];

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Fetch Data Success!',
            'data' => $cart,
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
                'message' => __('message.invalid'),
            ];

            return back()->withInput()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.add_to_cart'),
        ];

        return back()->with($response);
    }

    /**
     * Summary of checkout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout()
    {
        return to_route('checkout.index');
    }
}
