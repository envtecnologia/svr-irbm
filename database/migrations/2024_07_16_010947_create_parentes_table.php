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
        Schema::create('parentes', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_pessoa_id');
            $table->integer('cod_parentesco_id');
            $table->integer('cod_cidade_id');
            $table->string('nome');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->tinyInteger('sexo');
            $table->date('datanascimento')->nullable();
            $table->date('datafalecimento')->nullable();
            $table->string('telefone1');
            $table->string('telefone2')->nullable();
            $table->string('telefone3')->nullable();
            $table->string('email')->nullable();
            $table->string('detalhes')->nullable();
            $table->tinyInteger('situacao')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parentes');
    }
};
