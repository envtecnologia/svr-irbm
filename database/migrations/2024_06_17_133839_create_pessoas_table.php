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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->integer('codantigo')->nullable();
            $table->integer('cod_tipopessoa_id')->nullable(false);
            $table->integer('cod_provincia_id')->nullable(false);
            $table->integer('cod_comunidade_id')->nullable();
            $table->integer('cod_nacionalidade_id')->nullable()->comment('Relativo à nacionalidade');
            $table->integer('cod_origem_id')->nullable();
            $table->integer('cod_raca_id')->nullable();
            $table->integer('cod_profissao_id')->nullable();
            $table->integer('cod_escolaridade_id')->nullable();
            $table->integer('cod_usuario_id')->nullable();
            $table->integer('cod_local_id')->nullable(false)->comment('Cidade');
            $table->string('nome', 100)->nullable(false);
            $table->string('sobrenome', 100)->nullable(false);
            $table->string('opcao', 150)->nullable()->comment('Nome religiosa');
            $table->string('religiosa', 150)->nullable();
            $table->date('datanascimento')->nullable();
            $table->string('aniversario', 5)->nullable();
            $table->boolean('rh')->default(1);
            $table->string('gruposanguineo', 3)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('foto', 250)->nullable();
            $table->string('rg', 20)->nullable();
            $table->date('rgdata')->nullable();
            $table->string('rgorgao', 80)->nullable();
            $table->string('inscricaonumero', 20)->nullable();
            $table->date('inscricaodata')->nullable();
            $table->string('inscricaoorgao', 80)->nullable();
            $table->string('cpf', 14)->nullable(false);
            $table->string('titulo', 20)->nullable();
            $table->string('titulozona', 10)->nullable();
            $table->string('titulosecao', 20)->nullable();
            $table->string('habilitacaonumero', 10)->nullable();
            $table->date('habilitacaodata')->nullable();
            $table->string('habilitacaocategoria', 20)->nullable();
            $table->string('habilitacaolocal', 100)->nullable();
            $table->string('ctps', 20)->nullable();
            $table->string('passaporte', 20)->nullable();
            $table->string('ctpsserie', 10)->nullable();
            $table->string('secretaria', 20)->nullable();
            $table->string('pis', 20)->nullable();
            $table->string('inss', 20)->nullable();
            $table->date('aposentadoriadata')->nullable();
            $table->string('aposentadoriaorgao', 100)->nullable();
            $table->string('endereco', 300)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('telefone1', 16)->nullable();
            $table->string('telefone2', 16)->nullable();
            $table->string('telefone3', 16)->nullable();
            $table->date('datacadastro')->nullable(false);
            $table->string('horacadastro', 5)->nullable(false);
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
        Schema::dropIfExists('pessoas');
    }
};
