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
        Schema::create('enderecos_obras', function (Blueprint $table) {
            $table->id();
            $table->string('cod_comunidade_id');
            $table->string('cod_provincia_id')->nullable();
            $table->string('cod_cidade_id')->nullable();
            $table->date('datainicio');
            $table->date('datafinal')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('situacao')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos_obras');
    }
};
