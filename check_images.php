<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$output = "";

$tables = [
    'flight_tickets' => App\Models\FlightTicket::class,
    'train_tickets' => App\Models\TrainTicket::class,
    'bus_tickets' => App\Models\BusTicket::class,
    'hotels' => App\Models\Hotel::class,
    'wisata_spots' => App\Models\WisataSpot::class,
];

foreach ($tables as $name => $model) {
    $output .= "\n--- $name ---\n";
    $items = $model::all();
    foreach ($items as $item) {
        $label = $item->flight_code ?? $item->name ?? $item->operator ?? "ID:{$item->id}";
        $cols = $item->getAttributes();
        $imgCols = [];
        foreach ($cols as $key => $val) {
            if (str_contains($key, 'image') || str_contains($key, 'logo') || str_contains($key, 'gallery') || str_contains($key, 'photo') || str_contains($key, 'img')) {
                $imgCols[$key] = $val ?: '(empty)';
            }
        }
        $output .= "$label => " . json_encode($imgCols) . "\n";
    }
}

file_put_contents(__DIR__ . '/image_report.txt', $output);
echo "Report written to image_report.txt\n";
