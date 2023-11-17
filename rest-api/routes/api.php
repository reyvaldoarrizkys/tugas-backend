<?php


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalsController;
use App\Http\Controllers\StudentController;

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

Route::get("/animals", [AnimalsController::class,"index"]);
Route::post("/animals", [AnimalsController::class,"store"]);
Route::put("/animals/{id}", [AnimalsController::class,"update"]);
Route::delete("/animals/{id}", [AnimalsController::class,"destroy"]);

Route::get("/students", [StudentController::class,"index"])->middleware('auth:sanctum');
Route::post("/students", [StudentController::class,"store"]);
Route::put("/students/{id}", [StudentController::class,"update"]);
Route::delete("/students/{id}", [StudentController::class,"destroy"]);
Route::get("/students/{id}", [StudentController::class,"show"]);

Route::post("/register", [AuthController::class,"register"]);
Route::post("/login", [AuthController::class,"login"]);