<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;

$bookings = Booking::all();
foreach ($bookings as $b) {
    if (($b->payment_status->value ?? $b->payment_status) == 'paid' && ($b->commission_amount == 0 || $b->net_income == 0)) {
        echo "ID: " . $b->id . " | ";
        echo "Status: " . (is_object($b->status) ? $b->status->value : $b->status) . " | ";
        echo "Payment: " . (is_object($b->payment_status) ? $b->payment_status->value : $b->payment_status) . " | ";
        echo "Total: " . $b->total_price . " | ";
        echo "Commission: " . $b->commission_amount . " | ";
        echo "Net: " . $b->net_income . "\n";
    }
}
