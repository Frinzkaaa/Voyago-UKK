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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Kereta, Pesawat, Bus, Hotel, Wisata
            $table->string('icon');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('train_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('duration');
            $table->string('class');
            $table->decimal('price', 15, 2);
            $table->integer('seats_available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('airline_name');
            $table->string('flight_code');
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('duration');
            $table->string('baggage_info');
            $table->decimal('price', 15, 2);
            $table->integer('seats_available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bus_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('operator');
            $table->string('origin_terminal');
            $table->string('destination_terminal');
            $table->dateTime('departure_time');
            $table->string('seat_type');
            $table->decimal('price', 15, 2);
            $table->integer('seats_available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->decimal('rating', 3, 1);
            $table->decimal('price_per_night', 15, 2);
            $table->string('room_type');
            $table->integer('availability');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('wisata_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // e.g. Nature, Park
            $table->string('open_hours')->nullable();
            $table->decimal('price', 15, 2);
            $table->text('description');
            $table->integer('availability');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('category'); // kereta, pesawat, etc
            $table->unsignedBigInteger('item_id');
            $table->integer('passenger_count');
            $table->decimal('total_price', 15, 2);
            $table->string('payment_status')->default('pending'); // pending, paid, cancelled
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('wisata_spots');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('bus_tickets');
        Schema::dropIfExists('flight_tickets');
        Schema::dropIfExists('train_tickets');
        Schema::dropIfExists('categories');
    }
};
