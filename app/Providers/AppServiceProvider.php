<?php

namespace App\Providers;

use App\Models\ErrorLog;
use League\Flysystem\Filesystem;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Masbug\Flysystem\GoogleDriveAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Google\Service\Drive as GoogleDriveService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::environment(['staging', 'production'])) {
            URL::forceScheme('https');
        }

        try {
            Storage::extend('google', function ($app, $config) {
                $client = new GoogleClient();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new GoogleDriveService($client);
                $adapter = new GoogleDriveAdapter($service, $config['folderId']);
                $filesystem = new Filesystem($adapter);

                return new FilesystemAdapter($filesystem, $adapter);
            });
        } catch (\Exception $e) {
            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();
        }
    }
}
