<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentManagement\Http\Controllers\StudentManagementController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('studentmanagements', StudentManagementController::class)->names('studentmanagement');
});
