<?php

namespace App\Services;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\User;
use App\Utilities\ProductsUtility;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutService implements SessionKeyInterface, FeeInterface, StatusInterface
{
    private $productsUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $this->productsUtility = new ProductsUtility();
    }

    /**
     * Summary of getUserAddress
     * @return string
     */
    public function getUserAddress()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $address = User::find($user->id)->address;

        return $address;
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
     * @param string $shipping
     * @return Order|\Illuminate\Database\Eloquent\Model
     */
    public function createOrderFromCart($shipping)
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
                $isAvailable = $this->productsUtility->isAvailable($item->product->stocks, $item->quantity);
                $subtotal = $item->quantity * $item->product->price;

                if (!$isAvailable) throw new \Exception(__('message.remove_unavailable'));

                return (object) [
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ];
            });

        $subtotal = $cartItems->sum('subtotal');

        $shipping = Shipping::where('shipping_serial_code', $shipping)->first();

        $order = Order::create([
            'user_id' => $user->id,
            'address' => $user->address,
            'amount' => $subtotal,
            'transaction_fee' => self::TRANSACTION_FEE,
            'payment_status' => 'pending',
            'shipping' => $shipping->name,
            'shipping_fee' => $shipping->fee,
        ]);

        $items = $this->getCartItems();
        $items = $this->addFee($shipping, $items);

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

        return $order;
    }

    /**
     * Summary of getCartItems
     * @return array
     */
    public function getCartItems()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $items = Cart::with(['product', 'product.category'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->product->product_serial_code,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'category' => ucwords($item->product->category->name),
                    'url' => route('getProduct', base64_encode($item->product->product_serial_code)),
                ];
            })->toArray();

        return $items;
    }

    /**
     * Summary of addFee
     * @param \App\Models\Shipping $shipping
     * @param array $items
     * @return array
     */
    public function addFee($shipping, $items)
    {
        $shippingDetails = [
            'id' => $shipping->shipping_serial_code,
            'name' => $shipping->name,
            'quantity' => 1,
            'price' => $shipping->fee,
            'category' => 'SHIPPING',
            'url' => '',
        ];

        $transactionFee = [
            'id' => 'TRANSACTION_001',
            'name' => 'Transaction Fee',
            'quantity' => 1,
            'price' => self::TRANSACTION_FEE,
            'category' => 'TRANSACTION',
            'url' => '',
        ];

        array_push($items, $shippingDetails, $transactionFee);
        return $items;
    }

    /**
     * Summary of isAcceptable
     * @return void
     */
    public function isAcceptable()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        Cart::with(['product'])
            ->where('user_id', $user->id)
            ->get()
            ->each(function ($item) {
                $isAvailable = $this->productsUtility->isAvailable($item->product->stocks, $item->quantity);
                if (!$isAvailable) throw new \Exception(__('message.remove_unavailable'));
            });
    }

    /**
     * Summary of hasAddress
     * @return string
     */
    public function hasAddress()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        return $user->address;
    }

    /**
     * Summary of updateStocks
     * @param \App\Models\Product $product
     * @param int $quantity
     * @throws \Exception
     * @return void
     */
    // Dipake pas bayar
    // public function updateStocks($product, $quantity)
    // {
    //     $currentStock = $product->stocks;

        // if (!$this->isAvailable($currentStock, $quantity)) {
        //     throw new \Exception(__('message.invalid'));
        // }

    //     $updatedStock = $currentStock - $quantity;
    //     $product->stocks = $updatedStock;
    //     $product->save();
    // }
}