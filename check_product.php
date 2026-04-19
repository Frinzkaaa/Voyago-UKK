<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\WisataSpot;
use App\Models\Partner;
use App\Models\User;

echo "--- CHECKING PRODUCT AND PARTNER STATUS ---\n";

$product = WisataSpot::where('name', 'LIKE', '%Tanah Lot%')->first();

if (!$product) {
    echo "Product 'Tanah Lot' not found in database.\n";
} else {
    echo "Product Name: " . $product->name . "\n";
    echo "Product Status: " . $product->status . "\n";
    echo "Product Is Active: " . ($product->is_active ? 'YES' : 'NO') . "\n";
    echo "Owner ID (User ID): " . $product->user_id . "\n";

    $partner = Partner::where('user_id', $product->user_id)->first();
    if (!$partner) {
        echo "Partner record NOT FOUND for user ID: " . $product->user_id . "\n";
    } else {
        echo "Partner Status: " . $partner->status . "\n";
        echo "Partner Company Name: " . $partner->company_name . "\n";
    }
}
