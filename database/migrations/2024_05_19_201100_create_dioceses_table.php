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
        Schema::create('dioceses', function (Blueprint $table) {
            $table->id();
            $table->string('codantigo')->nullable();
            $table->string('cod_cidade_id');
            $table->string('pais')->nullable();
            $table->string('estado')->nullable();
            $table->string('descricao');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('telefone3')->nullable();
            $table->string('caixapostal')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->date('fundacao')->nullable();
            $table->date('encerramento')->nullable();
            $table->string('bispo')->nullable();
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
        Schema::dropIfExists('dioceses');
    }
};
