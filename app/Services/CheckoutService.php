<?php

namespace App\Services;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Interfaces\SessionKeyInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Str;

class CheckoutService implements SessionKeyInterface, FeeInterface
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Summary of getCheckoutCredentials
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getCheckoutCredentials()
    {
        $shippings = Shipping::all()->map(function ($shipping) {
            $shipping->fee = StringHelper::parseNumberFormat($shipping->fee);
            return $shipping;
        });

        return $shippings;
    }

    public function createOrder()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        $cartItems = Cart::with(['product'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $subtotal = $item->quantity * $item->product->price;

                return (object) [
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ];
            });

        $subtotal = $cartItems->sum('subtotal');

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->user_id = $user->id;
            $order->address = '';
            $order->amount = $subtotal;
            $order->transaction_fee = self::TRANSACTION_FEE;
            $order->payment_status = 'pending';
            $order->save();

            $token = session('page_token', Str::random(10));
            session(['page_token' => $token]);
            logger('Refresh', ['token' => session('page_token')]);
            session()->forget('page_token');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e->getMessage());
        }

        return $order;
    }

    public function updateShipping($id, $shipping)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::where('id', $user->id)->first();
        $order = Order::find($id);
        $shipping = Shipping::where('shipping_serial_code', $shipping)->first();
        
        $order->shipping = $shipping->name;
        $order->shipping_fee = $shipping->fee;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER_' . rand(),
                'gross_amount' => $order->subtotal + $shipping->fee + self::TRANSACTION_FEE,
            ],
            'customer_details' => [
                'username' => $user->username,
                'address' => $user->address,
                'email' => $user->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        // $order->save();
    }
}