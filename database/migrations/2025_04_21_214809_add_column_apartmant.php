<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //cria coluna
        Schema::table('apartment', function (Blueprint $table) {      
          
            $table->unsignedBigInteger('condominium_id')->nullable();
           
        });

        // Adiciona o valor desejado
        DB::table('apartment')->update(['condominium_id' => 1]);

        // não permitir nullo
        Schema::table('apartment', function (Blueprint $table) {
            $table->unsignedBigInteger('condominium_id')->nullable(false)->change();
        });

        //add chave fk
        Schema::table('apartment', function (Blueprint $table) {
            $table->foreign('condominium_id')->references('id')->on('condominium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartment', function (Blueprint $table) {
            $table->dropForeign(['condominium_id']);
            $table->dropColumn('condominium_id');
        });
    }
};
