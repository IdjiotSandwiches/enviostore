<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Shipping;

class CheckoutService
{
    public function getCheckoutCredentials()
    {
        $payments = Payment::all();
        $shippings = Shipping::all();

        return [$payments, $shippings];
    }
}