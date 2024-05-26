@extends('templates.main')

@section('title', 'Nova Paróquia')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Paróquia</h2>
    </div>

    <form action="{{ request()->is('controle/paroquias/new') ? route('paroquias.create') : route('paroquias.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('controle/paroquias/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-8 mb-3">

                        <div class="row mt-2">

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cod_diocese_id" class="form-label">Tipo de Instituição<span class="required">*</span></label>
                                    <select class="form-select" id="cod_diocese_id" name="cod_diocese_id" value="{{ request()->is('controle/paroquias/new') ? '' : $dados->cod_diocese_id_id }}" required>
                                        @forelse($dioceses as $r)
                                            <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                        @empty
                                            <option>Nenhuma diocese cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="descricao" name="descricao"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->descricao }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->endereco }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="cep" class="form-control" id="cep" name="cep"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->cep }}">
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
                                <div class="col-8">
                                    <label for="site" class="form-label">Site</label>
                                    <input type="text" class="form-control" id="site" name="site"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->site }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="caixapostal" class="form-label">Caixa Postal</label>
                                    <input type="caixapostal" class="form-control" id="caixapostal" name="caixapostal"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->caixapostal }}">
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col">
                                    <label for="email" class="form-label">E-mail<span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->email }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="telefone1" class="form-label">Telefone¹<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="telefone1" name="telefone1"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->telefone1 }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="telefone2" class="form-label">Telefone²<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="telefone2" name="telefone2"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->telefone2 }}"
                                        required>
                                </div>

                                <div class="col-4">
                                    <label for="telefone3" class="form-label">Telefone³<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="telefone3" name="telefone3"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->telefone3 }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="paroco" class="form-label">Pároco<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="paroco" name="paroco"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->paroco }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="fundacao" class="form-label">Fundação<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="fundacao" name="fundacao"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->fundacao }}"
                                        >
                                </div>

                                <div class="col-6">
                                    <label for="encerramento" class="form-label">Encerramento<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="encerramento" name="encerramento"
                                        value="{{ request()->is('controle/paroquias/new') ? '' : $dados->encerramento }}"
                                        >
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ request()->is('controle/paroquias/new') ? '' : $dados->detalhes }}</textarea>
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
