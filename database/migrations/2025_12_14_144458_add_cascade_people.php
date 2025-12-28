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
         Schema::table('drive_people', function (Blueprint $table) {

            // Remove as FKs antigas
            $table->dropForeign(['people_id']);
            $table->dropForeign(['drive_id']);

            // Recria com cascade
            $table->foreign('people_id')
                  ->references('id')
                  ->on('peoples')
                  ->onDelete('cascade');

            $table->foreign('drive_id')
                  ->references('id')
                  ->on('drive')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('drive_people', function (Blueprint $table) {

            $table->dropForeign(['people_id']);
            $table->dropForeign(['drive_id']);

            // Volta sem cascade
            $table->foreign('people_id')
                  ->references('id')
                  ->on('peoples');

            $table->foreign('drive_id')
                  ->references('id')
                  ->on('drive');
        });
    }
};
