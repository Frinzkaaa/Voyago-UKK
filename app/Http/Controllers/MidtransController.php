<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Enums\PaymentStatus;
use App\Enums\BookingStatus;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $booking = Booking::where('booking_code', $request->order_id)->first();
            if ($booking) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $booking->update(['payment_status' => PaymentStatus::PAID, 'status' => BookingStatus::CONFIRMED]);
                } else if ($request->transaction_status == 'pending') {
                    $booking->update(['payment_status' => PaymentStatus::PENDING]);
                } else {
                    $booking->update(['payment_status' => PaymentStatus::FAILED, 'status' => BookingStatus::CANCELLED]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
