<?php

namespace Tests\Feature;

use App\Enums\PartnerStatus;
use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Hotel;
use App\Models\Partner;
use App\Models\User;
use App\Models\WisataSpot;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PartnerProductAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending');
            $table->string('service_type')->nullable();
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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
        });

        Schema::create('wisata_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('open_hours')->nullable();
            $table->decimal('price', 15, 2);
            $table->text('description');
            $table->integer('availability');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('spot_images')->nullable();
            $table->json('package_images')->nullable();
            $table->timestamps();
        });

        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->json('gallery')->nullable();
            $table->json('interior_images')->nullable();
            $table->timestamps();
        });

        Schema::create('train_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->json('gallery')->nullable();
            $table->json('train_images')->nullable();
            $table->json('seat_images')->nullable();
            $table->timestamps();
        });

        Schema::create('bus_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_active')->default(true);
            $table->json('gallery')->nullable();
            $table->timestamps();
        });
    }

    public function test_partner_can_open_owned_edit_page_even_if_service_type_points_to_another_table(): void
    {
        $partner = User::factory()->create([
            'role' => UserRole::PARTNER,
            'status' => UserStatus::ACTIVE,
        ]);

        Partner::create([
            'user_id' => $partner->id,
            'status' => PartnerStatus::VERIFIED,
            'service_type' => 'Hotel',
        ]);

        $otherPartner = User::factory()->create([
            'role' => UserRole::PARTNER,
            'status' => UserStatus::ACTIVE,
        ]);

        Partner::create([
            'user_id' => $otherPartner->id,
            'status' => PartnerStatus::VERIFIED,
            'service_type' => 'Hotel',
        ]);

        Hotel::create([
            'name' => 'Hotel Milik Orang Lain',
            'location' => 'Bandung',
            'rating' => 4.5,
            'price_per_night' => 450000,
            'room_type' => 'Deluxe',
            'availability' => 5,
            'user_id' => $otherPartner->id,
            'status' => ProductStatus::ACTIVE,
            'is_active' => true,
        ]);

        $ownedProduct = WisataSpot::create([
            'name' => 'Tanah Lot',
            'category' => 'Wisata',
            'open_hours' => '08:00 - 17:00',
            'price' => 75000,
            'description' => 'Produk milik partner yang sedang login.',
            'availability' => 15,
            'user_id' => $partner->id,
            'status' => ProductStatus::ACTIVE,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($partner)
            ->get(route('partner.products.edit', $ownedProduct->id));

        $response->assertOk();
        $response->assertSee('Tanah Lot');
    }
}
