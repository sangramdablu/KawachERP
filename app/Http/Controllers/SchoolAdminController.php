<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class SchoolAdminController extends Controller
{
    public function installModule($moduleSlug)
    {
        $schoolId = Session::get('tenant_id');
        $tenantConnection = Session::get('tenant_connection');

        $module = Module::where('slug', $moduleSlug)->firstOrFail();

        Artisan::call('migrate', [
            '--path' => "Modules/{$module->name}/Database/Migrations",
            '--database' => $tenantConnection,
        ]);

        DB::connection('central')->table('school_modules')->insert([
            'school_id' => $schoolId,
            'module_id' => $module->id,
        ]);

        return back()->with('success', "{$module->name} Module Installed Successfully!");
    }

}
