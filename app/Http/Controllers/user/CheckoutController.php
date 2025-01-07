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

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!$this->checkoutService->hasCart()) {
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => __('message.empty_cart'),
            ]);
        }

        try {
            DB::beginTransaction();

            $this->checkoutService->isAcceptable();
            $shippings = $this->checkoutService->getCheckoutCredentials();
            $address = $this->checkoutService->getUserAddress();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->withInput()->with([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return view('checkout.index', compact('shippings', 'address'));
    }

    /**
     * Summary of createOrder
     * @param \App\Http\Requests\ShippingRequest $shippingRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrder(ShippingRequest $shippingRequest)
    {
        $validated = $shippingRequest->validated();

        if (!$this->checkoutService->hasAddress()) {
            return back()->with([
                'status' => self::STATUS_WARNING,
                'message' => __('message.insert_address'),
            ]);
        }

        try {
            DB::beginTransaction();

            $order = $this->checkoutService->createOrderFromCart($validated['shippings']);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return to_route('checkout.payment', $order->id);
    }

    public function paymentPage($id)
    {
        $order = Order::find($id);
        return view('payment', compact('order'));
    }
    
    /**
     * Summary of update
     * @param \App\Http\Requests\PaymentRequest $paymentRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $paymentRequest)
    {
        $validated = $paymentRequest->validated();
        
        try {
            DB::beginTransaction();

            $order = Order::find($validated['order_id']);
            $paymentResult = json_decode($validated['result_data']);
            
            $order->payment_status = $paymentResult->transaction_status;
            $order->save();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => __('message.invalid'),
            ]);
        }

        return to_route('profile.index');
    }
}
