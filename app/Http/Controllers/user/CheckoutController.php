<?php

namespace App\Http\Controllers\user;

use App\Interfaces\SessionKeyInterface;
use App\Models\Order;
use App\Models\Shipping;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller implements SessionKeyInterface
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
    public function index()
    {
        logger('Refresh');
        $shippings = $this->checkoutService->getCheckoutCredentials();
        $order = $this->checkoutService->createOrder();

        session([self::SESSION_CHECKOUT => true]);

        return view('checkout.index', compact('shippings', 'order'));
    }

    public function updateShipping($id, $shipping)
    {
        if (!request()->ajax()) abort(404);

        $this->checkoutService->updateShipping($id, $shipping);
    }

    public function pay()
    {
        if (!session(self::SESSION_CHECKOUT)) abort(404);
        session()->forget(self::SESSION_CHECKOUT);

        
    }
}
