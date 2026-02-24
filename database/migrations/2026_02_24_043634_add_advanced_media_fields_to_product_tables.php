<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = ['train_tickets', 'flight_tickets', 'bus_tickets', 'hotels', 'wisata_spots'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->json('gallery')->nullable()->after('image');
            });
        }

        Schema::table('flight_tickets', function (Blueprint $table) {
            $table->string('airline_logo')->nullable()->after('gallery');
            $table->json('interior_images')->nullable()->after('airline_logo');
        });

        Schema::table('train_tickets', function (Blueprint $table) {
            $table->json('train_images')->nullable()->after('gallery');
            $table->json('seat_images')->nullable()->after('train_images');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->string('front_image')->nullable()->after('gallery');
            $table->json('room_images')->nullable()->after('front_image');
            $table->json('facility_images')->nullable()->after('room_images');
        });

        Schema::table('wisata_spots', function (Blueprint $table) {
            $table->string('main_image')->nullable()->after('gallery');
            $table->json('spot_images')->nullable()->after('main_image');
            $table->json('package_images')->nullable()->after('spot_images');
        });
    }

    public function down(): void
    {
        Schema::table('wisata_spots', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'main_image', 'spot_images', 'package_images']);
        });
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'front_image', 'room_images', 'facility_images']);
        });
        Schema::table('train_tickets', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'train_images', 'seat_images']);
        });
        Schema::table('flight_tickets', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'airline_logo', 'interior_images']);
        });
        Schema::table('bus_tickets', function (Blueprint $table) {
            $table->dropColumn(['gallery']);
        });
    }
};
