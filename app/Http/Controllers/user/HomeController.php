<?php

namespace App\Http\Controllers\user;

use App\Interfaces\StatusInterface;
use App\Services\HomeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller implements StatusInterface
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home.index');
    }

    public function getHomeItems(HomeService $homeService)
    {
        if (!request()->ajax()) abort(404);

        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Data retrieved.',
            'data' => [
                'carouselImg' => $homeService->getImgs('home_carousel_images'),
                'banner' => $homeService->getImgs('banner_images')[0],
                'categories' => $homeService->getCategories(),
                'products' => $homeService->getHomeProduct(),
            ],
        ], Response::HTTP_OK);
    }
}
