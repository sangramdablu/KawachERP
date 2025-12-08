<?php

namespace Modules\StudentManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\StudentManagement\Models\Classes;
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
    public function store(Request $request) {}

    public function getClasses()
    {
        try{
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();
            if(!$tenant) return response()->json(['data'=>[]]);

            $classes = Classes::with(['teacher','subjects','students'])
                ->orderBy('id','DESC')
                ->get()
                ->map(function($item){
                    return [
                        'id' => $item->id,
                        'class_name' => $item->class_name,
                        'teacher' => $item->teacher ? $item->teacher->first_name.' '.$item->teacher->last_name : 'Not Assigned',
                        'students' => $item->students->count(),
                        'subjects' => $item->subjects->count(),

                        'status' => $item->status,
                        'created_at' => $item->created_at->format('Y-m-d')
                    ];
                });

            return response()->json(['data'=>$classes]);

        }catch(Exception $e){
            Log::error("Class fetch failed: ".$e->getMessage());
            return response()->json(['data'=>[]]);
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
