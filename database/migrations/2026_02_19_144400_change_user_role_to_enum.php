<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First, ensure all 'mitra' are renamed to 'partner' if any left
            DB::table('users')->where('role', 'mitra')->update(['role' => 'partner']);
        });

        // Change role to ENUM
        // We use DB::statement for compatibility and to ensure the exact ENUM values are set
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'partner', 'admin') NOT NULL DEFAULT 'user'");

        // Change status to ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'pending', 'rejected', 'suspended') NOT NULL DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
            $table->string('status')->default('active')->change();
        });
    }
};
