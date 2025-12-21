<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\StudentManagement\Models\Teachers;
use Exception;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('StudentManagement::teacher.teacherindex');
    }

   public function getTeachers()
    {
        try {
            $connection = session('tenant_connection');

            if (!$connection) {
                return response()->json(['data' => []]);
            }

            if (!array_key_exists($connection, config('database.connections'))) {
                $tenantId = session('tenant_id');

                if (!$tenantId) {
                    return response()->json(['data' => []]);
                }

                $tenant = DB::connection('kawacherp')
                    ->table('tenants')
                    ->where('id', $tenantId)
                    ->first();

                if (!$tenant) {
                    Log::warning("Tenant record not found for ID: {$tenantId}");
                    return response()->json(['data' => []]);
                }

                config(["database.connections.$connection" => [
                    'driver' => 'mysql',
                    'host' => $tenant->db_host,
                    'port' => $tenant->db_port,
                    'database' => $tenant->db_database,
                    'username' => $tenant->db_username,
                    'password' => $tenant->db_password,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                ]]);

                DB::purge($connection);
                DB::reconnect($connection);
            }

            $teachers = (new Teachers)
                ->setConnection($connection)
                ->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone_number',
                    'qualification',
                    'designation',
                    'experience_years',
                    'joining_date',
                    'status',
                    'created_at'
                )
                ->where('is_deleted', 0)
                ->get();

            return response()->json(['data' => $teachers]);

        } catch (Exception $e) {
            Log::error("Failed to fetch teachers: " . $e->getMessage());
            return response()->json(['data' => []]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('StudentManagement::teacher.teachercreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('studentmanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('studentmanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
