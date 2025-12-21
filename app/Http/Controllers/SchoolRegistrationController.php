<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Admins;
use Modules\StudentManagement\Models\Student;
use App\Services\TenantProvisioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;


class SchoolRegistrationController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_name'      => 'required|string|max:255',
            'email'            => 'required|email|unique:tenants,email',
            'phone'            => 'required|string|max:15',
            'admin_username'   => 'required|string|max:255',
            'admin_password'   => 'required|string|min:6',
        ]);

        try {
            // Generate slug
            $baseSlug = Str::slug($data['school_name']);
            $slug = $baseSlug;
            $counter = 1;

            while (Tenant::where('slugs', $slug)->exists()) {
                $slug = "{$baseSlug}{$counter}";
                $counter++;
            }

            $dbName = 'tenant_' . $slug;

            // Create tenant entry in landlord DB
            $tenant = Tenant::create([
                'school_name'    => $data['school_name'],
                'code'           => strtoupper(Str::random(8)),
                'affiliation_no' => $data['affiliation_no'] ?? null,
                'school_type'    => $data['school_type'] ?? null,
                'address'        => $data['address'] ?? null,
                'pincode'        => $data['pincode'] ?? null,
                'principal_name' => $data['principal_name'] ?? null,
                'email'          => $data['email'],
                'phone'          => $data['phone'],
                'database'       => $dbName,
                'username'       => env('DB_USERNAME', 'root'),
                'password'       => env('DB_PASSWORD', ''),
                'host'           => env('DB_HOST', '127.0.0.1'),
                'port'           => env('DB_PORT', '3306'),
                'slugs'          => $slug,
                'domain'         => "{$slug}.kawach.test"
            ]);

            // Create tenant DB + migrate + seed roles + switch DB
            TenantProvisioner::createTenantDatabase($tenant);

            // Create school admin inside tenant DB
            $admin = Admins::on('tenant')->create([
                'name'     => $data['admin_username'],
                'email'    => $data['email'],
                'password' => bcrypt($data['admin_password']),
            ]);

            // Assign Admin role inside tenant DB
            $admin->assignRole('Admin');

            // Redirect to tenant login page
            $loginUrl = "http://{$slug}.kawach.test/";

            return redirect($loginUrl)
                ->with('register-success', "School registered successfully! Database created: {$dbName}");

        } catch (Exception $e) {
            Log::error("School registration failed: " . $e->getMessage());
            return back()->with('error', 'Registration failed. Please try again later.');
        }
    }

    public function loginSchool(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // Get tenant
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();

            if (!$tenant) {
                Log::error("Login failed: No tenant detected.");
                return back()->withErrors(['email' => 'Invalid tenant domain']);
            }

            Log::info("Tenant identified: {$tenant->school_name} (ID: {$tenant->id})");

            $admin = Admins::on('tenant')->where('email', $request->email)->first();

            if ($admin) {
                Log::info("Admin found: {$admin->email}. Checking password...");

                if (Hash::check($request->password, $admin->password)) {

                    Log::info("Admin password correct. Logging in admin: {$admin->email}");

                    Session::put('tenant_id', $tenant->id);
                    Session::put('tenant_name', $tenant->school_name);

                    Auth::guard('school')->login($admin);
                    return redirect()->route('school.dashboard');
                } else {
                    Log::warning("Admin password incorrect for email: {$admin->email}");
                }
            }

            Log::info("Checking student login for email: {$request->email}");

            $student = Student::on('tenant')->where('email', $request->email)->first();

            if ($student) {
                Log::info("Student found: {$student->email}. Checking password...");

                if (Hash::check($request->password, $student->password)) {

                    Log::info("Student password correct. Logging in student: {$student->email}");

                    Session::put('tenant_id', $tenant->id);
                    Session::put('tenant_name', $tenant->school_name);

                    Auth::guard('student')->login($student);
                    return redirect()->route('tenant.student.student-index');
                } else {
                    Log::warning("Student password incorrect for email: {$student->email}");
                }
            } else {
                Log::warning("Student not found for email: {$request->email}");
            }

            return back()->withErrors(['email' => 'Invalid credentials']);

        } catch (Exception $e) {

            Log::error("Login error occurred: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['email' => 'Something went wrong.']);
        }
    }

    public function dashboard()
    {
        $tenantConnection = Session::get('tenant_connection');
        $students = DB::connection($tenantConnection)->table('students')->get();
        return view('pages.index', compact('students'));
    }

    public function logout(Request $request)
    {
        if(Auth::guard('school')->logout()){
            Session::flush();
            return redirect()->route('pages.loginschool');
        }elseif(Auth::guard('student')->logout()){
            Session::flush();
            return redirect()->route('pages.loginschool');
        }
    }


}
