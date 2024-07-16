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
        Schema::create('egressos', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_pessoa');
            $table->date('data_saida');
            $table->date('data_readmissao')->nullable();
            $table->string('detalhes', 3000)->nullable();
            $table->boolean('situacao')->default(1);
            $table->softDeletes();
            $table->timestamps();
            // Indexes
            $table->index('cod_pessoa');
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egressos');
    }
};
