<?php

namespace App\Utilities;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Interfaces\SessionKeyInterface;
use App\Interfaces\StatusInterface;
use App\Models\Cart;
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getCartItems()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);

        $items = Cart::with(['product', 'product.category', 'product.productImage'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $img = $item->product->productImage->first();
                $img = $this->googleDriveUtility->getFile($img->url);
                $price = $item->quantity * $item->product->price;

                return (object) [
                    'productName' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => StringHelper::parseNumberFormat($price),
                    'categoryName' => ucwords($item->product->category->name),
                    'img' => $img,
                    'link' => route('getProduct', base64_encode($item->product->product_serial_code)),
                    'delete' => route('cart.deleteItem', $item->id),
                ];
            });

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