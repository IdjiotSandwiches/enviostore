<?php

namespace App\Http\Controllers\user;

use App\Services\CheckoutService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
    }
    
    public function index()
    {
        [$payments, $shippings] = $this->checkoutService->getCheckoutCredentials();

        return view('checkout.index', compact('payments', 'shippings'));
    }
}
