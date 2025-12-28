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
        //
        Schema::table('space_reservation', function (Blueprint $table) {

             $table->unsignedBigInteger('status_reserve_id')->nullable();
            $table->foreign('status_reserve_id')->references('id')->on('status_reserve');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('space_reservation', function (Blueprint $table) {
            $table->dropColumn(['status_reserve_id']);

        });
    }
};
