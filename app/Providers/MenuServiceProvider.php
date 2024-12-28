<?php

namespace App\Providers;

use App\Interfaces\SessionKeyInterface;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider implements SessionKeyInterface
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer(
            'component.navigation.__sub-menu',
            function ($view) {
                $isAdmin = session(self::SESSION_IS_ADMIN);
                $view = $isAdmin ? $this->adminMenu() : $this->userMenu();
                View::share('menus', $view);
            }
        );
    }

    private function userMenu() 
    {
        $categories = Category::all()->map(function ($category) {
            return (object) [
                'name' => ucwords($category->name),
                'route' => route('categoryPage', base64_decode($category->category_serial_code)),
            ];
        });

        return $categories;
    }

    private function adminMenu() 
    {
        $menus = collect([
            (object) [
                'name' => ucwords('Products'),
                'route' => route('admin.products'),
            ],
            (object) [
                'name' => ucwords('Categories'),
                'route' => route('admin.categories'),
            ]
        ]);

        return $menus;
    }
}
