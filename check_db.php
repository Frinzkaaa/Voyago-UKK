<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$bookings = \App\Models\Booking::latest()->take(5)->get();
foreach ($bookings as $b) {
    echo "ID: " . $b->id . " | Code: " . $b->booking_code . " | Payment: " . $b->payment_status->value . " | Status: " . $b->status->value . " | Mitra: " . $b->mitra_id . "\n";
}
echo "Done\n";
