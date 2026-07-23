<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class HealthController extends Controller
{
    public function index()
    {
        $disk = Config::get('filesystems.default');
        $cellar = Config::get('filesystems.disks.cellar');

        return response()->json([
            'laravel' => app()->version(),
            'php' => phpversion(),
            'app_env' => Config::get('app.env'),
            'app_debug' => Config::get('app.debug'),
            'app_key_loaded' => ! empty(Config::get('app.key')),
            'default_disk' => $disk,
            'cellar_configured' => ! empty($cellar['key']) && ! empty($cellar['secret']) && ! empty($cellar['region']) && ! empty($cellar['bucket']) && ! empty($cellar['endpoint']),
            'cellar_region' => $cellar['region'] ?? null,
            'cellar_bucket' => $cellar['bucket'] ?? null,
            'cellar_host' => $cellar['endpoint'] ?? null,
            'db_connection' => Config::get('database.default'),
            'db_host' => Config::get('database.connections.mysql.host'),
            'db_database' => Config::get('database.connections.mysql.database'),
            'routes_loaded' => count(Route::getRoutes()),
            'storage_writable' => is_writable(storage_path('app')),
        ]);
    }
}
