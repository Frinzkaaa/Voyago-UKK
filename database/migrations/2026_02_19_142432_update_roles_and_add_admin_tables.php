<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Update user roles from 'mitra' to 'partner'
        DB::table('users')->where('role', 'mitra')->update(['role' => 'partner']);

        // Adjust users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change(); // Ensure default is user
        });

        // Create partners table
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, verified, rejected, suspended
            $table->decimal('commission_rate', 5, 2)->nullable(); // Overrides default if set
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        // Create activity_logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->string('target_type')->nullable(); // Model name
            $table->unsignedBigInteger('target_id')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // Create booking_logs table
        Schema::create('booking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who performed the action
            $table->string('previous_status')->nullable();
            $table->string('new_status');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Update product tables to include status
        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'status')) {
                    $table->string('status')->default('draft'); // draft, pending_review, active, rejected
                }
            });
        }

        // Add booking override fields
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'refund_reason')) {
                $table->text('refund_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('refund_reason');
        });

        $productTables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($productTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        Schema::dropIfExists('booking_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('partners');

        // Note: we don't roll back the role names 'partner' -> 'mitra' as it's a semantic change.
    }
};
