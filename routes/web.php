<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardAdminController;
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
Route::get("/register", [AuthController::class, "registerTechnician"])->name("register_technician");
Route::post("/register/technician", [AuthController::class, "registrationTechnician"])->name("apply");
Route::get("/register/client", [AuthController::class, "registerClient"])->name("register_client");
Route::post("/client", [AuthController::class, "registrationClient"])->name("registration_client");

// Login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get("/admin/dashboard", [DashboardAdminController::class, "index"])->name("admin_dashboard");

    // Client
    Route::get("/admin/management/client", [ClientController::class, "index"])->name("admin.client");
});
