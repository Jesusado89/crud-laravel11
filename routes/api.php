<?php

use App\Http\Controllers\userController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', [userController::class, 'index']);
Route::get('/users/{id}',[userController::class, 'show']);
Route::post('/users', [userController::class, 'store']);
Route::put('/users/{id}',[userController::class, 'update']);
Route::patch('/users/{id}',[userController::class, 'updatePartial']);
Route::delete('/users/{id}',[userController::class, 'destroy']);

