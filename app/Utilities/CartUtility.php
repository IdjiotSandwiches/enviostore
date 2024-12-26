<?php

namespace App\Utilities;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Shipping;

class CartUtility implements SessionKeyInterface, StatusInterface, FeeInterface
{
    private $googleDriveUtility;

    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
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
     * Summary of getCartSummary
     * @param string $shipping
     * @return object
     */
    public function getCartSummary($shipping)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $items = Cart::with(['product'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $subtotal = $item->quantity * $item->product->price;

                return (object) [
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ];
            });

        $shippingFee = optional(Shipping::where('shipping_serial_code', $shipping)->first())->fee ?? 0;
        $adminFee = self::TRANSACTION_FEE;
        $subtotal = $items->sum('subtotal');
        $total = $shippingFee + $adminFee + $subtotal;

        $summary = (object) [
            'subtotal' => StringHelper::parseNumberFormat($subtotal),
            'quantity' => $items->sum('quantity'),
            'shippingFee' => StringHelper::parseNumberFormat($shippingFee),
            'adminFee' => StringHelper::parseNumberFormat($adminFee),
            'total' => StringHelper::parseNumberFormat($total),
        ];

        return $summary;
    }
}