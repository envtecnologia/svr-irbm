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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('codantigo')->nullable();
            $table->integer('cod_tipo_obra_id');
            $table->integer('cod_provincia_id')->nullable();
            $table->integer('cod_setor_id')->nullable();
            $table->integer('cod_cidade_id')->nullable();
            $table->integer('cod_banco_id')->nullable();
            $table->string('cnpj')->nullable();
            $table->longText('descricao');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('caixapostal')->nullable();
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('telefone3')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->date('fundacao')->nullable();
            $table->date('encerramento')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();
            $table->longText('detalhes')->nullable();
            $table->tinyInteger('situacao')->default(1);
            $table->string('foto')->nullable();
            $table->string('foto2')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
