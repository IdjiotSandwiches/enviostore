<?php

namespace App\Services\Product;

use App\Helpers\StringHelper;
use App\Models\Cart;
use App\Models\Product;
use App\Interfaces\SessionKeyInterface;
use App\Utilities\GoogleDriveUtility;

class CartService implements SessionKeyInterface
{
    private $googleDriveUtility;

    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

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
                ];
            });

        return $items;
    }

    /**
     * Summary of addToCart
     * @param \App\Http\Requests\CartRequest $item
     * @throws \Exception
     * @return void
     */
    public function addToCart($item)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);

        $product = Product::where('product_serial_code', $item['product_serial'])->first();

        if (!$product) {
            throw new \Exception('Invalid operation.');
        }

        $cart = Cart::firstOrNew(['product_id' => $product->id]);
        $cart->user_id = $user->id;
        $cart->product_id = $product->id;
        $cart->quantity = ($cart->exists() ? $cart->quantity : 0) + $item['quantity'];
        
        $currentStock = $product->stocks;
        if (!$this->isAvailable($currentStock, $cart->quantity)) {
            throw new \Exception('Your product amounts exceeded our stocks.');
        }

        $cart->save();
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

    //     if (!$this->isAvailable($currentStock, $quantity)) {
    //         throw new \Exception('Invalid operation.');
    //     }

    //     $updatedStock = $currentStock - $quantity;
    //     $product->stocks = $updatedStock;
    //     $product->save();
    // }

    /**
     * Summary of isAvailable
     * @param int $currentStock
     * @param int $quantity
     * @return bool
     */
    public function isAvailable($currentStock, $quantity)
    {
        if ($currentStock < $quantity) {
            return false;
        }

        return true;
    }
}