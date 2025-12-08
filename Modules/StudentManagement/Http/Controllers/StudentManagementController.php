<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\StudentManagement\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Exception;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $connection = Session::get('tenant_connection');
        return view('StudentManagement::studentindex');
    }

    public function view($id){
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    /**
     * Display a listing of the resource.
     */
    public function bulkAddIndex()
    {
        return view('StudentManagement::studentbulkcreate');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('studentmanagement::studentcreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'nullable|email|max:150|unique:students,email',
                'phone_number' => 'nullable|string|max:20',
                'dob' => 'required|date',
                'admission_date' => 'required|date',
                'guardian_phone' => 'nullable|string|max:20',
                'postal_code' => 'nullable|string|max:10',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $profilePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')->store('students/profile_pictures', 'public');
            }

            $password = $request->input('password') ? $request->password : '123456';
            $hashedPassword = Hash::make($password);

            $student = Student::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'guardian_name' => $request->guardian_name,
                'guardian_phone' => $request->guardian_phone,
                'enrollment_number' => $request->enrollment_number,
                'admission_date' => $request->admission_date,
                'grade' => $request->grade,
                'section' => $request->section,
                'is_deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'profile_picture' => $profilePath,
                'blood_group' => $request->blood_group,
                'medical_conditions' => $request->medical_conditions,
                'nationality' => $request->nationality,
                'religion' => $request->religion,
                'language_preference' => $request->language_preference,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Student created successfully!',
                'data' => $student
            ], 201);

        } catch (Exception $e) {
            Log::error('Student creation failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while creating the student.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Show the specified resource.
     */
    public function getStudents()
    {
        try {
            // 1. Ensure tenant exists
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();

            if (!$tenant) {
                return response()->json(['data' => []]);
            }

            // 2. Use the tenant DB (Spatie already switched the connection)
            $students = DB::connection('tenant')
                ->table('students')
                ->select('id', 'first_name', 'last_name', 'email', 'profile_picture', 'grade', 'section', 'admission_date', 'created_at')
                ->get();

            return response()->json(['data' => $students]);

        } catch (Exception $e) {
            Log::error("Failed to fetch students: " . $e->getMessage());
            return response()->json(['data' => []]);
        }
    }



    public function bulkStore(Request $request)
    {
        $students = [];

        foreach ($request->first_name as $index => $fname) {
            if (!empty($fname)) {
                $students[] = [
                    'first_name' => $fname,
                    'last_name' => $request->last_name[$index] ?? null,
                    'dob' => $request->dob[$index] ?? null,
                    'gender' => $request->gender[$index] ?? null,
                    'email' => $request->email[$index] ?? null,
                    'phone_number' => $request->phone_number[$index] ?? null,
                    'guardian_name' => $request->guardian_name[$index] ?? null,
                    'city' => $request->city[$index] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'admission_date' => now(),
                ];
            }
        }

        if (!empty($students)) {
            Student::insert($students);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'No valid data found.']);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return view('studentmanagement::edit');
        $connection = session('tenant_connection');
        $student = DB::connection($connection)->table('students')->find($id);
        return response()->json(['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $st = Student::findOrFail($id);
        $st->update($request->all());
        return response()->json(["status"=>true,"message"=>"Updated"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
