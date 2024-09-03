@extends('templates.main')

@section('title', 'Novo Parentesco')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Parentesco</h2>
    </div>

    <form action="{{ request()->is('cadastros/parentescos/new') ? route('parentescos.create') : route('parentescos.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">

                    <div class="col-6 mb-3">
                        <input value="{{ request()->is('cadastros/parentescos/new') ? '' : $dados->id }}" name="id" hidden>
                         <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ request()->is('cadastros/parentescos/new') ? '' : $dados->descricao }}" required>

                        <div class="row mt-2">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>

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
