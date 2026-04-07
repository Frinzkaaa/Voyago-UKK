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
        $serverKey = config('services.midtrans.server_key') ?: config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $booking = Booking::where('booking_code', $request->order_id)->first();
            if ($booking) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    // Calculate commission for the partner
                    $partner = \App\Models\Partner::where('user_id', $booking->mitra_id)->first();
                    $rate = $partner->commission_rate ?? 10; // Default 10% commission
                    $basePrice = max(0, $booking->total_price - 10000); // 10k service fee
                    $commissionAmount = $basePrice * ($rate / 100);
                    $netIncome = $basePrice - $commissionAmount;

                    $booking->update([
                        'payment_status' => PaymentStatus::PAID, 
                        'status' => BookingStatus::CONFIRMED,
                        'commission_amount' => $commissionAmount,
                        'net_income' => $netIncome,
                        'confirmed_at' => now()
                    ]);

                    // Award Voyago Points to User
                    $user = $booking->user;
                    if ($user) {
                        $user->points += 10;
                        $user->updateBadge();
                        $user->save();
                    }
                } else if ($request->transaction_status == 'pending') {
                    $booking->update(['payment_status' => PaymentStatus::PENDING]);
                } else if ($request->transaction_status == 'refund') {
                    $booking->update([
                        'payment_status' => PaymentStatus::REFUNDED,
                        'status' => BookingStatus::REFUNDED
                    ]);
                    
                    // Deduct points if previously awarded
                    $user = $booking->user;
                    if ($user) {
                        $user->points = max(0, $user->points - 10);
                        $user->updateBadge();
                        $user->save();
                    }
                } else {
                    $booking->update(['payment_status' => PaymentStatus::FAILED, 'status' => BookingStatus::CANCELLED]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
