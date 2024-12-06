<?php

namespace App\Utilities;

use App\Helpers\StringHelper;
use App\Models\Cart;
use App\Interfaces\SessionKeyInterface;
use App\Utilities\GoogleDriveUtility;

class CartUtility implements SessionKeyInterface
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
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => StringHelper::parseNumberFormat($price),
                    'category_name' => $item->product->category->name,
                    'img' => $img,
                    'link' => route('getProduct', base64_encode($item->product->product_serial_code)),
                    'delete' => route('cart.deleteItem', $item->id),
                ];
            });

        return $items;
    }
}