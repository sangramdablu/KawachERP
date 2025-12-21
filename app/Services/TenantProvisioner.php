<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class TenantProvisioner
{
    public static function createTenantDatabase($tenant)
    {
        try {
            $dbName = $tenant->database;

            // 1. Create database if missing
            $exists = DB::select("SHOW DATABASES LIKE '{$dbName}'");
            if (!$exists) {
                DB::statement("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                Log::info("Database {$dbName} created.");
            }

            // 2. Build dynamic connection
            config([
                "database.connections.tenant.host" => $tenant->host,
                "database.connections.tenant.port" => $tenant->port,
                "database.connections.tenant.database" => $tenant->database,
                "database.connections.tenant.username" => $tenant->username,
                "database.connections.tenant.password" => $tenant->db_password,
            ]);

            DB::purge('tenant');
            DB::reconnect('tenant');

            // 3. Migrations
            if (!Schema::connection('tenant')->hasTable('migrations')) {
                Artisan::call('migrate', [
                    '--database' => 'tenant',
                    '--path' => base_path('database/migrations/tenants'),
                    '--realpath' => true,
                    '--force' => true,
                ]);
            }

            // 4. Seed roles only once
            if (Schema::connection('tenant')->hasTable('roles') &&
                DB::connection('tenant')->table('roles')->count() == 0) {
                Artisan::call('db:seed', [
                    '--class' => 'Database\\Seeders\\RolesAndPermissionsSeeder',
                    '--database' => 'tenant',
                    '--force' => true,
                ]);
            }

            Log::info("Tenant DB ready for {$tenant->school_name}");

            // 5. Make tenant current (important!)
            $tenant->makeCurrent();

        } catch (\Exception $e) {
            Log::error("Tenant provisioning failed: " . $e->getMessage());
            throw $e;
        }
    }
}


