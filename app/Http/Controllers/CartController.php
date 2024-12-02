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
        // $id = auth()->user()->id;
        // dd($id);
        // $items = Cart::with(['product'])->where('user_id', $id)->get();
        // dd($items);
        dd(session('key'));
    }
}
