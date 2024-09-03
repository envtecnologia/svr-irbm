@extends('templates.main')

@section('title', 'Atividades')

@section('content')

<div class="row d-flex justify-content-center g-3 mt-4">
    <div class="col-10">
        <div class="table-container">
            <table class="table table-hover table-bordered table-custom">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $pessoa->nome  }}</td>

                        </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>

<div class="row mt-5">

    <div class="col d-flex justify-content-center align-items-center">
        @php
            $previousUrl = url()->previous();
        @endphp

        <div class="me-4 mb-2">
            <a href="{{ str_contains($previousUrl, 'search/pessoas/atividades') ? route('pessoas.atividades') : $previousUrl }}"
                class="btn btn-secondary btn-sm">
                <i class="fas fa-fw fa-chevron-left"></i>
            </a>
        </div>
        <h2 class="text-center">Atividades ({{ $dados->total() }})</h2>
    </div>

</div>

    <form action="{{ route('searchArquivo') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    {{-- <div class="col-10">
                        <div class="row g-3 mt-1">

                            <div class="col">
                                <label for="cod_tipoarquivo_id" class="form-label">Tipo de Arquivo</label>
                                <select class="form-select" id="cod_tipoarquivo_id" name="cod_tipoarquivo_id">
                                    <option value="geral">Geral</option>
                                    @forelse($cod_tipoarquivo_id as $r)
                                    <option value="{{ $r->id }}" {{ old('cod_tipoarquivo_id', $searchCriteria['cod_tipoarquivo_id'] ?? '') == $r->id ? 'selected' : '' }}>
                                        {{ $r->descricao }}
                                    </option>
                                    @empty
                                        <option value="geral">Geral</option>
                                    @endforelse
                                </select>


                            </div>

                            <div
                                class="{{ request()->is('search/atividades') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/atividades'))
                                        <a class="btn btn-custom inter inter-title" href="/pessoal/pessoas/atividades">Limpar
                                            Pesquisa</a>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div> --}}


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
                            <th scope="col">Data Inicio</th>
                            <th scope="col">Data Final</th>
                            <th scope="col">Tipo de Atividade</th>
                            <th scope="col">Obra</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Localidade</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->situacao ? 'Ativo' : 'Concluído' }}</td>
                                <td>{{ $dado->datainicio ? \Carbon\Carbon::parse($dado->datainicio)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->datafinal ? \Carbon\Carbon::parse($dado->datafinal)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->tipo_atividade->descricao ?? '-' }}</td>
                                <td>{{ $dado->obra->descricao ?? '-' }}</td>
                                <td>{{ $dado->comunidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->localidade->descricao ?? '-' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('pessoas.atividades.edit', ['pessoa_id' => $pessoa_id, 'atividade' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('pessoas.atividades.destroy', ['pessoa_id' => $pessoa_id, 'atividade' => $dado->id]) }}" method="POST"
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
                    <a class="btn btn-custom inter inter-title" href="{{ route('pessoas.atividades.create', ['pessoa_id' => $pessoa_id,]) }}">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

    {{-- @if (Route::currentRouteName() === 'pessoas.atividades.index')
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
    @endif --}}

@endsection
