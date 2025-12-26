<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\StudentManagement\Models\Classes;
use Exception;

class SubjectManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('studentmanagement::classes.subject');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('studentmanagement::create');
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


    public function getClassSubjects($id)
    {
        try {
            $class = Classes::with(['teacher', 'subjects'])->find($id);

            if (!$class) {
                return response()->json([
                    'status' => 'error',
                    'subjects' => [],
                    'message' => 'Class not found.'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'subjects' => $class->subjects
            ]);

        } catch (Exception $e) {
            Log::error("Subject fetch failed: ".$e->getMessage());

            return response()->json([
                'status' => 'error',
                'subjects' => [],
                'message' => 'Server error'
            ]);
        }
    }

}
