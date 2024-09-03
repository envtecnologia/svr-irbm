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
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_pessoa_id');
            $table->integer('cod_tipoatividade_id');
            $table->integer('cod_obra_id')->nullable();
            $table->integer('cod_comunidade_id')->nullable();
            $table->integer('cod_cidade_id')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->date('datainicio');
            $table->date('datafinal')->nullable();
            $table->string('responsavel')->nullable();
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
        Schema::dropIfExists('atividades');
    }
};
