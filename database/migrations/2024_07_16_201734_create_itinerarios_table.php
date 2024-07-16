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
        Schema::create('itinerarios', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_pessoa_id');
            $table->integer('cod_comunidade_atual_id')->nullable();
            $table->integer('cod_comunidade_anterior_id')->nullable();
            $table->integer('cod_comunidade_destino_id')->nullable();
            $table->date('chegada');
            $table->date('saida')->nullable();
            $table->longtext('detalhes')->nullable();
            $table->tinyInteger('situacao')->default(1);
            $table->string('endereco_atual')->nullable();
            $table->string('endereco_anterior')->nullable();
            $table->string('endereco_destino')->nullable();
            $table->string('cep_atual')->nullable();
            $table->string('cep_anterior')->nullable();
            $table->string('cep_destino')->nullable();
            $table->integer('cod_cidade_atual')->nullable();
            $table->integer('cod_cidade_anterior')->nullable();
            $table->integer('cod_cidade_destino')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerarios');
    }
};
