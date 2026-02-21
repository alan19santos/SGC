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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->boolean('read')->default(false); // Indica se a notificação foi lida ou não
            $table->unsignedBigInteger('user_id'); // ID do usuário destinatário
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Define a chave estrangeira para a tabela de usuários
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
