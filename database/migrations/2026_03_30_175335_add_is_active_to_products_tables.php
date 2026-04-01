<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['wisata_spots', 'hotels', 'flight_tickets', 'train_tickets', 'bus_tickets'];
        
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Common missing columns
                if (!Schema::hasColumn($tableName, 'status')) {
                    $table->string('status')->default('active');
                }
                if (!Schema::hasColumn($tableName, 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                if (!Schema::hasColumn($tableName, 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::hasColumn($tableName, 'gallery')) {
                    $table->json('gallery')->nullable();
                }
                
                // Specific missing columns for Bus
                if ($tableName === 'bus_tickets') {
                    if (!Schema::hasColumn($tableName, 'arrival_time')) {
                        $table->dateTime('arrival_time')->nullable();
                    }
                    if (!Schema::hasColumn($tableName, 'duration')) {
                        $table->string('duration')->nullable();
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
