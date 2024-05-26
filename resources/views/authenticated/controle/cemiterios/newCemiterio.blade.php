@extends('templates.main')

@section('title', 'Novo Cemitério')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Cemitério</h2>
    </div>

    <form action="{{ request()->is('controle/cemiterios/new') ? route('cemiterios.create') : route('cemiterios.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-8 mb-3">

                        <div class="row mt-2">

                            <div class="col">
                                <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->descricao }}"
                                    required>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->endereco }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="cep" class="form-control" id="cep" name="cep"
                                        value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->cep }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="pais" class="form-label">País<span class="required">*</span></label>
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
                                    <label for="cod_cidade_id" class="form-label">Cidade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                        <option value="">Selecione a cidade</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="contato" class="form-label">Contato</label>
                                    <input class="form-control" id="contato"
                                        name="contato" value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->contato }}">
                                </div>

                                <div class="col-3">
                                    <label for="telefone1" class="form-label">Telefone¹</label>
                                    <input class="form-control" id="telefone1"
                                        name="telefone1" value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->telefone1 }}">
                                </div>

                                <div class="col-3">
                                    <label for="telefone2" class="form-label">Telefone²</label>
                                    <input class="form-control" id="telefone2"
                                        name="telefone2" value="{{ request()->is('controle/cemiterios/new') ? '' : $dados->telefone2 }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ request()->is('controle/cemiterios/new') ? '' : $dados->detalhes }}</textarea>
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
