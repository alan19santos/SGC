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
        Schema::create('service_provider', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unity_name');
            $table->date('date');
            $table->string('unity_tower');
            $table->string('rg');
            $table->string('drive')->nullable();
            $table->string('plate')->nullable();
            $table->string('entry_time');
            $table->string('departure_time')->nullable();
            $table->string('concierge_visa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_provider');
    }
};
