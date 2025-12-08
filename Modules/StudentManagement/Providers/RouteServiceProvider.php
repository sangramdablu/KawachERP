<?php

namespace Modules\StudentManagement\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'StudentManagement';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';

        $tenantModules = DB::connection($central)
            ->table('school_modules')
            ->join('modules', 'modules.id', '=', 'school_modules.module_id')
            ->where('school_id', Session::get('tenant_id'))
            ->pluck('modules.name');


        foreach ($tenantModules as $module) {
            $moduleRoute = base_path("Modules/{$module}/Routes/web.php");
            if (file_exists($moduleRoute)) {
                $this->loadRoutesFrom($moduleRoute);
            }
        }
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
