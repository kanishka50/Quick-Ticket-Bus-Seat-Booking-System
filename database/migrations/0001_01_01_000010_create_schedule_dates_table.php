<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->date('departure_date');
            $table->integer('available_seats');
            $table->enum('status', ['scheduled', 'departed', 'completed', 'cancelled'])->default('scheduled');
            $table->dateTime('actual_departure_time')->nullable();
            $table->dateTime('actual_arrival_time')->nullable();
            $table->text('delay_reason')->nullable();
            $table->timestamps();

            $table->unique(['schedule_id', 'departure_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_dates');
    }
};
