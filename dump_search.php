<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/search?category=pesawat&origin=&destination=&date=&return_date=&is_round_trip=false&class=All', 'GET');

// Capture queries
\DB::enableQueryLog();

$res = app(App\Http\Controllers\TicketController::class)->search($req);

file_put_contents('query_log.txt', print_r(\DB::getQueryLog(), true));
echo "Tickets size: " . count(json_decode($res->getContent(), true)['tickets']);
