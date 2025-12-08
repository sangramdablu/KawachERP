<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\StudentManagement\Models\Teachers;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\StudentManagement\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            // 1. Ensure tenant exists
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();

            if (!$tenant) {
                return response()->json(['data' => []]);
            }

            // 2. Fetch teachers using tenant database
            $teachers = DB::connection('tenant')
                ->table('teachers')
                ->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'profile_picture',
                    'joining_date',
                    'status',
                    'created_at'
                )
                ->orderBy('id', 'desc')
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name'        => 'required|string|max:100',
                'last_name'         => 'required|string|max:100',
                'email'             => 'required|email|max:150|unique:teachers,email',
                'phone_number'      => 'nullable|string|max:15',
                'dob'               => 'nullable|date',
                'gender'            => 'nullable|in:male,female,other',
                'address'           => 'nullable|string',
                'city'              => 'nullable|string|max:100',
                'state'             => 'nullable|string|max:100',
                'country'           => 'nullable|string|max:100',
                'postal_code'       => 'nullable|string|max:20',
                'qualification'     => 'nullable|string|max:200',
                'experience_years'  => 'nullable|string|max:10',
                'employee_id'       => 'required|string|max:100|unique:teachers,employee_id',
                'joining_date'      => 'nullable|date',
                'designation'       => 'nullable|string|max:100',
                'profile_picture'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'blood_group'       => 'nullable|string|max:10',
                'specialization'    => 'nullable|string|max:500',
                'nationality'       => 'nullable|string|max:100',
                'religion'          => 'nullable|string|max:100',
                'language_preference' => 'nullable|string|max:100',

                'status'            => 'nullable|in:active,inactive,terminated,retired',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation Failed',
                    'errors'  => $validator->errors()
                ], 422);
            }
            $profilePath = null;

            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')
                    ->store('teachers/profile_pictures', 'public');
            }

            $teacher = Teachers::create([
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'email'             => $request->email,
                'phone_number'      => $request->phone_number,
                'dob'               => $request->dob,
                'gender'            => $request->gender,
                'address'           => $request->address,
                'city'              => $request->city,
                'state'             => $request->state,
                'country'           => $request->country,
                'postal_code'       => $request->postal_code,
                'qualification'     => $request->qualification,
                'experience_years'  => $request->experience_years,
                'employee_id'       => $request->employee_id,
                'joining_date'      => $request->joining_date,
                'designation'       => $request->designation,
                'profile_picture'   => $profilePath,
                'blood_group'       => $request->blood_group,
                'specialization'    => $request->specialization,
                'nationality'       => $request->nationality,
                'religion'          => $request->religion,
                'language_preference' => $request->language_preference,
                'status'            => $request->status ?? 'active',

                'created_by'        => null,
                'updated_by'        => null,
                'deleted_by'        => null,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Teacher created successfully!',
                'data'    => $teacher
            ], 201);

        } catch (Exception $e) {
            Log::error('Teacher creation failed: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while creating the teacher.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


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
