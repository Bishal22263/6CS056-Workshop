<?php
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;
Route::apiResource('students', StudentController::class);

use App\Http\Controllers\Api\CourseController;

Route::apiResource('courses', CourseController::class);