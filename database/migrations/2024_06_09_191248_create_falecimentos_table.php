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
        Schema::create('falecimentos', function (Blueprint $table) {
            $table->bigIncrements('codigo');
            $table->unsignedBigInteger('cod_pessoa');
            $table->unsignedBigInteger('cod_cemiterio');
            $table->unsignedBigInteger('cod_doenca1')->nullable();
            $table->unsignedBigInteger('cod_doenca2')->nullable();
            $table->unsignedBigInteger('cod_doenca3')->nullable();
            $table->string('jazigo', 20)->nullable();
            $table->date('datafalecimento');
            $table->string('certidaonumero', 100)->nullable();
            $table->date('certidaodata')->nullable();
            $table->string('certidaozona', 20)->nullable();
            $table->string('certidaolivro', 20)->nullable();
            $table->string('zona', 20)->nullable();
            $table->string('traslado', 3000)->nullable();
            $table->string('detalhes', 6000)->nullable();
            $table->tinyInteger('situacao')->default(1);
            $table->timestamps();

            $table->foreign('cod_pessoa')->references('id')->on('pessoas');
            $table->foreign('cod_cemiterio')->references('id')->on('cemiterios');
            $table->foreign('cod_doenca1')->references('id')->on('doencas');
            $table->foreign('cod_doenca2')->references('id')->on('doencas');
            $table->foreign('cod_doenca3')->references('id')->on('doencas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('falecimentos');
    }
};
