<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/course", [CourseController::class, 'index']);
Route::post("/course", [CourseController::class, 'store']);
Route::patch("/course/{id}", [CourseController::class, 'update']);
Route::delete("/course/{id}", [CourseController::class, 'delete']);
