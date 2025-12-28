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
        Schema::create('bank_account', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('branch_number');//numero agencia *
            $table->string('branch_digit_number');//digito agencia *
            $table->string('banck_name');//nome banco *
            $table->string('banck_accont_code');//codigo do banco
            $table->string('banck_account_digit');//digito da conta *
            $table->string('banck_account_number');//numero da conta *
            // $table->string('account_type');//tipo da conta
            $table->string('pix');
            $table->foreignId('people_id')->constrained('peoples');
            $table->foreignId('type_account_id')->constrained('type_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account');
    }
};
