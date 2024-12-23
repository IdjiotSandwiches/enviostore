<?php

namespace App\Services\Product;

use App\Helpers\StringHelper;
use App\Interfaces\FeeInterface;
use App\Models\Cart;
use App\Models\Product;
use App\Interfaces\SessionKeyInterface;
use App\Models\Shipping;
use App\Utilities\GoogleDriveUtility;

class CartService implements SessionKeyInterface, FeeInterface
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
                    'categoryName' => $item->product->category->name,
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
            throw new \Exception(__('message.invalid'));
        }

        $cart = Cart::firstOrNew([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
        $cart->product_id = $product->id;
        $cart->quantity = ($cart->exists() ? $cart->quantity : 0) + $item['quantity'];
        
        $currentStock = $product->stocks;
        if (!$this->isAvailable($currentStock, $cart->quantity)) {
            throw new \Exception(__('exceeded_stock'));
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

        // if (!$this->isAvailable($currentStock, $quantity)) {
        //     throw new \Exception(__('message.invalid'));
        // }

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

    /**
     * Summary of delete
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return void
     */
    public function delete($request)
    {
        $id = $request->id;
        $cart = Cart::find($id);

        if (!$cart) {
            throw new \Exception(__('message.invalid'));
        }

        $cart->delete();
    }
}