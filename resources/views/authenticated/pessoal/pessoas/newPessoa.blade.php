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

    <form action="{{ request()->is('pessoal/pessoas/new') ? route('pessoas.store') : route('pessoas.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-8 mb-3">

                        <div class="row mt-2">

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="cod_provincia_id" class="form-label">Província<span class="required">*</span></label>
                                    <select class="form-select" id="cod_provincia_id" name="cod_provincia_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($provincias as $provincia)
                                            <option value="{{ $provincia->id }}" {{ (old('cod_provincia_id', $dados->cod_provincia_id ?? '') == $provincia->id) ? 'selected' : '' }}>
                                                {{ $provincia->descricao }}
                                            </option>
                                        @empty
                                            <option value="">Nenhuma província disponível</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="cod_tipopessoa_id" class="form-label">Categoria<span class="required">*</span></label>
                                    <select class="form-select" id="cod_tipopessoa_id" name="cod_tipopessoa_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ (old('cod_tipopessoa_id', $dados->cod_tipopessoa_id ?? '') == $categoria->id) ? 'selected' : '' }}>
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
                                    <label for="cod_comunidade_id" class="form-label">Comunidade<span class="required">*</span></label>
                                    <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($comunidades as $comunidade)
                                            <option value="{{ $comunidade->id }}" {{ (old('cod_comunidade_id', $dados->cod_comunidade_id ?? '') == $comunidade->id) ? 'selected' : '' }}>
                                                {{ $comunidade->descricao }}
                                            </option>
                                        @empty
                                            <option value="">Nenhuma comunidade disponível</option>
                                        @endforelse
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
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="religiosa" class="form-label">Nome Religioso</label>
                                    <input type="text" class="form-control" id="religiosa" name="religiosa"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->religiosa }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->endereco }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="cep" class="form-control" id="cep" name="cep"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->cep }}">
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="cod_pais_id" class="form-label">País<span class="required">*</span></label>
                                    <select class="form-select" id="pais" name="pais" required>
                                        <option value="">Selecione o país</option>
                                        @forelse($paises as $pais)
                                            <option value="{{ $pais->id }}" {{ (old('pais', $dados->pais ?? '') == $pais->id) ? 'selected' : '' }}>
                                                {{ $pais->descricao }}
                                            </option>
                                        @empty
                                            <option value="">Nenhum país disponível</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="estado" class="form-label">Estado<span class="required">*</span></label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">Selecione o estado</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="cod_origem_id" class="form-label">Cidade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_origem_id" name="cod_origem_id" required>
                                        <option value="">Selecione a cidade</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Nacionalidade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a Nacionalidade</option>
                                    </select>
                                </div>


                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Raça<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a Raça</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Origem<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a Origem</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Grupo Sanguíneo<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a Sanguíneo</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Fator RH<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a cidade</option>
                                    </select>
                                </div>


                            </div>

                            <div class="row mt-2">

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">RG<span
                                            class="required">*</span></label>
                                            <input type="text" class="form-control" id="email1" name="email1"
                                            value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->email1 }}"
                                            required>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Órgão Expedidor <span
                                            class="required">*</span></label>
                                            <input type="text" class="form-control" id="email1" name="email1"
                                            value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->email1 }}"
                                            required>
                                </div>

                                <div class="col-4">
                                    <label for="cod_cidade_id" class="form-label">Data de Expedição	 <span
                                            class="required">*</span></label>
                                            <input type="text" class="form-control" id="email1" name="email1"
                                            value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->email1 }}"
                                            required>
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
                                    <label for="caixapostal" class="form-label">Título de Eleitor</label>
                                    <input type="caixapostal" class="form-control" id="caixapostal" name="caixapostal"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->caixapostal }}">
                                </div>


                                <div class="col-3">
                                    <label for="titulozona" class="form-label">Zona Eleitoral</label>
                                    <input type="text" class="form-control" id="titulozona" name="titulozona"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->titulozona }}">
                                </div>

                                <div class="col-3">
                                    <label for="titulosecao" class="form-label">Seção Eleitoral</label>
                                    <input type="text" class="form-control" id="titulosecao" name="titulosecao"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->titulosecao }}">
                                </div>
                            </div>



                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="habilitacaonumero" class="form-label">Habilitação</label>
                                    <input type="text" class="form-control" id="habilitacaonumero" name="habilitacaonumero"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaonumero }}"
                                        required>
                                </div>
                                <div class="col-4">
                                            <label for="telefone1" class="form-label">Órgão (Hab.)	</label>
                                            <input type="telefone1" class="form-control" id="telefone1" name="telefone1"
                                                value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->telefone1 }}">
                                </div>

                                <div class="col-2">
                                    <label for="habilitacaodata" class="form-label">Data (Hab.)</label>
                                    <input type="text" class="form-control" id="habilitacaodata" name="habilitacaodata"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaodata }}">
                                  </div>

                                  <div class="col-2">
                                    <label for="habilitacaocategoria" class="form-label">Categoria (Hab.)</label>
                                    <input type="text" class="form-control" id="habilitacaocategoria" name="habilitacaocategoria"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->habilitacaocategoria }}">
                                  </div>

                            </div>




                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="email" class="form-label">E-mail¹</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->email }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="telefone1" class="form-label">Telefone¹</label>
                                    <input type="text" class="form-control" id="telefone1" name="telefone1"
                                        value="{{ request()->is('pessoal/pessoas/new') ? '' : $dados->telefone1 }}">
                                </div>
                            </div>


                            <div class="row mt-4">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
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
            var cidadeSelect = document.getElementById('cod_cidade_id');

            function carregarEstados(pais_id, estado_id = null) {
                if (pais_id) {
                    fetch('/obter-estados/' + pais_id)
                        .then(response => response.json())
                        .then(data => {
                            estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                            data.forEach(estado => {
                                estadoSelect.innerHTML += '<option value="' + estado.id + '"' + (estado_id == estado.id ? ' selected' : '') + '>' + estado.descricao + '</option>';
                            });
                            // Carregar as cidades se houver um estado selecionado
                            if (estado_id) {
                                carregarCidades(estado_id, {{ old('cod_cidade_id', $dados->cod_cidade_id ?? 'null') }});
                            }
                        });
                } else {
                    estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                }
            }

            function carregarCidades(estado_id, cidade_id = null) {
                if (estado_id) {
                    fetch('/obter-cidades/' + estado_id)
                        .then(response => response.json())
                        .then(data => {
                            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
                            data.forEach(cidade => {
                                cidadeSelect.innerHTML += '<option value="' + cidade.id + '"' + (cidade_id == cidade.id ? ' selected' : '') + '>' + cidade.descricao + '</option>';
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
        });
    </script>



@endsection
