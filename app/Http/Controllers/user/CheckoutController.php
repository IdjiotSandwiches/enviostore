<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\PaymentRequest;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\User;
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
     * Summary of getOrder
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getOrder($id)
    {
        if (!request()->ajax()) abort(404);

        $order = Order::find($id);

        if (!$order->snap_token) {
            return response()->json([
                'status' => self::STATUS_WARNING,
                'message' => __('message.shipping_not_selected'),
                'data' => [],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Order Retrieved!',
            'data' => $order,
        ], Response::HTTP_OK);
    }

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
            $address = $this->checkoutService->getUserAddress();

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

        return view('checkout.cart', compact('shippings', 'order', 'address'));
    }

    /**
     * Summary of updateShipping
     * @param int $id
     * @param string $shipping
     * @return mixed|\Illuminate\Http\JsonResponse
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

            return response()->json([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
                'data' => [],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Update Shipping Success',
            'data' => [],
        ], Response::HTTP_OK);
    }

    public function pay(PaymentRequest $paymentRequest, $id)
    {
        $order = Order::find($id);
        $order->payment_status = $paymentRequest->result_type;
        $order->save();
    }
}
