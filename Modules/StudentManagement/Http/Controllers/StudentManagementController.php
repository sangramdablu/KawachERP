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
use Modules\StudentManagement\Models\Classes;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Exception;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classes::select( 'id', 'class_name', 'section', 'total_students' )
        ->where('status', 1)
        ->orderBy('class_name')
        ->orderBy('section')
        ->get();
        return view('StudentManagement::studentindex', compact('classes'));
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
        $classes = Classes::select( 'id', 'class_name', 'section', 'total_students' )
        ->where('status', 1)
        ->orderBy('class_name')
        ->orderBy('section')
        ->get();
        return view('StudentManagement::studentbulkcreate', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all();
        return view('studentmanagement::studentcreate', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'nullable|email|max:150|unique:students,email',
                'dob' => 'required|date',
                'admission_date' => 'required|date',
                'class_id' => 'required|exists:classes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $profilePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')
                ->store('students/profile_pictures', 'public');
            }

            $student = Student::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? '123456'),
                'dob' => $request->dob,
                'admission_date' => $request->admission_date,
                'profile_picture' => $profilePath,
                'grade' => $request->grade,
                'section' => $request->section,
                'is_deleted' => 0,
            ]);

            DB::table('class_student')->insert([
                'class_id' => $request->class_id,
                'student_id'=> $student->id,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message'=> 'Student created successfully',
                'data'   => $student
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Student creation failed: '.$e->getMessage());
            return response()->json([
                'status' => false,
                'message'=> 'Student creation failed',
            ], 500);
        }
    }


    /**
     * Show the specified resource.
     */
    // public function getStudents()
    // {
    //     try {
    //         // 1. Ensure tenant exists
    //         $tenant = \Spatie\Multitenancy\Models\Tenant::current();

    //         if (!$tenant) {
    //             return response()->json(['data' => []]);
    //         }

    //         // 2. Use the tenant DB (Spatie already switched the connection)
    //         $students = DB::connection('tenant')
    //             ->table('students')
    //             ->select('id', 'first_name', 'last_name', 'email', 'profile_picture', 'grade', 'section', 'admission_date', 'created_at')
    //             ->get();

    //         return response()->json(['data' => $students]);

    //     } catch (Exception $e) {
    //         Log::error("Failed to fetch students: " . $e->getMessage());
    //         return response()->json(['data' => []]);
    //     }
    // }

    public function getStudents(Request $request)
    {
        try {
            $tenant = \Spatie\Multitenancy\Models\Tenant::current();
            if (!$tenant) {
                return response()->json(['data' => []]);
            }

            $query = DB::connection('tenant')
                ->table('students')
                ->join('class_student', 'students.id', '=', 'class_student.student_id')
                ->join('classes', 'classes.id', '=', 'class_student.class_id')
                ->select(
                    'students.id',
                    'students.first_name',
                    'students.last_name',
                    'students.email',
                    'students.profile_picture',
                    'classes.class_name as grade',
                    'students.section',
                    'students.admission_date',
                    'students.created_at'
                );

            if ($request->filled('class_id')) {
                $query->where('class_student.class_id', $request->class_id);
            }

            $students = $query
                ->orderByDesc('students.id')
                ->get();

            return response()->json([
                'data' => $students
            ]);

        } catch (Exception $e) {
            Log::error("Failed to fetch students: " . $e->getMessage());
            return response()->json(['data' => []]);
        }
    }



    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'dob (YYYY-MM-DD)',
            'gender (male/female/other)',
            'address',
            'city',
            'state',
            'country',
            'postal_code',
            'guardian_name',
            'guardian_phone',
            'enrollment_number',
            'admission_date (YYYY-MM-DD)',
            'grade',
            'section',
            'blood_group',
            'nationality',
            'religion',
            'language_preference',
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        return response()->streamDownload(
            $callback,
            'student_import_template.csv',
            ['Content-Type' => 'text/csv']
        );
    }

    public function bulkStore(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt'
            ]);

            $path = $request->file('file')->getRealPath();
            $rows = array_map('str_getcsv', file($path));

            if (count($rows) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSV file is empty'
                ]);
            }

            $headers = array_map('trim', array_shift($rows));

            $inserted = 0;
            $skipped  = 0;

            foreach ($rows as $row) {
                $data = array_combine($headers, $row);

                if (empty($data['first_name']) || empty($data['dob']) || empty($data['admission_date'])) {
                    $skipped++;
                    continue;
                }

                // Prevent duplicate email
                if (!empty($data['email']) &&
                    Student::on('tenant')->where('email', $data['email'])->exists()) {
                    $skipped++;
                    continue;
                }

                Student::on('tenant')->create([
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'] ?? null,
                    'email'      => $data['email'] ?? null,
                    'password'   => $data['email'] ? bcrypt(Str::random(8)) : null,
                    'phone_number' => $data['phone_number'] ?? null,
                    'dob' => Carbon::parse($data['dob']),
                    'gender' => $data['gender'] ?? null,
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                    'state' => $data['state'] ?? null,
                    'country' => $data['country'] ?? null,
                    'postal_code' => $data['postal_code'] ?? null,
                    'guardian_name' => $data['guardian_name'] ?? null,
                    'guardian_phone' => $data['guardian_phone'] ?? null,
                    'enrollment_number' => $data['enrollment_number'] ?? null,
                    'admission_date' => Carbon::parse($data['admission_date']),
                    'grade' => $data['grade'] ?? null,
                    'section' => $data['section'] ?? null,
                    'blood_group' => $data['blood_group'] ?? null,
                    'nationality' => $data['nationality'] ?? null,
                    'religion' => $data['religion'] ?? null,
                    'language_preference' => $data['language_preference'] ?? null,
                ]);

                $inserted++;
            }

            return response()->json([
                'success' => true,
                'message' => "Imported {$inserted} students. Skipped {$skipped} rows."
            ]);

        } catch (Exception $e) {
            Log::error('Student import failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Import failed. Check file format.'
            ]);
        }
    }

    public function csvBulkStore(Request $request)
    {
        Log::info('CSV IMPORT STARTED');

        $request->headers->set('Accept', 'application/json');

        $request->validate([
            'file'     => 'required|file|mimes:csv,txt',
            'class_id' => 'required|exists:classes,id',
        ]);

        DB::beginTransaction();

        try {
            $path = $request->file('file')->getRealPath();
            $handle = fopen($path, 'r');

            if (!$handle) {
                throw new Exception('Unable to open CSV file');
            }

            $headers = array_map(
                fn ($h) => strtolower(trim(str_replace(' ', '_', preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)))),
                fgetcsv($handle)
            );

            Log::info('NORMALIZED HEADERS', $headers);

            $inserted = 0;
            $skipped  = 0;
            $rowNo    = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNo++;

                if (count($headers) !== count($row)) {
                    Log::warning("COLUMN COUNT MISMATCH AT ROW {$rowNo}");
                    $skipped++; continue;
                }

                $data = array_combine($headers, $row);

                if (isset($data['dob_(yyyy-mm-dd)'])) {
                    $data['dob'] = $data['dob_(yyyy-mm-dd)'];
                }

                if (isset($data['admission_date_(yyyy-mm-dd)'])) {
                    $data['admission_date'] = $data['admission_date_(yyyy-mm-dd)'];
                }

                Log::info("ROW DATA {$rowNo}", $data);

                if (
                    empty($data['first_name']) ||
                    empty($data['dob']) ||
                    empty($data['admission_date'])
                ) {
                    Log::warning("REQUIRED FIELD MISSING AT ROW {$rowNo}");
                    $skipped++; continue;
                }

                if (
                    !empty($data['email']) &&
                    Student::on('tenant')->where('email', $data['email'])->exists()
                ) {
                    Log::warning("DUPLICATE EMAIL AT ROW {$rowNo}");
                    $skipped++; continue;
                }

                try {
                    $dob = Carbon::parse(trim($data['dob']));
                    $admissionDate = Carbon::parse(trim($data['admission_date']));
                } catch (Exception $e) {
                    Log::warning("INVALID DATE FORMAT AT ROW {$rowNo}", $data);
                    $skipped++; continue;
                }

                $student = Student::on('tenant')->create([
                    'first_name'     => trim($data['first_name']),
                    'last_name'      => $data['last_name'] ?? null,
                    'email'          => $data['email'] ?? null,
                    'password'       => !empty($data['email']) ? bcrypt(Str::random(8)) : null,
                    'phone_number'   => $data['phone_number'] ?? null,
                    'dob'            => $dob,
                    'admission_date' => $admissionDate,
                    'grade'          => $data['grade'] ?? null,
                    'section'        => $data['section'] ?? null,
                    'is_deleted'     => 0,
                ]);

                DB::table('class_student')->insert([
                    'class_id'   => $request->class_id,
                    'student_id'=> $student->id,
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);

                $inserted++;
            }

            fclose($handle);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Imported {$inserted} students. Skipped {$skipped} rows."
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('CSV IMPORT FAILED', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'CSV import failed. Check logs.'
            ], 500);
        }
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
