<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pelanggan\DeviceController;
use App\Http\Controllers\Pelanggan\ReservationController;
use App\Http\Controllers\Pelanggan\PelangganServiceController;
use App\Http\Controllers\Pelanggan\PaymentController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Teknisi\TeknisiServiceController;


Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Rute khusus Pelanggan
    Route::middleware('role:pelanggan')->prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/dashboard', function () { return view('pelanggan.dashboard'); })->name('dashboard');
        Route::get('/devices', [DeviceController::class, 'index'])->name('device.index');
        Route::get('/devices/create', [DeviceController::class, 'create'])->name('device.create');
        Route::post('/devices', [DeviceController::class, 'store'])->name('device.store');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservation.create');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservation.store');
        Route::get('/services', [PelangganServiceController::class, 'index'])->name('service.index');
        Route::get('/services/{id}', [PelangganServiceController::class, 'show'])->name('service.show');
        Route::post('/diagnosis/{id}/respond', [PelangganServiceController::class, 'respondDiagnosis'])->name('diagnosis.respond');
        Route::get('/invoices/{invoice_id}/pay', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/invoices/{invoice_id}/pay', [PaymentController::class, 'store'])->name('payment.store');
        Route::post('/services/item/{id}/approve', [PelangganServiceController::class, 'approveItem'])->name('service.approve-item');
        Route::post('/services/item/{id}/reject', [PelangganServiceController::class, 'rejectItem'])->name('service.reject-item');
        Route::delete('/device/{id}', [DeviceController::class, 'destroy'])->name('device.destroy');
    });

    // Rute khusus Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservation.index');
        Route::get('/reservations/{id}/assign', [AdminReservationController::class, 'assignForm'])->name('reservation.assign');
        Route::post('/reservations/{id}/assign', [AdminReservationController::class, 'processAssign'])->name('reservation.process_assign');
        Route::get('/services/{service_id}/invoice/create', [AdminInvoiceController::class, 'create'])->name('invoice.create');
        Route::post('/services/{service_id}/invoice', [AdminInvoiceController::class, 'store'])->name('invoice.store');
        Route::get('/invoices/{id}/print', [AdminInvoiceController::class, 'print'])->name('invoice.print');
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payment.index');
        Route::post('/payments/{id}/verify', [AdminPaymentController::class, 'verify'])->name('payment.verify');
        Route::get('/inventories', [AdminInventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventories/create', [AdminInventoryController::class, 'create'])->name('inventory.create');
        Route::post('/inventories', [AdminInventoryController::class, 'store'])->name('inventory.store');
    });

    // Rute khusus Teknisi
    Route::middleware('role:teknisi')->prefix('teknisi')->name('teknisi.')->group(function () {
        Route::get('/dashboard', function () { return view('teknisi.dashboard'); })->name('dashboard');
        Route::get('/services', [TeknisiServiceController::class, 'index'])->name('service.index');
        Route::get('/services/{id}', [TeknisiServiceController::class, 'show'])->name('service.show');
        Route::post('/services/{id}/progress', [TeknisiServiceController::class, 'updateProgress'])->name('service.progress');
        Route::post('/services/{id}/diagnosis', [TeknisiServiceController::class, 'addDiagnosis'])->name('service.diagnosis');
        Route::post('/services/{id}/finish', [TeknisiServiceController::class, 'finishService'])->name('service.finish');
    });
});