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
        Schema::create('equipe_capitulos', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_capitulo_id');
            $table->integer('cod_pessoa_id');
            $table->tinyInteger('principal');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipe_capitulos');
    }
};
