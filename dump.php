<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tickets = [
    'train' => App\Models\TrainTicket::first()->toArray(),
    'flight' => App\Models\FlightTicket::first()->toArray(),
    'bus' => App\Models\BusTicket::first()->toArray(),
    'hotel' => App\Models\Hotel::first()->toArray(),
    'wisata' => App\Models\WisataSpot::first()->toArray()
];

echo json_encode($tickets, JSON_PRETTY_PRINT);
