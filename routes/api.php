<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('products', [App\Http\Controllers\RatingController::class, 'product_list']);
    Route::post('store', [App\Http\Controllers\RatingController::class, 'store']);
    Route::put('update/{id}', [App\Http\Controllers\RatingController::class, 'update']);
    Route::delete('destroy/{id}', [App\Http\Controllers\RatingController::class, 'destroy']);
});


Route::post('register', [PatientController::class, 'register']);
