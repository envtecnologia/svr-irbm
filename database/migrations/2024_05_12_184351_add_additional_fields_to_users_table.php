<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->before('created_at');
            $table->date('birthdate')->before('created_at');
            $table->string('phone')->nullable()->before('created_at');
            // Adicione mais campos conforme necessário
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cpf');
            $table->dropColumn('birthdate');
            $table->dropColumn('phone');
            // Remova os campos adicionados acima, se necessário
        });
    }
};
