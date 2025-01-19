<?php

namespace App\Http\Middleware;

use Closure;
use App\Interfaces\SessionKeyInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfCheckout implements SessionKeyInterface
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Route::is('checkout.payment') || Route::is('checkout.update')) {
            return $next($request);
        }

        if (Route::is('checkout.*') && !session(self::SESSION_CHECKOUT_PERMISSION)) {
            abort(404);
        } elseif (!Route::is('checkout.*') && !Route::is('cart.*')) {
            session()->forget(self::SESSION_CHECKOUT_PERMISSION);
        }
        
        return $next($request);
    }
}
