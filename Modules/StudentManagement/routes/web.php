<?php

use Illuminate\Support\Facades\Route;
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

    Route::get('/student-create', [StudentManagementController::class, 'create'])->name('student-create');
    Route::post('/store', [StudentManagementController::class, 'store'])->name('store');
    Route::get('/edit-list', [StudentManagementController::class, 'editList'])->name('edit.list');
    Route::get('/edit/{id}', [StudentManagementController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [StudentManagementController::class, 'update'])->name('update');
});

Route::middleware(['web', NeedsTenant::class, 'school.auth'])->prefix('tenant/student')->as('tenant.student.')->group(function () {
    Route::get('/student-dashboard', [StudentManagementController::class, 'index'])->name('student-index');
    Route::get('/list', [StudentManagementController::class, 'getStudents'])->name('list');
});


Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/teacher')->as('tenant.teacher.')->group(function () {
    Route::get('/teacher-dashboard', [TeachersController::class, 'index'])->name('teacher-index');
    Route::get('/teacher-create', [TeachersController::class, 'create'])->name('teacher-create');
    Route::get('/teachers-list', [TeachersController::class, 'getTeachers'])->name('teachers-list');
});

Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/class')->as('tenant.class.')->group(function () {
    Route::get('/class-dashboard', [ClassManagementController::class, 'index'])->name('class-index');
    Route::get('/class-create', [ClassManagementController::class, 'create'])->name('class-create');
});

Route::middleware(['web', NeedsTenant::class,'school.auth'])->prefix('tenant/subject')->as('tenant.subject.')->group(function () {
    Route::get('/subject-dashboard', [SubjectManagementController::class, 'index'])->name('subject-index');
    Route::get('/subject-create', [SubjectManagementController::class, 'create'])->name('subject-create');
});
