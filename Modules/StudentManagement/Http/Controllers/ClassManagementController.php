<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\StudentManagement\Models\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;


class ClassManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('studentmanagement::classes.classindex');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('studentmanagement::classes.addclass');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
         try {
            $validator = Validator::make($request->all(), [
                'class_name'       => 'required|string|max:100',
                'class_code'       => 'nullable|string|max:50|unique:classes,class_code',
                'class_teacher_id' => 'nullable|exists:teachers,id',
                'section'          => 'nullable|string|max:50',
                'description'      => 'nullable|string',
                'status'           => 'required|in:active,inactive',
            ], [
                'class_name.required' => 'Class name is required.',
                'class_code.unique'   => 'This class code already exists.',
                'class_teacher_id.exists' => 'Selected teacher is invalid.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'validation_error',
                    'errors'  => $validator->errors(),
                    'message' => 'Please fix the errors and try again.'
                ], 422);
            }

            $class = Classes::create([
                'class_name'       => $request->class_name,
                'class_code'       => $request->class_code,
                'class_teacher_id' => $request->class_teacher_id,
                'section'          => $request->section,
                'description'      => $request->description,
                'total_students'   => 0,
                'total_subjects'   => 0,
                'status'           => $request->status,
                'created_by'       => Auth::guard('school')->id() ?? null,
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Class created successfully!',
                'data'    => $class
            ], 200);

        } catch (Exception $e) {
            Log::error("Class Create Error: " . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while creating the class. Please try again later.'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function getClasses()
    {
        try {
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();

            if (!$tenant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tenant not detected',
                    'data' => []
                ]);
            }

            // Check actual DB in use
            $currentDb = DB::connection()->getDatabaseName();
            Log::info("Tenant DB Active: " . $currentDb);

            $classes = Classes::with(['teacher', 'students', 'subjects'])
                ->orderBy('id', 'DESC')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $classes
            ]);

        } catch (Exception $e) {
            Log::error("Class fetch failed: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }
    }



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
