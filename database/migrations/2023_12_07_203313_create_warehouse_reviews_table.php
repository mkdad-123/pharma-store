<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('warehouse_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('pharmacist_id')->constrained('pharmacists')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedTinyInteger('rate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_reviews');
    }
};
