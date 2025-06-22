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
        // Schema::table('space_reservation', function (Blueprint $table) {


        //     $table->foreignId('type_occurrence_id')->constrained('type_occurrence')->nullable();

        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('space_reservation', function (Blueprint $table) {

        //     $table->dropColumn('type_occurrence_id');
        // });
    }
};
