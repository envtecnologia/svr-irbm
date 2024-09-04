@extends('templates.main')

@section('title', 'Nova Comunidade')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/comunidades') ? route('comunidades') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if(request()->is('controle/comunidades/new'))
                    Nova
                @else
                    Editar
                @endif
                Comunidade</h2>

        </div>

    </div>

    <form
        action="{{ request()->is('controle/comunidades/new') ? route('comunidades.create') : route('comunidades.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('controle/comunidades/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-8 mb-3">

                        <div class="row mt-2">

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cod_provincia_id" class="form-label">Província<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_provincia_id" name="cod_provincia_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($provincias as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'controle.comunidades.edit' && $r->id == $dados->cod_provincia_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma província cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cod_diocese_id" class="form-label">Diocese<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_diocese_id" name="cod_diocese_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($dioceses as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'controle.comunidades.edit' && $r->id == $dados->cod_diocese_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma diocese cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">

                                <div class="col">
                                    <label for="cod_paroquia_id" class="form-label">Paróquia<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_paroquia_id" name="cod_paroquia_id" required>
                                        <option value="">Selecione...</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="cod_area_id" class="form-label">Áreas Pastorais<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_area_id" name="cod_area_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($areas as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'controle.comunidades.edit' && $r->id == $dados->cod_area_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>
                                        @empty
                                            <option>Nenhuma área cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="cod_setor_id" class="form-label">Setor Interno ICM<span
                                        class="required">*</span></label>
                                    <select class="form-select" id="cod_setor_id" name="cod_setor_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($setores as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'controle.comunidades.edit' && $r->id == $dados->cod_setor_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>
                                        @empty
                                            <option>Nenhuma setor cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="descricao" class="form-label">Descrição<span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="descricao" name="descricao"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->descricao }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->endereco }}"
                                        >
                                </div>

                                <div class="col-4">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="cep" class="form-control" id="cep" name="cep"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->cep }}">
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
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->site }}"
                                        >
                                </div>

                                <div class="col-4">
                                    <label for="caixapostal" class="form-label">Caixa Postal</label>
                                    <input type="caixapostal" class="form-control" id="caixapostal" name="caixapostal"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->caixapostal }}">
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="email1" class="form-label">E-mail¹</label>
                                    <input type="text" class="form-control" id="email1" name="email1"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->email1 }}"
                                        >
                                </div>

                                <div class="col-4">
                                    <label for="telefone1" class="form-label">Telefone¹</label>
                                    <input type="telefone1" class="form-control" id="telefone1" name="telefone1"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->telefone1 }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="email2" class="form-label">E-mail²</label>
                                    <input type="text" class="form-control" id="email2" name="email2"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->email2 }}"
                                        >
                                </div>

                                <div class="col-4">
                                    <label for="telefone2" class="form-label">Telefone²</label>
                                    <input type="telefone2" class="form-control" id="telefone2" name="telefone2"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->telefone2 }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-8">
                                    <label for="email3" class="form-label">E-mail³</label>
                                    <input type="text" class="form-control" id="email3" name="email3"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->email3 }}"
                                        >
                                </div>

                                <div class="col-4">
                                    <label for="telefone3" class="form-label">Telefone³</label>
                                    <input type="telefone3" class="form-control" id="telefone3" name="telefone3"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->telefone3 }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="fundacao" class="form-label">Fundação</label>
                                    <input type="date" class="form-control" id="fundacao" name="fundacao"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->fundacao }}">
                                </div>

                                <div class="col-6">
                                    <label for="encerramento" class="form-label">Encerramento</label>
                                    <input type="date" class="form-control" id="encerramento" name="encerramento"
                                        value="{{ request()->is('controle/comunidades/new') ? '' : $dados->encerramento }}">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ request()->is('controle/comunidades/new') ? '' : $dados->detalhes }}</textarea>
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col">
                                    <label for="foto1" class="form-label">Foto 1</label>
                                    <input class="form-control" type="file" id="foto1" name="foto1">
                                </div>

                                <div class="col">
                                    <label for="foto2" class="form-label">Foto 2</label>
                                    <input class="form-control" type="file" id="foto2" name="foto2">
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



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dioceseSelect = document.getElementById('cod_diocese_id');
            var paroquiaSelect = document.getElementById('cod_paroquia_id');

            function carregarParoquias(diocese_id, cod_paroquia_id = null) {
                if (diocese_id) {
                    fetch('/obter-paroquias/' + diocese_id)
                        .then(response => response.json())
                        .then(data => {
                            paroquiaSelect.innerHTML = '<option value="">Selecione a paróquia</option>';
                            data.forEach(cod_paroquia_id => {
                                paroquiaSelect.innerHTML += '<option value="' + cod_paroquia_id.id +
                                    '"' + (cod_paroquia_id == cod_paroquia_id.id ? ' selected' : '') +
                                    '>' + cod_paroquia_id.descricao + '</option>';
                            });
                        });
                } else {
                    paroquiaSelect.innerHTML = '<option value="">Selecione a Paróquia</option>';
                }
            }

            var diocese_id = {{ old('cod_diocese_id', $dados->cod_diocese_id ?? 'null') }};
            var cod_paroquia_id = {{ old('cod_paroquia_id', $dados->cod_paroquia_id ?? 'null') }};
            if (diocese_id) {
                carregarParoquias(diocese_id, cod_paroquia_id);
            }

            dioceseSelect.addEventListener('change', function() {
                carregarParoquias(this.value);
            });

        });
    </script>



@endsection
