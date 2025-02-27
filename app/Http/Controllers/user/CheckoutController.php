<?php

namespace App\Http\Controllers\user;

use App\Http\Requests\PaymentRequest;
use App\Http\Requests\ShippingRequest;
use App\Interfaces\PaymentStatusInterface;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Utilities\ErrorUtility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller implements SessionKeyInterface, StatusInterface, PaymentStatusInterface
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
        if (!$this->checkoutService->hasCart()) return back();

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

        return to_route('checkout.payment', base64_encode($order->unique_id));
    }

    /**
     * Summary of paymentPage
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function paymentPage($id)
    {
        try {
            $id = base64_decode($id);
        } catch (\Exception $e) {
            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        $order = Order::where('unique_id', $id)
            ->first(['unique_id', 'snap_token']);
        $order = (object) [
            'unique_id' => base64_encode($order->unique_id),
            'snap_token' => $order->snap_token,
        ];
        
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
            
            $id = base64_decode($validated['order_id']);
            $this->checkoutService->update($id, $validated['result_data']);
            
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
