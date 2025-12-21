<?php

use App\Http\Controllers\ModulesController;
use App\Http\Controllers\SchoolRegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;

Route::get('/', function () {
    return Auth::guard('school')->check() ? redirect()->route('school.dashboard') : redirect()->route('pages.loginschool');
});

Route::get('/register-school', function () {
    return view('pages.registerschool');
})->name('pages.registerschool');

Route::get('/login-school', function () {
    return Auth::guard('school')->check() ? redirect()->route('school.dashboard') : view('pages.loginschool');
})->name('pages.loginschool');

Route::post('/school/register', [SchoolRegistrationController::class, 'store'])->name('school.register');
Route::post('/school/login', [SchoolRegistrationController::class, 'loginSchool'])->name('school.login.submit');

Route::prefix('school')->middleware(['web', NeedsTenant::class,'school.auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.index');
    })->name('school.dashboard');

    Route::get('/school/logout', [SchoolRegistrationController::class, 'logout'])->name('school.logout');
});

Route::prefix('tenant')->middleware(['web', NeedsTenant::class,'school.auth'])->group(function () {
    Route::get('/all-modules', [ModulesController::class, 'index'])->name('school.modules.index');
    Route::post('/install/{id}', [ModulesController::class, 'install'])->name('school.modules.install');
    Route::delete('/uninstall/{id}', [ModulesController::class, 'uninstall'])->name('school.modules.uninstall');
});
