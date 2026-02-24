<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Enums\PartnerStatus;
use App\Enums\ProductStatus;

class VoyagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Users & Partners
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin Voyago',
            'email' => 'admin@voyago.com',
            'password' => 'admin123',
            'role' => UserRole::ADMIN->value,
            'status' => UserStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $partnerId = DB::table('users')->insertGetId([
            'name' => 'Mitra Utama',
            'email' => 'mitra@voyago.com',
            'password' => 'mitra123',
            'role' => UserRole::PARTNER->value,
            'status' => UserStatus::ACTIVE->value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('partners')->insert([
            'user_id' => $partnerId,
            'status' => PartnerStatus::VERIFIED->value,
            'commission_rate' => 10.00,
            'service_type' => 'transport',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Categories
        $categories = [
            ['name' => 'Kereta', 'icon' => 'train', 'slug' => 'kereta'],
            ['name' => 'Pesawat', 'icon' => 'flight', 'slug' => 'pesawat'],
            ['name' => 'Bus', 'icon' => 'bus', 'slug' => 'bus'],
            ['name' => 'Hotel', 'icon' => 'hotel', 'slug' => 'hotel'],
            ['name' => 'Wisata', 'icon' => 'wisata', 'slug' => 'wisata'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(['slug' => $cat['slug']], $cat);
        }

        // 3. Train Tickets
        DB::table('train_tickets')->insert([
            [
                'name' => 'Gajahwong',
                'code' => '106',
                'origin' => 'Pasar Senen (PSE)',
                'destination' => 'Lempuyangan (LPN)',
                'departure_time' => '2026-06-12 07:55:00',
                'arrival_time' => '2026-06-12 15:50:00',
                'duration' => '7j 55m',
                'class' => 'Ekonomi (cc)',
                'price' => 350000,
                'seats_available' => 50,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ],
            [
                'name' => 'Taksaka',
                'code' => '82',
                'origin' => 'Gambir (GMR)',
                'destination' => 'Yogyakarta (YK)',
                'departure_time' => '2026-06-12 09:00:00',
                'arrival_time' => '2026-06-12 15:10:00',
                'duration' => '6j 10m',
                'class' => 'Eksekutif',
                'price' => 650000,
                'seats_available' => 42,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ]
        ]);

        // 4. Flight Tickets
        DB::table('flight_tickets')->insert([
            [
                'airline_name' => 'Garuda Indonesia',
                'flight_code' => 'GA-123',
                'origin' => 'CGK',
                'destination' => 'DPS',
                'departure_time' => '2026-06-13 10:00:00',
                'arrival_time' => '2026-06-13 12:45:00',
                'duration' => '2j 45m',
                'baggage_info' => '20kg',
                'price' => 1200000,
                'seats_available' => 120,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ]
        ]);

        // 5. Bus Tickets
        DB::table('bus_tickets')->insert([
            [
                'operator' => 'Rosalia Indah',
                'origin_terminal' => 'Pulo Gebang',
                'destination_terminal' => 'Solo',
                'departure_time' => '2026-06-14 19:00:00',
                'seat_type' => 'Executive',
                'price' => 250000,
                'seats_available' => 30,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ]
        ]);

        // 6. Hotels
        DB::table('hotels')->insert([
            [
                'name' => 'The Ritz-Carlton Jakarta',
                'location' => 'Mega Kuningan, Jakarta',
                'rating' => 4.9,
                'price_per_night' => 3500000,
                'room_type' => 'Deluxe King',
                'availability' => 5,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ]
        ]);

        // 7. Wisata
        DB::table('wisata_spots')->insert([
            [
                'name' => 'Borobudur Temple',
                'category' => 'History',
                'open_hours' => '08:00 - 16:00',
                'price' => 50000,
                'description' => 'World largest Buddhist temple.',
                'availability' => 1000,
                'is_active' => true,
                'status' => ProductStatus::ACTIVE->value,
                'user_id' => $partnerId,
            ]
        ]);
    }
}
