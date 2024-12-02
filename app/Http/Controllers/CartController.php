<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $this->getItems();
        return view('cart');
    }
    
    public function getItems()
    {
        $items = Cart::with(['product', 'user'])->get();
        dd($items);
    }
}
