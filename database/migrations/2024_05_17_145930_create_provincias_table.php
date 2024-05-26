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
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->string('codantigo')->nullable();
            $table->string('cod_cidade_id')->nullable();
            $table->string('descricao');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();
            $table->string('caixapostal')->nullable();
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('telefone3')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->string('email3')->nullable();
            $table->string('site')->nullable();
            $table->string('responsavel')->nullable();
            $table->date('fundacao')->nullable();
            $table->date('encerramento')->nullable();
            $table->string('protecao')->nullable();
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
        Schema::dropIfExists('provincias');
    }
};
