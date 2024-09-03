@extends('templates.main')

@section('title', 'Cursos')

@section('content')

<div class="row mt-5">

    <div class="col d-flex justify-content-center align-items-center">
        @php
            $previousUrl = url()->previous();
        @endphp

        <div class="me-4 mb-2">
            <a href="{{ str_contains($previousUrl, 'search/pessoas/cursos') ? route('pessoas.cursos.index', ["pessoa_id" => $pessoa_id]) : $previousUrl }}"
                class="btn btn-secondary btn-sm">
                <i class="fas fa-fw fa-chevron-left"></i>
            </a>
        </div>
        <h2 class="text-center">Cursos ({{ $dados->total() }})</h2>
    </div>

</div>

    <form action="{{ route('searchCurso') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-3">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero"
                                    value="{{ old('numero', $searchCriteria['numero'] ?? '') }}">
                            </div>

                            <div class="col-3">
                                <label for="data_inicio" class="form-label">Data de Ínicio</label>
                                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                    value="{{ old('data_inicio', $searchCriteria['data_inicio'] ?? '') }}">
                            </div>

                            <div class="col-3">
                                <label for="data_fim" class="form-label">Data de Final</label>
                                <input type="date" class="form-control" id="data_fim" name="data_fim"
                                    value="{{ old('data_fim', $searchCriteria['data_fim'] ?? '') }}">
                            </div>

                        </div>

                        <div class="row g-3 mt-1">

                            <div class="col">
                                <label for="provincia" class="form-label">Províncias</label>
                                <select class="form-select" id="cod_provincia_id" name="cod_provincia_id">
                                    <option value="geral">Geral</option>
                                    @forelse($provincias as $r)
                                    <option value="{{ $r->id }}" {{ old('cod_provincia_id', $searchCriteria['cod_provincia_id'] ?? '') == $r->id ? 'selected' : '' }}>
                                        {{ $r->descricao }}
                                    </option>
                                    @empty
                                        <option value="geral">Geral</option>
                                    @endforelse
                                </select>


                            </div>

                            <div
                                class="{{ request()->is('search/capitulos') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/capitulos'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/capitulos">Limpar
                                            Pesquisa</a>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>


                </div>



            </div>

        </div>

        </div>
    </form>

    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Data Início</th>
                            <th scope="col">Data Final</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->situacao ? 'Concluído' : 'Em andamento' }}</td>
                                <td>{{ $dado->datainicio ? \Carbon\Carbon::parse($dado->datainicio)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->datafinal ? \Carbon\Carbon::parse($dado->datafinal)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->descricao ?? '-' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('capitulos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('capitulos.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Nenhum registro encontrado!</td>
                            </tr>
                        @endforelse
                    </tbody>
                                </table>

                                <!-- Links de paginação -->
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        {{ $dados->links() }}
                                    </div>
                                </div>

                <div class="mb-2">
                    <a class="btn btn-custom inter inter-title" href="{{ route('capitulos.new') }}">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

    @if (Route::currentRouteName() === 'pessoas.cursos.index')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Obtém a data atual
                var today = new Date();
                var day = String(today.getDate()).padStart(2, '0');
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
                var year = today.getFullYear();

                // Formata a data no padrão YYYY-MM-DD
                var currentDate = year + '-' + month + '-' + day;
                var oldDate = (year-1) + '-' + month + '-' + day;


                // Define o valor padrão dos campos de data
                document.getElementById('data_inicio').value = oldDate;
                document.getElementById('data_fim').value = currentDate;
            });
        </script>
    @endif

@endsection
