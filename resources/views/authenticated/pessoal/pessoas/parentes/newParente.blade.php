@extends('templates.main')

@section('title', 'Novo Parente')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Parente</h2>
    </div>
    <form
    action="{{ Route::currentRouteName() === 'pessoas.parentes.edit'
                ? route('pessoas.parentes.update', ['pessoa_id' => $pessoa_id, 'parente' => $parente])
                : route('pessoas.parentes.store', ['pessoa_id' => $pessoa_id]) }}"
    method="POST">
    @csrf

    @if (Route::currentRouteName() === 'pessoas.parentes.edit')
        @method('PUT')
    @endif
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">
                <div class="row d-flex justify-content-center g-3">
                    {{-- <input value="{{ request()->is('controle/capitulos/new') ? '' : $dados->id }}" name="id" hidden> --}}

                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="cod_parentesco_id" class="form-label">Parentesco<span class="required">*</span></label>
                            <select class="form-select" id="cod_parentesco_id" name="cod_parentesco_id" required>
                                <option value="">Selecione...</option>
                                @foreach($parentescos as $parentesco)
                                <option value="{{ $parentesco->id }}"
                                    @if (Route::currentRouteName() === 'pessoas.parentes.edit' && $parentesco->id == $parente->cod_parentesco_id)
                                        selected
                                    @endif>
                                    {{ $parentesco->descricao }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="nome" class="form-label">Nome do Familiar<span class="required">*</span></label>
                            <input type="text" id="nome" name="nome" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->nome : '' }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-8">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->endereco : '' }}">
                        </div>
                        <div class="col-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->cep : '' }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="pais" class="form-label">País<span class="required">*</span></label>
                            <select class="form-select" id="pais" name="pais" required>
                                <option value="">Selecione o país</option>
                                @forelse($paises as $pais)
                                    <option value="{{ $pais->id }}" {{ old('pais', $dados->pais ?? '') == $pais->id ? 'selected' : '' }}>
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
                        <div class="col-3">
                            <label for="telefone1" class="form-label">Telefone 1<span class="required">*</span></label>
                            <input type="text" id="telefone1" name="telefone1" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->telefone1 : '' }}">
                        </div>
                        <div class="col-3">
                            <label for="telefone2" class="form-label">Telefone 2</label>
                            <input type="text" id="telefone2" name="telefone2" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->telefone2 : '' }}">
                        </div>
                        <div class="col-3">
                            <label for="telefone3" class="form-label">Telefone 3</label>
                            <input type="text" id="telefone3" name="telefone3" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->telefone3 : '' }}">
                        </div>
                        <div class="col-3">
                            <label for="datanascimento" class="form-label">Data Nascimento<span class="required">*</span></label>
                            <input type="date" id="datanascimento" name="datanascimento" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->datanascimento : '' }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->email : '' }}">
                        </div>
                        <div class="col-4">
                            <label for="sexo" class="form-label">Sexo<span class="required">*</span></label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="">Selecione o sexo</option>
                                <option value="1" {{ old('sexo', $dados->sexo ?? '') == '1' ? 'selected' : '' }}>Masculino</option>
                                <option value="2" {{ old('sexo', $dados->sexo ?? '') == '2' ? 'selected' : '' }}>Feminino</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="datafalecimento" class="form-label">Data Falecimento</label>
                            <input type="date" id="datafalecimento" name="datafalecimento" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->datafalecimento : '' }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <input value="{{ $pessoa_id }}" name="cod_pessoa_id" hidden>
                            <label for="detalhes" class="form-label">Detalhes</label>
                            <textarea type="text" class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.parentes.edit' ? $dados->detalhes : '' }}</textarea>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-center">
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
