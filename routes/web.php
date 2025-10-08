<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login
Route::get("/", [AuthController::class, "login"])->name("login");
Route::post("/login", [AuthController::class, "CheckLogin"])->name("check_login");

// Register
Route::get("/register", [AuthController::class, "register"])->name("register");
Route::post("/register/technician", [AuthController::class, "registration"])->name("apply");
