<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_date_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['assigned', 'active', 'completed'])->default('assigned');
            $table->timestamps();

            $table->unique(['driver_id', 'schedule_date_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_assignments');
    }
};
