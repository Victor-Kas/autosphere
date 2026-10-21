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
        Schema::create('common_faults', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_model_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('engine_variant_id')
                ->nullable()
                ->constrained()
                ->restrictOnDelete();

            $table->string('title');

            $table->text('symptoms');

            $table->text('possible_causes')->nullable();

            $table->text('recommended_repair')->nullable();

            $table->enum('verification_status', [
                'unverified',
                'community_confirmed',
                'manufacturer_verified',
            ])->default('unverified');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_faults');
    }
};
