@extends('templates.main')

@section('title', 'Nova Formação')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/pessoas/formacoes') ? route('pessoas.formacoes.index') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (Route::currentRouteName() == 'pessoas.formacoes.create')
                    Nova
                @else
                    Editar
                @endif
                Formação
            </h2>

        </div>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ Route::currentRouteName() === 'pessoas.formacoes.edit' ? route('pessoas.formacoes.update', ['pessoa_id' => $pessoa_id, 'formaco' => $formaco]) : route('pessoas.formacoes.store') }}"
        method="POST">
        @csrf

        @if (Route::currentRouteName() === 'pessoas.formacoes.edit')
            @method('PUT')
        @endif

        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">

                    <div class="col-6 mb-3">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cod_tipo_formacao_id" class="form-label">Tipo de Formação<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipo_formacao_id" name="cod_tipo_formacao_id"
                                        required>
                                        <option value="">Selecione...</option>
                                        @forelse($tipos_formacoes as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'pessoas.formacoes.edit' && $r->id == $dados->cod_tipo_formacao_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma formação cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row rounded p-2 mb-3">

                            <label for="cod_comunidade_id" class="form-label">Comunidade<span
                                    class="required">*</span></label>
                            <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id" required>
                                <option value="">Selecione...</option>
                                @forelse($comunidades as $r)
                                    <option value="{{ $r->id }}" @if (Route::currentRouteName() === 'pessoas.formacoes.edit' && $r->id == $dados->cod_comunidade_id) selected @endif>
                                        {{ $r->descricao }}
                                    </option>

                                @empty
                                    <option>Nenhuma comunidade cadastrada</option>
                                @endforelse
                            </select>

                        </div>

                        <div class="row mt-2">

                            <div class="col-6">
                                <label for="data" class="form-label">Data<span class="required">*</span></label>
                                <input type="date" id="data" name="data" class="form-control"
                                    value="{{ Route::currentRouteName() === 'pessoas.formacoes.edit' ? $dados->data : '' }}">
                            </div>

                            <div class="col-6">
                                <label for="prazo" class="form-label">Prazo</label>
                                <input type="text" id="prazo" name="prazo" class="form-control"
                                    value="{{ Route::currentRouteName() === 'pessoas.formacoes.edit' ? $dados->prazo : '' }}">
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="pais" class="form-label">País<span class="required">*</span></label>
                                <select class="form-select" id="pais" name="pais" required>
                                    <option value="">Selecione o país</option>
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
                                <label for="estado" class="form-label">Estado<span class="required">*</span></label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="">Selecione o estado</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="cod_cidade_id" class="form-label">Cidade<span class="required">*</span></label>
                                <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                    <option value="">Selecione a cidade</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-12">
                                <input value="{{ $pessoa_id }}" name="cod_pessoa_id" hidden>

                                <label for="detalhes" class="form-label">Detalhes<span class="required">*</span></label>
                                <textarea type="text" class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.formacoes.edit' ? $dados->detalhes : '' }}</textarea>
                            </div>
                        </div>



                        <div class="row mt-2">
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
            var cidadeSelect = document.getElementById('cod_cidade_id');

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
                                    {{ old('cod_cidade_id', $dados->cod_cidade_id ?? 'null') }});
                            }
                        });
                } else {
                    estadoSelect.innerHTML = '<option value="">Selecione o estado</option>';
                    cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
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

            // Carregar estados e cidades quando a página for carregada, se um país estiver selecionado
            var pais_id = {{ old('pais', $dados->pais->id ?? 'null') }};
            var estado_id = {{ old('estado', $dados->estado->id ?? 'null') }};
            var cidade_id = {{ old('cod_cidade_id', $dados->cod_cidade_id ?? 'null') }};

            if (pais_id) {
                carregarEstados(pais_id, estado_id);
            } else {
                cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
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
