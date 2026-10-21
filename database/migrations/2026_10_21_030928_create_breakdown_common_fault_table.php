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
        Schema::create('breakdown_common_fault', function (Blueprint $table) {
            $table->id();

            $table->foreignId('breakdown_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('common_fault_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'breakdown_id',
                'common_fault_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_common_fault');
    }
};
