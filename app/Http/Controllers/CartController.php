<?php

namespace App\Http\Controllers;

use App\Interfaces\SessionKeyInterface;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller implements SessionKeyInterface
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->getItems();
        return view('cart');
    }

    public function getItems()
    {
        /**
         * @var \stdClass $user
         */
        $user = session(self::SESSION_IDENTITY);
        $items = Cart::with(['product'])->where('user_id', $user->id)->get();
        dd($items);
    }
}
