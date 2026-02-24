<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'status')) {
                    $table->string('status')->default('active')->after('user_id');
                }
                if (!Schema::hasColumn($tableName, 'image') && $tableName !== 'hotels' && $tableName !== 'wisata_spots') {
                    $table->string('image')->nullable()->after('status');
                }
                // Also add location to wisata_spots if missing
                if ($tableName === 'wisata_spots' && !Schema::hasColumn($tableName, 'location')) {
                    $table->string('location')->nullable()->after('category');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropColumn(['status']);
                if ($tableName !== 'hotels' && $tableName !== 'wisata_spots') {
                    $table->dropColumn(['image']);
                }
                if ($tableName === 'wisata_spots') {
                    $table->dropColumn(['location']);
                }
            });
        }
    }
};
