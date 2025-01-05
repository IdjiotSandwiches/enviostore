<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\PaymentRequest;
use App\Http\Requests\ShippingRequest;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Utilities\ErrorUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CheckoutController extends Controller implements SessionKeyInterface, StatusInterface
{
    private $checkoutService;
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
        $this->errorUtility = new ErrorUtility();
    }


    public function createOrder(ShippingRequest $shippingRequest)
    {
        $validated = $shippingRequest->validated();

        if (!$this->checkoutService->hasAddress()) {
            return response()->json([
                'status' => self::STATUS_WARNING,
                'message' => __('message.insert_address'),
                'data' => [],
            ], Response::HTTP_OK);
        }

        if (!isset($validated['shippings'])) {
            return response()->json([
                'status' => self::STATUS_WARNING,
                'message' => __('message.shipping_not_selected'),
                'data' => [],
            ], Response::HTTP_OK);
        }

        try {
            DB::beginTransaction();

            $order = $this->checkoutService->createOrderFromCart($validated['shippings']);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return response()->json([
                'status' => self::STATUS_ERROR,
                'message' => '',
                'data' => $order,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Order Retrieved!',
            'data' => $order,
        ], Response::HTTP_OK);
    }

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            DB::beginTransaction();

            $this->checkoutService->isAcceptable();
            $shippings = $this->checkoutService->getCheckoutCredentials();
            $address = $this->checkoutService->getUserAddress();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ];

            return back()->withInput()->with($response);
        }

        return view('checkout.index', compact('shippings', 'address'));
    }

    /**
     * Summary of pay
     * @param \App\Http\Requests\PaymentRequest $paymentRequest
     * @return Order|\Illuminate\Database\Eloquent\Model
     */
    public function pay(PaymentRequest $paymentRequest)
    {
        try {
            DB::beginTransaction();

            $order = $this->checkoutService->createOrderFromCart($paymentRequest->shipping);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());
        }

        return $order;
    }
}
