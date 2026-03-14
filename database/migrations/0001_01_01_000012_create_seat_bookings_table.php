<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seat_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('seat_number');
            $table->string('ticket_number')->unique();
            $table->timestamps();

            $table->unique(['booking_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_bookings');
    }
};
