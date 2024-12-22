<?php

namespace App\Services;

use App\Helpers\StringHelper;
use App\Models\Payment;
use App\Models\Shipping;

class CheckoutService
{
    public function getCheckoutCredentials()
    {
        $payments = Payment::all();
        $shippings = Shipping::all()->map(function ($shipping) {
            $shipping->fee = StringHelper::parseNumberFormat($shipping->fee);
            return $shipping;
        });

        return [$payments, $shippings];
    }
}