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
        Schema::create('ocorrencias_medicas', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_pessoa_id');
            $table->integer('cod_doenca_id');
            $table->integer('cod_tipo_tratamento_id');
            $table->integer('cod_tipo_ocorrencia_id')->nullable();
            $table->date('datainicio');
            $table->date('datafinal')->nullable();
            $table->longText('detalhes')->nullable();
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
        Schema::dropIfExists('ocorrencias_medicas');
    }
};
