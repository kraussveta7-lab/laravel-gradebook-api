<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\GradeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('students', StudentController::class);

Route::apiResource('subjects', SubjectController::class);

Route::controller(GradeController::class)->group(function () {
   
    Route::get('students/{student}/grades', 'index'); 

    Route::post('students/{student}/grades', 'store'); 
    
    Route::put('students/{student}/grades/{grade}', 'update'); 
    
    Route::delete('students/{student}/grades/{grade}', 'destroy');
});