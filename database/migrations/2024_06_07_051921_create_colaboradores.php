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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->date('data_nascimento');
            $table->string('telefone');
            $table->string('email');
            $table->string('endereco');
            $table->string('municipio');
            $table->string('estado');
            $table->string('cargo_funcao');
            $table->string('setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
