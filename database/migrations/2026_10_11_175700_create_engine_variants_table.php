<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engine_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_generation_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('name');
            $table->string('engine_code')->nullable();
            $table->string('fuel_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_variants');
    }
};
