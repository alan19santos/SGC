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
         Schema::table('financial_transactions', function (Blueprint $table) {
            $table->foreignId('financial_status_id')->nullable()->constrained('financial_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->dropForeign(['financial_status_id']);
            $table->dropColumn('financial_status_id');
        });
    }
};
