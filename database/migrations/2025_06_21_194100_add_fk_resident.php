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
        // Schema::table('resident', function (Blueprint $table) {


        //    $table->foreign('apartment_id')->references('id')->on('apartment');

        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('resident', function (Blueprint $table) {

        //     $table->dropColumn('apartment_id');
        // });
    }
};
