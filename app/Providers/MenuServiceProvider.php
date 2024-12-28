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
        $this->app->bind('GoogleDriveUtility', function ($app) {
            return new \App\Utilities\GoogleDriveUtility;
        });
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
                $user = session(self::SESSION_IS_LOGGED_IN) ? $this->getUserInformation() : '';

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
                'route' => route('categoryPage', base64_encode($category->category_serial_code)),
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

    /**
     * Summary of getUserInformation
     * @return object
     */
    private function getUserInformation()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = session(self::SESSION_IDENTITY);
        $user = User::find($user->id);
        $googleDriveUtility = $this->app->make('GoogleDriveUtility');

        return (object) [
            'username' => $user->username,
            'profilePicture' => $googleDriveUtility->getFile($user->profile_picture),
        ];
    }
}
