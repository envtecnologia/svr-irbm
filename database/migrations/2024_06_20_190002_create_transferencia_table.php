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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cod_pessoa');
            $table->unsignedBigInteger('cod_provinciaori');
            $table->unsignedBigInteger('cod_comunidadeori');
            $table->unsignedBigInteger('cod_provinciades');
            $table->unsignedBigInteger('cod_comunidadedes');
            $table->date('data_transferencia');
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
        Schema::dropIfExists('transferencia');
    }
};
