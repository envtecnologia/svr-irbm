@extends('templates.main')

@section('title', 'Nova Pessoa')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/pessoas') ? route('pessoas') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (request()->is('pessoal/pessoas/new'))
                    Nova
                @else
                    Editar
                @endif
                Pessoa
            </h2>

        </div>

    </div>

    <!-- Abas (Tabs) -->
    <div class="row d-flex justify-content-center align-items-center">
        <ul class="nav nav-tabs mt-4 justify-content-center align-items-center" id="myTab" role="tablist">

            @if (isset($dados))
                <li class="nav-item" role="presentation">
                    <button class="nav-link  @if (isset($dados)) active @endif" id="apresentacao-tab"
                        data-bs-toggle="tab" data-bs-target="#apresentacao" type="button" role="tab"
                        aria-controls="apresentacao"
                        aria-selected="@if (!isset($dados)) true @else false @endif">Apresentação</button>
                </li>
            @endif

            <li class="nav-item" role="presentation">
                <button class="nav-link  @if (!isset($dados)) active @endif" id="pessoal-tab"
                    data-bs-toggle="tab" data-bs-target="#pessoal" type="button" role="tab" aria-controls="pessoal"
                    aria-selected="@if (!isset($dados)) false @else true @endif">Dados Principais</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="documentacao-tab" data-bs-toggle="tab" data-bs-target="#documentacao"
                    type="button" role="tab" aria-controls="documentacao" aria-selected="false">Documentação</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contato-tab" data-bs-toggle="tab" data-bs-target="#contato" type="button"
                    role="tab" aria-controls="contato" aria-selected="false">Contato</button>
            </li>
        </ul>
    </div>

    <form action="{{ request()->is('pessoal/pessoas/new') ? route('pessoas.store') : route('pessoas.update') }}"
        enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-2">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-8 mb-3">

                        <div class="row mt-2">


                            <div class="tab-content" id="myTabContent">

                                @if (isset($dados))
                                    <div class="tab-pane fade show  @if (isset($dados)) active @endif"
                                        id="apresentacao" role="tabpanel" aria-labelledby="apresentacao-tab">

                                        <div class="row">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 d-flex flex-row">
                                                            <img class="rounded border mx-4"
                                                                style="width: 180px; heigth: 180px; object-fit:contain;"
                                                                src="{{ $dados->foto ? asset('storage/uploads/pessoas/' . $dados->foto) : asset('storage/uploads/pessoas/fotos/foto.jpeg') }}">

                                                            <div id="informacoes">
                                                                <p class="my-1"><strong>Província:</strong>
                                                                    {{ $dados->provincia ? $dados->provincia->descricao : '-' }}</p>
                                                                <p class="my-1"><strong>Nome:</strong>
                                                                    {{ $dados->sobrenome }}, {{ $dados->nome }}</p>
                                                                <p class="my-1"><strong>Origem:</strong>
                                                                    {{ $dados->origem ? $dados->origem->descricao : '-' }}
                                                                    {{-- {{ $dados->local->estado->pais->descricao }},
                                                                    {{ $dados->local->descricao }}
                                                                    ({{ $dados->local->estado->sigla }}) --}}
                                                                </p>
                                                                <p class="my-1"><strong>Aniversário:</strong>
                                                                    {{ $dados->aniversario }}</p>
                                                                <p class="my-1"><strong>Tipo de sangue:</strong>
                                                                    {{ $dados->gruposanguineo }}{{ $dados->rh ? '+' : '-' }}
                                                                </p>
                                                                <p class="my-1"><strong>E-mail:</strong>
                                                                    {{ $dados->email }}</p>
                                                                <p class="my-1"><strong>Telefone(s):</strong>
                                                                    {{ $dados->telefone1 }} {{ $dados->telefone2 }}
                                                                    {{ $dados->telefone3 }}</p>
                                                                <p class="my-1"><strong>Aposentadoria:</strong>
                                                                    {{ $dados->aposentadoriadata ? 'Sim, desde ' . \Carbon\Carbon::parse($dados->aposentadoriadata)->format('d/m/Y') : 'Não' }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif



                                <div class="tab-pane fade show @if (!isset($dados)) active @endif"
                                    id="pessoal" role="tabpanel" aria-labelledby="pessoal-tab">

                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <label for="cod_provincia_id" class="form-label">Província<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_provincia_id" name="cod_provincia_id"
                                                required>
                                                <option value="">Selecione...</option>
                                                @forelse($provincias as $provincia)
                                                    <option value="{{ $provincia->id }}"
                                                        {{ old('cod_provincia_id', $dados->cod_provincia_id ?? '') == $provincia->id ? 'selected' : '' }}>
                                                        {{ $provincia->descricao }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma província disponível</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="cod_tipopessoa_id" class="form-label">Categoria<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_tipopessoa_id" name="cod_tipopessoa_id"
                                                required>
                                                <option value="">Selecione...</option>
                                                @forelse($categorias as $categoria)
                                                    <option value="{{ $categoria->id }}"
                                                        {{ old('cod_tipopessoa_id', $dados->cod_tipopessoa_id ?? '') == $categoria->id ? 'selected' : '' }}>
                                                        {{ $categoria->descricao }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma categoria disponível</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col">
                                            <label for="cod_comunidade_id" class="form-label">Comunidade<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id"

                                                @if(!request()->is('pessoal/pessoas/new'))
                                                    disabled
                                                @endif

                                                required>
                                                <option value="">Selecione...</option>

                                                @if(request()->is('pessoal/pessoas/new'))
                                                    @forelse($comunidades as $comunidade)
                                                        <option value="{{ $comunidade->id }}"
                                                            {{ old('cod_comunidade_id', $dados->cod_comunidade_id ?? '') == $comunidade->id ? 'selected' : '' }}>
                                                            {{ $comunidade->descricao }}
                                                        </option>
                                                    @empty
                                                        <option value="">Nenhuma comunidade disponível</option>
                                                    @endforelse
                                                @else
                                                        <option id="{{ $dados->comunidade->id }}" selected>{{ $dados->comunidade->descricao }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <label for="nome" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->nome }}"
                                                required>
                                        </div>

                                        <div class="col-4">
                                            <label for="sobrenome" class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->sobrenome }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <label for="opcao" class="form-label">Opção</label>
                                            <input type="text" class="form-control" id="opcao" name="opcao"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->opcao }}"
                                                >
                                        </div>

                                        <div class="col-4">
                                            <label for="religiosa" class="form-label">Nome Religioso</label>
                                            <input type="text" class="form-control" id="religiosa" name="religiosa"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->religiosa }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="pais" class="form-label">País de Nascimento<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="pais" name="pais" required>
                                                <option value="">Selecione...</option>
                                                @forelse($paises as $pais)
                                                    <option value="{{ $pais->id }}"
                                                        {{ old('pais', $dados->pais ?? '') == $pais->id ? 'selected' : '' }}>
                                                        {{ $pais->descricao }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhum país disponível</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="estado" class="form-label">Estado de Nascimento<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="estado" name="estado" required>
                                                <option value="">Selecione o estado</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="cod_local_id" class="form-label">Cidade de Nascimento<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_local_id" name="cod_local_id" required>
                                                <option value="">Selecione a cidade</option>
                                                @if (!request()->is('pessoal/pessoas/new'))
                                                    @foreach ($cidades as $cidade)
                                                        @if ($cidade->estado->id == $estado_id)
                                                            <option value="{{ $cidade->id }}"
                                                                {{ old('cod_local_id', $dados->cod_local_id ?? '') == $cidade->id ? 'selected' : '' }}>
                                                                {{ $cidade->descricao }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="cod_nacionalidade_id" class="form-label">Nacionalidade<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_nacionalidade_id"
                                                name="cod_nacionalidade_id">
                                                <option value="">Selecione...</option>
                                                @forelse($paises as $pais)
                                                    <option value="{{ $pais->id }}"
                                                        {{ old('cod_nacionalidade_id', $dados->cod_nacionalidade_id ?? '') == $pais->id ? 'selected' : '' }}>
                                                        {{ $pais->nacionalidade }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma nacionalidade disponível</option>
                                                @endforelse
                                            </select>
                                        </div>


                                        <div class="col-4">
                                            <label for="cod_raca_id" class="form-label">Raça<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_raca_id" name="cod_raca_id" >
                                                <option value="">Selecione...</option>
                                                @forelse($racas as $raca)
                                                    <option value="{{ $raca->id }}"
                                                        {{ old('cod_raca_id', $dados->cod_raca_id ?? '') == $raca->id ? 'selected' : '' }}>
                                                        {{ $raca->descricao }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma raça disponível</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="cod_origem_id" class="form-label">Origem<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="cod_origem_id" name="cod_origem_id" >
                                                <option value="">Selecione...</option>
                                                @forelse($origens as $origem)
                                                    <option value="{{ $origem->id }}"
                                                        {{ old('cod_origem_id', $dados->cod_origem_id ?? '') == $origem->id ? 'selected' : '' }}>
                                                        {{ $origem->descricao }}
                                                    </option>
                                                @empty
                                                    <option value="">Nenhuma origem disponível</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="gruposanguineo" class="form-label">Grupo Sanguíneo<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="gruposanguineo" name="gruposanguineo"
                                                >
                                                <option value="">Selecione a Sanguíneo</option>
                                                <option value="A" @if (($dados->gruposanguineo ?? '') == 'A') selected @endif>A
                                                </option>
                                                <option value="B" @if (($dados->gruposanguineo ?? '') == 'B') selected @endif>B
                                                </option>
                                                <option value="AB" @if (($dados->gruposanguineo ?? '') == 'AB') selected @endif>
                                                    AB
                                                </option>
                                                <option value="O" @if (($dados->gruposanguineo ?? '') == 'O') selected @endif>O
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <label for="rh" class="form-label">Fator RH<span
                                                    class="required">*</span></label>
                                            <select class="form-select" id="rh" name="rh" >
                                                <option value="">Selecione a cidade</option>
                                                <option value="1" @if (($dados->rh ?? '') == 1) selected @endif>
                                                    (+) Positivo</option>
                                                <option value="0" @if (($dados->rh ?? '') == 0) selected @endif>
                                                    (-) Negativo</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="foto">Escolha a Foto¹</label>
                                                <input type="file" class="form-control" id="foto" name="foto"
                                                    >
                                                <input type="hidden" name="foto_atual"
                                                    value="{{ isset($dados) ? $dados->foto : '' }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="tab-pane fade" id="documentacao" role="tabpanel"
                                    aria-labelledby="documentacao-tab">
                                    <div class="row mt-2">

                                        <div class="col-4">
                                            <label for="rg" class="form-label">RG<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="rg" name="rg"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->rg }}"
                                                >
                                            </div>

                                        <div class="col-4">
                                            <label for="rgorgao" class="form-label">Órgão Expedidor<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="rgorgao" name="rgorgao"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->rgorgao }}"
                                                >
                                        </div>

                                        <div class="col-4">
                                            <label for="rgdata" class="form-label">Data de Expedição<span
                                                    class="required">*</span></label>
                                            <input type="date" class="form-control" id="rgdata" name="rgdata"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->rgdata }}"
                                                >
                                        </div>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <label for="cpf" class="form-label">CPF<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="cpf" name="cpf"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->cpf }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="titulo" class="form-label">Título de Eleitor</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->titulo }}">
                                        </div>


                                        <div class="col-3">
                                            <label for="titulozona" class="form-label">Zona Eleitoral</label>
                                            <input type="text" class="form-control" id="titulozona" name="titulozona"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->titulozona }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="titulosecao" class="form-label">Seção Eleitoral</label>
                                            <input type="text" class="form-control" id="titulosecao"
                                                name="titulosecao"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->titulosecao }}">
                                        </div>
                                    </div>



                                    <div class="row mt-2">
                                        <div class="col-4">
                                            <label for="habilitacaonumero" class="form-label">Habilitação</label>
                                            <input type="text" class="form-control" id="habilitacaonumero"
                                                name="habilitacaonumero"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaonumero }}"
                                                >
                                        </div>
                                        <div class="col-3">
                                            <label for="habilitacaolocal" class="form-label">Órgão (Hab.) </label>
                                            <input type="text" class="form-control" id="habilitacaolocal"
                                                name="habilitacaolocal"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaolocal }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="habilitacaodata" class="form-label">Data (Hab.)</label>
                                            <input type="date" class="form-control" id="habilitacaodata"
                                                name="habilitacaodata"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaodata }}">
                                        </div>

                                        <div class="col-2">
                                            <label for="habilitacaocategoria" class="form-label">Categoria (Hab.)</label>
                                            <input type="text" class="form-control" id="habilitacaocategoria"
                                                name="habilitacaocategoria"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaocategoria }}">
                                        </div>

                                    </div>

                                    <div class="row mt-2">

                                        <div class="col-4">
                                            <label for="inss" class="form-label">INSS<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="inss" name="inss"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->inss }}"
                                                >
                                        </div>

                                        <div class="col-4">
                                            <label for="aposentadoriaorgao" class="form-label">Órgão Aposentadoria<span
                                                    class="required">*</span></label>
                                            <input type="text" class="form-control" id="aposentadoriaorgao"
                                                name="aposentadoriaorgao"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->aposentadoriaorgao }}"
                                                >
                                        </div>

                                        <div class="col-4">
                                            <label for="aposentadoriadata" class="form-label">Data Aposentadoria<span
                                                    class="required">*</span></label>
                                            <input type="date" class="form-control" id="aposentadoriadata"
                                                name="aposentadoriadata"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->aposentadoriadata }}"
                                                >
                                        </div>

                                    </div>
                                </div>






                                <div class="tab-pane fade" id="contato" role="tabpanel" aria-labelledby="contato-tab">

                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <label for="endereco" class="form-label">Endereço</label>
                                            <input type="text" class="form-control" id="endereco" name="endereco"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->endereco }}"
                                                >
                                        </div>

                                        <div class="col-4">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="cep" class="form-control" id="cep" name="cep"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->cep }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->email }}">
                                        </div>

                                        <div class="col-4">
                                            <label for="datanascimento" class="form-label">Data de Nascimento</label>
                                            <input type="date" class="form-control" id="datanascimento"
                                                name="datanascimento"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->datanascimento }}">
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <label for="aniversario" class="form-label">Aniversário</label>
                                            <input type="text" class="form-control" id="aniversario"
                                                name="aniversario" placeholder="dd/mm"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->aniversario }}"
                                                >
                                        </div>

                                        <div class="col-3">
                                            <label for="telefone1" class="form-label">Telefone¹</label>
                                            <input type="text" class="form-control" id="telefone1" name="telefone1"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->telefone1 }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="telefone2" class="form-label">Telefone²</label>
                                            <input type="text" class="form-control" id="telefone2" name="telefone2"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->telefone2 }}">
                                        </div>

                                        <div class="col-3">
                                            <label for="telefone3" class="form-label">Telefone³</label>
                                            <input type="text" class="form-control" id="telefone3" name="telefone3"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->telefone3 }}">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-8 mb-3">
                            <div class="row mt-4">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                                </div>
                            </div>
                        </div>

                    </div>




                </div>

            </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var paisSelect = document.getElementById('pais');
            var estadoSelect = document.getElementById('estado');
            var cidadeSelect = document.getElementById('cod_local_id');

            function carregarEstados(pais_id, estado_id = null) {
                if (pais_id) {
                    fetch('/obter-estados/' + pais_id)
                        .then(response => response.json())
                        .then(data => {
                            estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                            data.forEach(estado => {
                                estadoSelect.innerHTML += '<option value="' + estado.id + '"' + (
                                        estado_id == estado.id ? ' selected' : '') + '>' + estado
                                    .descricao + '</option>';
                            });
                            // Carregar as cidades se houver um estado selecionado
                            if (estado_id) {
                                carregarCidades(estado_id,
                                    {{ old('cod_local_id', $dados->cod_local_id ?? 'null') }});
                            }
                        });
                } else {
                    estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                }
            }



            function carregarPais(estado_id) {
                if (estado_id) {
                    fetch('/obter-pais/' + estado_id)
                        .then(response => response.json())
                        .then(data => {
                            var opcao = paisSelect.querySelector(`option[value="${data.id}"]`);
                            console.log(opcao)
                            opcao.selected = true;
                        });
                }
            }

            function carregarEstado(cidade_id) {
                if (cidade_id) {
                    fetch('/obter-estado/' + cidade_id)
                        .then(response => response.json())
                        .then(data => {
                            estadoSelect.innerHTML = `<option value="${data.id}">${data.descricao}</option>`;
                            console.log(opcao)
                            opcao.selected = true;
                            carregarPais(data.id);
                        });
                }

            }

            function carregarCidades(estado_id, cidade_id = null) {
                if (estado_id) {
                    fetch('/obter-cidades/' + estado_id)
                        .then(response => response.json())
                        .then(data => {
                            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
                            data.forEach(cidade => {
                                cidadeSelect.innerHTML += '<option value="' + cidade.id + '"' + (
                                        cidade_id == cidade.id ? ' selected' : '') + '>' + cidade
                                    .descricao + '</option>';
                            });
                        });
                } else {
                    cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
                }
            }

            // Carregar estados quando a página for carregada, se um país estiver selecionado
            var pais_id = {{ old('pais', $dados->pais ?? 'null') }};
            var estado_id = {{ old('estado', $dados->estado ?? 'null') }};
            if (pais_id) {
                carregarEstados(pais_id, estado_id);
            }

            // Adicionar evento para carregar estados quando o país for alterado
            paisSelect.addEventListener('change', function() {
                carregarEstados(this.value);
            });

            // Adicionar evento para carregar cidades quando o estado for alterado
            estadoSelect.addEventListener('change', function() {
                carregarCidades(this.value);
            });

            var cidadeValue = cidadeSelect.value;
            carregarEstado(cidadeValue);
        });
    </script>



@endsection
