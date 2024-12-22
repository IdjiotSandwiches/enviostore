<?php

namespace App\Http\Controllers\user;

use App\Interfaces\SessionKeyInterface;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller implements SessionKeyInterface
{
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
    }
    
    public function index()
    {
        [$payments, $shippings] = $this->checkoutService->getCheckoutCredentials();
        session([self::SESSION_CHECKOUT => true]);

        return view('checkout.index', compact('payments', 'shippings'));
    }

    public function pay()
    {
        if (!session(self::SESSION_CHECKOUT)) abort(404);
        session()->forget(self::SESSION_CHECKOUT);

        
    }
}
