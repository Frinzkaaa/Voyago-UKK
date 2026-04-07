<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\FlightTicket;

$garudaId = User::where('email', 'garuda@voyago.com')->first()->id;
FlightTicket::create([
    'airline_name' => 'Garuda Indonesia',
    'flight_code' => 'GA-402',
    'origin' => 'CGK',
    'destination' => 'DPS',
    'departure_time' => '2026-04-18 10:00:00',
    'arrival_time' => '2026-04-18 12:00:00',
    'duration' => '2j 0m',
    'baggage_info' => '20kg',
    'price' => 1850000,
    'seats_available' => 120,
    'user_id' => $garudaId,
    'status' => 'active',
    'is_active' => true
]);
echo "Flight Seeded Successfully\n";
