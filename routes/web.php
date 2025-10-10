<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\CategoryController;
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
    Route::get("/admin/management/client/{id}/show", [ClientController::class, "show"])
        ->where('id', '[1-9][0-9]*')
        ->name("client.show");
    Route::delete("/admin/management/client/{id}/delete", [ClientController::class, "destroy"])
        ->where('id', '[1-9][0-9]*')
        ->name("client.destroy");

    // Technician
    Route::get("/admin/management/technician", [TechnicianController::class, "index"])->name("admin.technician");
    Route::get("/admin/management/technician/create", [TechnicianController::class, "create"])->name("technician.create");
    Route::post("/admin/management/technician", [TechnicianController::class, "store"])->name("technician.store");
    Route::get("/admin/management/technician/{id}/show", [TechnicianController::class, "show"])
        ->where('id', '[1-9][0-9]*')
        ->name("technician.show");
    Route::delete("/admin/management/technician/{id}/delete", [TechnicianController::class, "destroy"])
        ->where('id', '[1-9][0-9]*')
        ->name("technician.destroy");

    // Category Management
    Route::get("/admin/management/category", [CategoryController::class, "index"])->name("category.index");
    Route::get("/admin/management/category/create", [CategoryController::class, "create"])->name("category.create");
    Route::post("/admin/management/category", [CategoryController::class, "store"])->name("category.store");
    Route::get("/admin/management/category/{id}/edit", [CategoryController::class, "edit"])
        ->where('id', '[1-9][0-9]*')
        ->name("category.edit");
    Route::put("/admin/management/category/{id}", [CategoryController::class, "update"])
        ->where('id', '[1-9][0-9]*')
        ->name("category.update");
    Route::delete("/admin/management/category/{id}", [CategoryController::class, "destroy"])
        ->where('id', '[1-9][0-9]*')
        ->name("category.destroy");
});
