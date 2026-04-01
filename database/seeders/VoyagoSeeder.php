<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Partner;
use App\Models\Hotel;
use App\Models\WisataSpot;
use App\Models\FlightTicket;
use App\Models\TrainTicket;
use App\Models\BusTicket;
use App\Models\Category;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Enums\PartnerStatus;
use App\Enums\ProductStatus;

class VoyagoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        Category::updateOrCreate(['slug' => 'kereta'], ['name' => 'Kereta', 'icon' => 'train']);
        Category::updateOrCreate(['slug' => 'pesawat'], ['name' => 'Pesawat', 'icon' => 'flight']);
        Category::updateOrCreate(['slug' => 'bus'], ['name' => 'Bus', 'icon' => 'bus']);
        Category::updateOrCreate(['slug' => 'hotel'], ['name' => 'Hotel', 'icon' => 'hotel']);
        Category::updateOrCreate(['slug' => 'wisata'], ['name' => 'Wisata', 'icon' => 'wisata']);

        // 2. Admin (PLAIN TEXT PASSWORD as per project logic)
        User::updateOrCreate(['email' => 'admin@voyago.com'], [
            'name' => 'Admin Voyago',
            'password' => 'admin123',
            'role' => UserRole::ADMIN,
            'status' => UserStatus::ACTIVE,
        ]);

        // 3. Partners (PLAIN TEXT PASSWORD as per project logic)
        $partnersData = [
            ['email' => 'mitra@voyago.com', 'name' => 'Mitra Hospitality Group', 'type' => 'hotel'],
            ['email' => 'kai@voyago.com', 'name' => 'PT Kereta Api Persero', 'type' => 'kereta'],
            ['email' => 'garuda@voyago.com', 'name' => 'Garuda Indonesia Corp', 'type' => 'pesawat'],
            ['email' => 'damri@voyago.com', 'name' => 'DAMRI Transport', 'type' => 'bus'],
            ['email' => 'bali_tours@voyago.com', 'name' => 'Bali Nature Tours', 'type' => 'wisata'],
        ];

        foreach ($partnersData as $p) {
            $user = User::updateOrCreate(['email' => $p['email']], [
                'name' => $p['name'],
                'password' => 'mitra123',
                'role' => UserRole::PARTNER,
                'status' => UserStatus::ACTIVE,
            ]);

            Partner::updateOrCreate(['user_id' => $user->id], [
                'status' => PartnerStatus::VERIFIED,
                'commission_rate' => 10,
                'service_type' => $p['type'],
            ]);
        }

        $pId = User::where('email', 'mitra@voyago.com')->first()->id;
        $kaiId = User::where('email', 'kai@voyago.com')->first()->id;
        $garudaId = User::where('email', 'garuda@voyago.com')->first()->id;
        $rosaliaId = User::where('email', 'damri@voyago.com')->first()->id;
        $baliId = User::where('email', 'bali_tours@voyago.com')->first()->id;

        // 4. Products
        // Hotels
        Hotel::create([
            'name' => 'The St. Regis Bali Resort', 'location' => 'Nusa Dua, Bali', 'rating' => 5, 'price_per_night' => 8500000, 
            'room_type' => 'Ocean Suite', 'availability' => 5, 'user_id' => $pId, 'status' => ProductStatus::ACTIVE, 'is_active' => true,
        ]);

        // Train
        TrainTicket::create([
            'name' => 'Argo Bromo Anggrek Luxury', 'code' => 'ABA-01', 'origin' => 'Gambir (GMR)', 'destination' => 'Pasar Turi (SBI)',
            'departure_time' => now()->addDays(10), 'arrival_time' => now()->addDays(10)->addHours(8), 'duration' => '8j 0m',
            'class' => 'Luxury Sleeper', 'price' => 1200000, 'seats_available' => 18, 'user_id' => $kaiId, 'status' => ProductStatus::ACTIVE, 'is_active' => true,
        ]);

        // Flight
        FlightTicket::create([
            'airline_name' => 'Garuda Indonesia', 'flight_code' => 'GA-402', 'origin' => 'CGK', 'destination' => 'DPS',
            'departure_time' => now()->addDays(12), 'arrival_time' => now()->addDays(12)->addHours(2), 'duration' => '2j 0m',
            'baggage_info' => '20kg', 'price' => 1850000, 'seats_available' => 120, 'user_id' => $garudaId, 'status' => ProductStatus::ACTIVE, 'is_active' => true,
        ]);

        // Bus
        BusTicket::create([
            'operator' => 'Rosalia Indah Super Top', 'origin_terminal' => 'Bekasi', 'destination_terminal' => 'Yogyakarta',
            'departure_time' => now()->addDays(5)->setHour(19), 'arrival_time' => now()->addDays(6)->setHour(5), 'duration' => '10j 0m',
            'seat_type' => 'Executive', 'price' => 280000, 'seats_available' => 32, 'user_id' => $rosaliaId, 'status' => ProductStatus::ACTIVE, 'is_active' => true,
        ]);

        // Wisata
        WisataSpot::create([
            'name' => 'Tanah Lot Sunset Tour', 'category' => 'Culture', 'description' => 'Best sunset spot in Bali.', 'price' => 250000, 
            'availability' => 500, 'user_id' => $baliId, 'status' => ProductStatus::ACTIVE, 'is_active' => true,
        ]);
        
        // 5. Normal User
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => 'password',
            'role' => UserRole::USER,
            'status' => UserStatus::ACTIVE,
        ]);
    }
}
