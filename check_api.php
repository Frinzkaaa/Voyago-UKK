<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$out = '';

$all = App\Models\FlightTicket::all();
foreach ($all as $f) {
    $status = is_object($f->status) ? $f->status->value : $f->status;
    $out .= $f->flight_code . " | status=" . $status 
         . " | is_active=" . ($f->is_active ? '1' : '0') 
         . " | user_id=" . $f->user_id
         . " | image=[" . ($f->image ?: 'EMPTY') . "]\n";
}

$out .= "\n--- PARTNERS ---\n";
$partners = App\Models\Partner::all();
foreach ($partners as $p) {
    $out .= "user_id=" . $p->user_id . " | status=" . $p->status . "\n";
}

file_put_contents(__DIR__ . '/diag.log', $out);
echo $out;
