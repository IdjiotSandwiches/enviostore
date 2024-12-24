<?php

namespace App\Http\Controllers\user;

use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\ErrorLog;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CheckoutController extends Controller implements SessionKeyInterface, StatusInterface
{
    private $checkoutService;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
    }
    
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    // public function index()
    // {
    //     $shippings = $this->checkoutService->getCheckoutCredentials();
    //     $order = $this->checkoutService->createOrderFromCart();

    //     return view('checkout.index', compact('shippings', 'order'));
    // }

    /**
     * Summary of createOrderFromCart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createOrderFromCart()
    {
        try {
            DB::beginTransaction();

            $shippings = $this->checkoutService->getCheckoutCredentials();
            $order = $this->checkoutService->createOrderFromCart();

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

        return view('checkout.index', compact('shippings', 'order'));
    }

    /**
     * Summary of updateShipping
     * @param string $id
     * @param string $shipping
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateShipping($id, $shipping)
    {
        if (!request()->ajax()) abort(404);

        try {
            DB::beginTransaction();

            $this->checkoutService->updateShipping($id, $shipping);

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

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Update Shipping Success',
            'data' => [],
        ], Response::HTTP_OK);
    }

    // public function pay()
    // {
    //     if (!session(self::SESSION_CHECKOUT)) abort(404);
    //     session()->forget(self::SESSION_CHECKOUT);

        
    // }
}
