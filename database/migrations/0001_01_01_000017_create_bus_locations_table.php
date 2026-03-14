<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('schedule_date_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('location_name')->nullable();
            $table->decimal('speed', 5, 1)->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_locations');
    }
};
