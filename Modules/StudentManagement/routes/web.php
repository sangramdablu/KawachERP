<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentManagement\Http\Controllers\AttendanceController;
use Modules\StudentManagement\Http\Controllers\StudentManagementController;
use Modules\StudentManagement\Http\Controllers\TeachersController;
use Modules\StudentManagement\Http\Controllers\ClassManagementController;
use Modules\StudentManagement\Http\Controllers\SubjectManagementController;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('studentmanagements', StudentManagementController::class)->names('studentmanagement');
});


Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/student')->as('tenant.student.')->group(function () {

    Route::get('/student-dashboard', [StudentManagementController::class, 'index'])->name('student-index');
    Route::get('/list', [StudentManagementController::class, 'getStudents'])->name('list');

    Route::get('/student-bulk-add', [StudentManagementController::class, 'bulkAddIndex'])->name('bulkaddstudent');
    Route::post('/bulk-store', [StudentManagementController::class, 'bulkStore'])->name('bulkStore');

    Route::get('/{id}/edit', [StudentManagementController::class, 'edit'])->name('editstudent');
    Route::post('/update/{id}', [StudentManagementController::class, 'update'])->name('updatestudent');

    // Students
    Route::get('/student-create', [StudentManagementController::class, 'create'])->name('student-create');
    Route::post('/store', [StudentManagementController::class, 'store'])->name('store');
    Route::get('/edit-list', [StudentManagementController::class, 'editList'])->name('edit.list');
    Route::get('/edit/{id}', [StudentManagementController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [StudentManagementController::class, 'update'])->name('update');

    // Student Attendance
    Route::get('/student-attendance', [AttendanceController::class, 'index'])->name('student-attendance');
    Route::get('/teacher-attendance', [AttendanceController::class, 'index'])->name('teacher-attendance');
    Route::get('/get-student-attendace', [AttendanceController::class, 'index'])->name('get-student-attendace');

});

// Routes for School Admin
Route::middleware(['web', NeedsTenant::class, 'school.auth'])->prefix('tenant/student')->as('tenant.student.')->group(function () {
    Route::get('/student-dashboard', [StudentManagementController::class, 'index'])->name('student-index');
    Route::get('/list', [StudentManagementController::class, 'getStudents'])->name('list');
    Route::get('/student-view/{id}', [StudentManagementController::class,'view'])->name('student-view');
    Route::post('/student/update/{id}', [StudentManagementController::class,'update']);

});

// Routes for Students
// Route::middleware(['web', NeedsTenant::class, 'student.auth'])->prefix('tenant/student')->as('tenant.student.')->group(function () {
//     Route::get('/student-dashboard', [StudentManagementController::class, 'index'])->name('student-index');

// });

Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/teacher')->as('tenant.teacher.')->group(function () {
    Route::get('/teacher-dashboard', [TeachersController::class, 'index'])->name('teacher-index');
    Route::get('/teacher-create', [TeachersController::class, 'create'])->name('teacher-create');
    Route::post('/teacher-store', [TeachersController::class, 'store'])->name('teacher-store');
    Route::get('/teachers-list', [TeachersController::class, 'getTeachers'])->name('teachers-list');
});

Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/class')->as('tenant.class.')->group(function () {
    Route::get('/class-dashboard', [ClassManagementController::class, 'index'])->name('class-index');
    Route::get('/class-create', [ClassManagementController::class, 'create'])->name('class-create');
    Route::get('/class-list', [ClassManagementController::class, 'getClasses'])->name('class-list');
    Route::post('/class-store', [ClassManagementController::class, 'store'])->name('class-store');
});

Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/subject')->as('tenant.subject.')->group(function () {
    Route::get('/subject-dashboard', [SubjectManagementController::class, 'index'])->name('subject-index');
    Route::get('/subject-create', [SubjectManagementController::class, 'create'])->name('subject-create');

    Route::post('/class/{id}/subjects', [SubjectManagementController::class, 'getClassSubjects'])->name('subject-clalist');

});
