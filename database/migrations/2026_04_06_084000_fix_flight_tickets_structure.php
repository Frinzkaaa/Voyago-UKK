<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop existing table to start clean (since the user agreed)
        Schema::dropIfExists('flight_tickets');

        // 2. Recreate with correct order and naming
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('airline_name');
            $table->string('flight_code');
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('baggage_info')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('seats_available');
            $table->string('class')->default('Economy');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->string('airline_logo')->nullable();
            $table->json('gallery')->nullable();
            $table->json('interior_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_tickets');
    }
};
