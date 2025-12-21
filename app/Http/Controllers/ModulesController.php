<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ModulesController extends Controller
{
    public function index()
    {
        try {
            $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';
            // Get all available modules
            $modules = DB::connection($central)->table('modules')->get();
            // Get installed modules for this tenant
            $installed = DB::connection($central)
                ->table('school_modules')
                ->where('school_id', Session::get('tenant_id'))
                ->pluck('module_id')
                ->toArray();

            return view('pages.moduleinstall', compact('modules', 'installed'));
        }catch (Exception $e) {
            Log::error("Module install failed: " . $e->getMessage());
            return back()->with('error', 'Module installation failed.');
        }
    }

    public function install(Request $request, $moduleId)
    {
        try {

            // 1️ Get central DB connection (landlord)
            $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';

            // 2️ Get tenant using Spatie (NOT session)
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();

            if (!$tenant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tenant not resolved for this domain.'
                ], 404);
            }

            // 3️ Fetch module details
            $module = DB::connection($central)->table('modules')->find($moduleId);
            if (!$module) {
                return response()->json(['success' => false, 'message' => 'Module not found.'], 404);
            }

            // Tenant ID
            $tenantId = $tenant->id;
            $tenantName = $tenant->school_name;

            // 4️ Build tenant connection name
            $tenantConnection = "tenant_" . $tenant->id;

            // 5️ Build tenant DB config
            config([
                "database.connections.$tenantConnection" => [
                    'driver' => 'mysql',
                    'host' => $tenant->host,
                    'port' => $tenant->port,
                    'database' => $tenant->database,
                    'username' => $tenant->username,
                    'password' => $tenant->db_password,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                ]
            ]);

            DB::purge($tenantConnection);
            DB::reconnect($tenantConnection);

            // 6️ Ensure tenant DB reachable
            DB::connection($tenantConnection)->getPdo();

            // 7️ Resolve module migration path
            $migrationPath = module_path($module->name, 'Database/Migrations');

            if (!File::exists($migrationPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Module migration folder not found.'
                ], 500);
            }

            // 8️ Run migrations into tenant DB
            Artisan::call('migrate', [
                '--database' => $tenantConnection,
                '--realpath' => true,
                '--path'     => $migrationPath,
                '--force'    => true,
            ]);

            $output = Artisan::output();

            // 9️ Record module install
            DB::connection($central)->table('school_modules')->insert([
                'school_id'   => $tenantId,
                'module_id'   => $module->id,
                'installed_at'=> now(),
                'status'      => 'active',
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$module->name} installed successfully",
                'artisan_output' => $output,
            ]);

        } catch (Exception $e) {
            Log::error("Module installation failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function uninstall($moduleId)
    {
        $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';

        DB::connection($central)
            ->table('school_modules')
            ->where('school_id', Session::get('tenant_id'))
            ->where('module_id', $moduleId)
            ->delete();

        return back()->with('success', 'Module uninstalled successfully.');
    }
}
