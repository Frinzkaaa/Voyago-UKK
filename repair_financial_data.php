<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\Partner;
use App\Enums\PaymentStatus;

$paidBookings = Booking::where('payment_status', PaymentStatus::PAID)
    ->where(function($q) {
        $q->whereNull('commission_amount')
          ->orWhere('commission_amount', 0)
          ->orWhereNull('net_income')
          ->orWhere('net_income', 0);
    })->get();

echo "Found " . $paidBookings->count() . " bookings to repair.\n";

foreach ($paidBookings as $b) {
    $partner = Partner::where('user_id', $b->mitra_id)->first();
    $rate = $partner->commission_rate ?? 10;
    $basePrice = max(0, $b->total_price - 10000); // 10k is Voyago service fee
    $commissionAmount = $basePrice * ($rate / 100);
    $netIncome = $basePrice - $commissionAmount;

    $b->update([
        'commission_amount' => $commissionAmount,
        'net_income' => $netIncome
    ]);
    echo "Repaired Booking ID: $b->id | Commission: $commissionAmount | Net: $netIncome\n";
}

echo "Done.\n";
