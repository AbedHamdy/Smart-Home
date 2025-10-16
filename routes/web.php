<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TechnicianRequestsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\DashboardClientController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ServiceRequestController;
use App\Http\Controllers\Technician\DashboardTechnicianController;
use App\Http\Controllers\Technician\RequestController;
use App\Http\Controllers\Technician\TechnicianVerificationController;
use App\Http\Controllers\TechnicianLocationController;
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

    // Technician Request
    Route::get("/admin/management/technician/requests", [TechnicianRequestsController::class, "index"])->name("admin_technician_requests.index");
    Route::put("/admin/management/technician/requests/{id}/approve", [TechnicianRequestsController::class, "approve"])
        ->where('id', '[1-9][0-9]*')
        ->name("admin_technician_requests.approve");
    Route::put("/admin/management/technician/requests/{id}/reject", [TechnicianRequestsController::class, "reject"])
        ->where('id', '[1-9][0-9]*')
        ->name("admin_technician_requests.reject");
    Route::get("/admin/management/technician/requests/{id}/show", [TechnicianRequestsController::class, "show"])
        ->where('id', '[1-9][0-9]*')
        ->name("admin_technician_requests.show");

    // Notification
    Route::get('/notification/{id}/read', function($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        if (!$notification->read_at)
        {
            $notification->markAsRead();
        }
        return redirect($notification->data['url'] ?? '/admin/dashboard');
    })->name('notification.read');

});

// Client
Route::middleware(['auth', 'client',  'update.last.activity'])->group(function () {
    // Dashboard
    Route::get("/client/dashboard", [DashboardClientController::class, "index"])->name("client_dashboard");

    // Request
    Route::get("/client/all/request", [ServiceRequestController::class, "index"])->name("client.service_request.index");
    Route::get("/client/create/request", [ServiceRequestController::class, "create"])->name("client.service_requests.create");
    Route::post("/client/store/request", [ServiceRequestController::class, "store"])->name("client.service_request.store");
    Route::get('/client/show/{id}/requests', [ServiceRequestController::class, 'show'])
        ->where('id', '[1-9][0-9]*')
        ->name('client.service_request.show');
    Route::delete('/client/delete/{id}/request', [ServiceRequestController::class, 'destroy'])
        ->where('id', '[1-9][0-9]*')
        ->name('client.service_request.destroy');

    // Profile
    Route::get("/client/profile", [ProfileController::class, "index"])->name("client_profile.index");
    Route::put("/client/profile/update/information", [ProfileController::class, "update"])->name("client_profile.update");
    Route::put("/client/profile/update/password", [ProfileController::class, "updatePassword"])->name("client_profile.updatePassword");
});

// Technician
Route::middleware(['auth', 'technician',  'update.last.activity.technician'])->group(function () {
    // Dashboard
    Route::get("/technician/dashboard", [DashboardTechnicianController::class, "index"])->name("technician_dashboard");

    // Request
    Route::get("/technician/requests", [RequestController::class, "index"])->name("technician_requests.index");
    Route::get("/technician/my/requests", [RequestController::class, "myRequests"])->name("technician_request.myRequests");
    Route::get("/technician/my/requests/{id}/show", [RequestController::class, "showOne"])
        ->where('id', '[1-9][0-9]*')
        ->name("technician_request.showOne");
        Route::put('/technician/my/requests/{id}/update-status', [RequestController::class, 'updateStatus'])
            ->where('id', '[1-9][0-9]*')
            ->name('technician_request.update_status');
    Route::get("/technician/requests/{id}/show", [RequestController::class, "show"])
        ->where('id', '[1-9][0-9]*')
        ->name("technician_requests.show");
    Route::put('/requests/{id}/accept', [RequestController::class, 'accept'])
        ->where('id', '[1-9][0-9]*')
        ->name('technician_requests.accept');
    Route::put('/requests/{id}/reject', [RequestController::class, 'reject'])
        ->where('id', '[1-9][0-9]*')
        ->name('technician_requests.reject');

    // Location
    Route::post('/technician/update-location', [TechnicianController::class, 'updateLocation'])->name('technician.updateLocation');

    // Verification
    Route::get('/technician/verification', [TechnicianVerificationController::class, 'show'])->name('technician.verification');
    Route::post('/technician/verification', [TechnicianVerificationController::class, 'verify'])->name('technician.verification.verify');
    Route::post('/technician/verification/resend', [TechnicianVerificationController::class, 'resend'])->name('technician.verification.resend');
});
