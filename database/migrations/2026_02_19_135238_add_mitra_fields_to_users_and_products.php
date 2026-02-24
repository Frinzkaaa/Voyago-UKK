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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // user, mitra, admin
            $table->string('status')->default('active'); // active, pending (for mitra)
            $table->text('mitra_info')->nullable(); // For registration details
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Customer
            $table->unsignedBigInteger('mitra_id')->nullable(); // Product owner
            $table->string('status')->default('Menunggu Konfirmasi');
            // Menunggu Konfirmasi, Confirmed, Completed, Cancelled, Refunded, Rescheduled
            $table->decimal('commission_amount', 15, 2)->default(0);
            $table->decimal('net_income', 15, 2)->default(0);
            $table->dateTime('confirmed_at')->nullable();
        });

        // Add user_id (mitra) to product tables
        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $blueprint) {
                $blueprint->unsignedBigInteger('user_id')->nullable(); // Owner (Mitra)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'mitra_info']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'mitra_id', 'status', 'commission_amount', 'net_income', 'confirmed_at']);
        });

        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $blueprint) {
                $blueprint->dropColumn('user_id');
            });
        }
    }
};
