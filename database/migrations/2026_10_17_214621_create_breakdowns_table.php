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
        Schema::create('breakdowns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('vehicle_model_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('engine_variant_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');

            $table->text('description');

            $table->unsignedInteger('mileage')->nullable();

            $table->enum('status', [
                'open',
                'resolved'
            ])->default('open');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdowns');
    }
};
