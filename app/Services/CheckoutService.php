<?php

namespace App\Services;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Cart;
use App\Models\ErrorLog;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Utilities\CartUtility;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutService implements SessionKeyInterface, FeeInterface, StatusInterface
{
    private $cartUtility;

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $this->cartUtility = new CartUtility();
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

    /**
     * Summary of createOrderFromCart
     * @return Order|\Illuminate\Database\Eloquent\Model
     */
    public function createOrderFromCart()
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

        $order = Order::create([
            'user_id' => $user->id,
            'address' => $user->address,
            'amount' => $subtotal,
            'transaction_fee' => self::TRANSACTION_FEE,
            'payment_status' => 'pending',
        ]);

        return $order;
    }

    /**
     * Summary of updateShipping
     * @param int $id
     * @param string $shipping
     * @return void
     */
    public function updateShipping($id, $shipping)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        $order = Order::find($id);
        $shipping = Shipping::where('shipping_serial_code', $shipping)->first();

        $order->shipping = $shipping->name;
        $order->shipping_fee = $shipping->fee;

        $items = $this->cartUtility->getCartItems();
        $items = $this->cartUtility->addFee($shipping, $items);

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER_' . rand(),
                'gross_amount' => $order->amount + $shipping->fee + self::TRANSACTION_FEE,
            ],
            'customer_details' => [
                'first_name' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'billing_adress' => [
                    'first_name' => $user->username,
                    'phone' => $user->phone_number,
                    'address' => $user->address,
                ],
                'shipping_address' => [
                    'first_name' => $user->username,
                    'phone' => $user->phone_number,
                    'address' => $user->address,
                ],
            ],
            'item_details' => $items,
        ];

        $snapToken = Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        $order->save();
    }
}