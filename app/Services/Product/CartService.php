<?php

namespace App\Services\Product;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Models\Cart;
use App\Models\Product;
use App\Interfaces\SessionKeyInterface;
use App\Utilities\GoogleDriveUtility;
use App\Utilities\ProductsUtility;

class CartService implements SessionKeyInterface, FeeInterface
{
    private $googleDriveUtility;
    private $productsUtility;

    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productsUtility = new ProductsUtility();
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
                $isAvailable = $this->productsUtility->isAvailable($item->product->stocks, $item->quantity);
                $img = $item->product->productImage->first();
                $img = $this->googleDriveUtility->getFile($img->url);
                $price = $item->quantity * $item->product->price;

                return (object) [
                    'isAvailable' => $isAvailable,
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
     * @return object
     */
    public function getCartSummary()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);

        $items = Cart::with(['product'])
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $isAvailable = $this->productsUtility->isAvailable($item->product->stocks, $item->quantity);
                $subtotal = $item->quantity * $item->product->price;

                return (object) [
                    'quantity' => $isAvailable ? $item->quantity : 0,
                    'subtotal' => $isAvailable ? $subtotal : 0,
                ];
            });

        $adminFee = self::TRANSACTION_FEE;
        $subtotal = $items->sum('subtotal');
        $total = $adminFee + $subtotal;

        $summary = (object) [
            'subtotal' => StringHelper::parseNumberFormat($subtotal),
            'quantity' => $items->sum('quantity'),
            'adminFee' => StringHelper::parseNumberFormat($adminFee),
            'total' => StringHelper::parseNumberFormat($total),
        ];

        return $summary;
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

        if (!$product) throw new \Exception(__('message.invalid'));

        $cart = Cart::firstOrNew([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
        $cart->product_id = $product->id;
        $cart->quantity = ($cart->exists() ? $cart->quantity : 0) + $item['quantity'];
        
        $currentStock = $product->stocks;
        $isAvailable = $this->productsUtility->isAvailable($currentStock, $cart->quantity);
        if (!$isAvailable) throw new \Exception(__('exceeded_stock'));

        $cart->save();
    }

    /**
     * Summary of delete
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return void
     */
    public function delete($id)
    {
        $cart = Cart::find($id);

        if (!$cart) throw new \Exception(__('message.invalid'));

        $cart->delete();
    }
}