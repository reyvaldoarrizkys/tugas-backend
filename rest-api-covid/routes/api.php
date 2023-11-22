<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/register", [AuthController::class,"register"])->name('register');;
Route::post("/login", [AuthController::class,"login"])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get("/patients", [PatientController::class, "index"]);
    Route::post("/patients", [PatientController::class, "store"]);
    Route::put("/patients/{id}", [PatientController::class, "update"]);
    Route::delete("/patients/{id}", [PatientController::class, "destroy"]);
    Route::get("/patients/{id}", [PatientController::class, "show"]);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
