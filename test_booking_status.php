<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$bookings = \App\Models\Booking::all();
foreach ($bookings as $b) {
    echo "ID: " . $b->id . " - Payment: " . $b->payment_status->value . " - Status: " . $b->status->value . "\n";
}
echo "Done\n";
