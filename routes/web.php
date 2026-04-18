<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;

use App\Http\Controllers\MidtransController;

Route::post('/payment/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Auth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/', [TicketController::class, 'index'])->name('beranda');
Route::get('/search', [TicketController::class, 'search'])->name('search');
Route::get('/get-locations', [TicketController::class, 'getLocations'])->name('get.locations');
Route::get('/booked-seats', [TicketController::class, 'getBookedSeats'])->name('booked.seats');
Route::middleware('auth')->group(function () {
    Route::get('/pemesanan', [TicketController::class, 'bookingPage'])->name('booking.page');
    Route::post('/checkout', [TicketController::class, 'checkout'])->name('checkout');
    Route::post('/simulate-payment', [TicketController::class, 'simulatePayment'])->name('simulate.payment');
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
    Route::post('/account/delete', [TicketController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/payment-methods', [TicketController::class, 'storePaymentMethod'])->name('payment-methods.store');
    Route::post('/payment-methods/{id}/delete', [TicketController::class, 'deletePaymentMethod'])->name('payment-methods.delete');
    Route::post('/payment-methods/{id}/set-default', [TicketController::class, 'setDefaultPaymentMethod'])->name('payment-methods.set-default');
    Route::post('/complaint', [TicketController::class, 'storeComplaint'])->name('complaint.store');
    Route::get('/complaints', [TicketController::class, 'myComplaints'])->name('complaints.my');
    Route::post('/booking/{id}/cancel', [TicketController::class, 'cancelBooking'])->name('booking.cancel');
    Route::get('/booking/{id}/ticket', [TicketController::class, 'downloadTicket'])->name('booking.ticket');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));

// Partner Routes
Route::prefix('partner')->name('partner.')->group(base_path('routes/partner.php'));

use Midtrans\Config;
use Midtrans\Snap;

Route::get('/test-midtrans', function () {
    Config::$serverKey = config('services.midtrans.server_key');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
    ];

    $token = Snap::getSnapToken($params);

    return $token;
});