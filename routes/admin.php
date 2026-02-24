<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/tickets/{category}', [AdminController::class, 'list'])->name('tickets.list');
    Route::get('/tickets/{category}/create', [AdminController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/{category}/store', [AdminController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{category}/{id}/edit', [AdminController::class, 'edit'])->name('tickets.edit');
    Route::post('/tickets/{category}/{id}/update', [AdminController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{category}/{id}/delete', [AdminController::class, 'destroy'])->name('tickets.delete');

    // Partner verification
    Route::get('/verifikasi-mitra', [AdminController::class, 'verifikasiMitra'])->name('verifikasi.mitra');
    Route::post('/partners/{userId}/verify', [AdminController::class, 'verifyPartner'])->name('partners.verify');
    Route::post('/partners/{userId}/reject', [AdminController::class, 'rejectPartner'])->name('partners.reject');

    // Bookings
    Route::get('/monitoring-transaksi', [AdminController::class, 'monitoringTransaksi'])->name('monitoring.transaksi');
    Route::post('/bookings/{bookingId}/cancel', [AdminController::class, 'cancelBooking'])->name('bookings.cancel');

    // Stats & Reports
    Route::get('/stats', [AdminController::class, 'dashboard'])->name('stats'); // Reusing dashboard for stats response
    Route::get('/monitoring-komplain', [AdminController::class, 'monitoringKomplain'])->name('monitoring.komplain');
    Route::post('/complaints/{id}/forward', [AdminController::class, 'forwardComplaintToMitra'])->name('complaints.forward');
    Route::post('/complaints/{id}/respond', [AdminController::class, 'respondComplaint'])->name('complaints.respond');
    Route::get('/cetak-laporan', [AdminController::class, 'cetakLaporan'])->name('cetak.laporan');
    Route::get('/export-laporan', [AdminController::class, 'exportLaporan'])->name('export.laporan');
});
