<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planning_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('planning');
            $table->timestamps();
        });

        Schema::create('planning_room_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role')->default('member'); // creator, member
            $table->timestamps();
        });

        Schema::create('planning_room_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_room_id')->constrained()->onDelete('cascade');
            $table->string('category'); // transport, hotel, wisata
            $table->unsignedBigInteger('product_id')->nullable(); // linked to train_tickets, flight_tickets etc
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('image')->nullable();
            $table->string('date_info')->nullable();
            $table->string('optional_stats')->nullable(); // duration or rating
            $table->timestamps();
        });

        Schema::create('planning_room_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_room_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['up', 'down']);
            $table->timestamps();
            $table->unique(['planning_room_item_id', 'user_id']);
        });

        Schema::create('planning_room_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planning_room_comments');
        Schema::dropIfExists('planning_room_votes');
        Schema::dropIfExists('planning_room_items');
        Schema::dropIfExists('planning_room_members');
        Schema::dropIfExists('planning_rooms');
    }
};
