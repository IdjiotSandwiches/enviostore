<?php

namespace App\Http\Controllers\user;

use App\Services\HomeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Summary of index
     * @param \App\Services\HomeService $homeService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(HomeService $homeService)
    {
        $banners = $homeService->getBanner();
        $categories = $homeService->getCategories();
        $products = $homeService->getHomeProduct();

        return view('welcome', compact('banners', 'categories', 'products'));
    }

}
