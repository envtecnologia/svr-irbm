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
        Schema::create('cemiterios', function (Blueprint $table) {
            $table->id();
            $table->string('cod_cidade_id');
            $table->string('descricao');
            $table->string('endereco')->nullable();
            $table->string('cep')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->longText('detalhes')->nullable();
            $table->string('contato')->nullable();
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
        Schema::dropIfExists('cemiterios');
    }
};
