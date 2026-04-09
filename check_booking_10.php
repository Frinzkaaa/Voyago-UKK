<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Booking;
$b = Booking::find(10);
if ($b) {
    print_r($b->toArray());
} else {
    echo "Not found";
}
