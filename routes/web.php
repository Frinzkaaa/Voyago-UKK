<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [TicketController::class, 'index'])->name('beranda');
Route::get('/search', [TicketController::class, 'search'])->name('search');
Route::get('/get-locations', [TicketController::class, 'getLocations'])->name('get.locations');
Route::middleware('auth')->group(function () {
    Route::get('/pemesanan', [TicketController::class, 'bookingPage'])->name('booking.page');
    Route::post('/checkout', [TicketController::class, 'checkout'])->name('checkout');
    Route::get('/pesanan-saya', [TicketController::class, 'myBookings'])->name('my.bookings');
    Route::get('/planning', [TicketController::class, 'planningRoom'])->name('planning.room');
    Route::post('/planning/add-item', [TicketController::class, 'addItemToRoom'])->name('planning.add-item');
    Route::post('/planning/update-title/{roomId}', [TicketController::class, 'updateRoomTitle'])->name('planning.update-title');
    Route::post('/planning/finalize/{roomId}', [TicketController::class, 'finalizePlan'])->name('planning.finalize');
    Route::post('/planning/vote/{itemId}', [TicketController::class, 'voteRoomItem'])->name('planning.vote');
    Route::post('/planning/comment/{roomId}', [TicketController::class, 'addCommentToRoom'])->name('planning.comment');
    Route::post('/planning/invite/{roomId}', [TicketController::class, 'inviteMember'])->name('planning.invite');
    Route::post('/planning/item/delete/{itemId}', [TicketController::class, 'deleteRoomItem'])->name('planning.item.delete');
    Route::get('/settings', [TicketController::class, 'settings'])->name('settings');
    Route::get('/profile', [TicketController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [TicketController::class, 'updateProfile'])->name('profile.update');
    Route::post('/payment-methods', [TicketController::class, 'storePaymentMethod'])->name('payment-methods.store');
    Route::post('/payment-methods/{id}/delete', [TicketController::class, 'deletePaymentMethod'])->name('payment-methods.delete');
    Route::post('/payment-methods/{id}/set-default', [TicketController::class, 'setDefaultPaymentMethod'])->name('payment-methods.set-default');
    Route::post('/complaint', [TicketController::class, 'storeComplaint'])->name('complaint.store');
    Route::get('/complaints', [TicketController::class, 'myComplaints'])->name('complaints.my');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));

// Partner Routes
Route::prefix('partner')->name('partner.')->group(base_path('routes/partner.php'));