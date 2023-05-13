<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::get('/pets', [PetController::class, 'index']);
   Route::post('/pets', [PetController::class, 'store']);
   Route::get('/pets/{id}', [PetController::class, 'show']);
   Route::put('/pets/{id}', [PetController::class, 'update']);
   Route::delete('/pets/{id}', [PetController::class, 'destroy']);
Route::middleware(['auth.sanctum'])->group(function () {
   // Get all pets


    });

//___________________________________________
