<?php

namespace App\Providers;

use App\Interfaces\SessionKeyInterface;
use App\Models\Category;
use App\Models\User;
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
            'component.navigation.navbar',
            function ($view) {
                $isAdmin = session(self::SESSION_IS_ADMIN);
                $view = $isAdmin ? $this->adminMenu() : $this->userMenu();
                $user = $this->getUserInformation();

                View::share([
                    'menus' => $view,
                    'userInformation' => $user,
                ]);
            }
        );
    }

    /**
     * Summary of userMenu
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
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

    /**
     * Summary of adminMenu
     * @return \Illuminate\Support\Collection
     */
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

    private function getUserInformation()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);

        return (object) [
            'username' => $user->username,
            'profilePicture' => $user->avatar,
        ];
    }
}
