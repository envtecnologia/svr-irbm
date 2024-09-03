@extends('templates.main')

@section('title', 'Formações')

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
            <a href="{{ str_contains($previousUrl, 'search/pessoas/formacoes') ? route('pessoas.formacoes') : $previousUrl }}"
                class="btn btn-secondary btn-sm">
                <i class="fas fa-fw fa-chevron-left"></i>
            </a>
        </div>
        <h2 class="text-center">Formações ({{ $dados->total() }})</h2>
    </div>

</div>


    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Início</th>
                            <th scope="col">Prazo</th>
                            <th scope="col">Tipo de Formação</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Localidade</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ ($dados->currentPage() - 1) * $dados->perPage() + $loop->iteration }}</th>
                                <td>{{ $dado->data ? (\Carbon\Carbon::parse($dado->data)->format('d/m/Y')) : '-' }}</td>
                                <td>{{ $dado->prazo ?? '-' }}</td>
                                <td>{{ $dado->tipo_formacao->descricao ?? '-' }}</td>
                                <td>{{ $dado->comunidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->cidade->descricao ?? '-' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('pessoas.formacoes.edit', ['pessoa_id' => $pessoa_id, 'formaco' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('pessoas.formacoes.destroy', ['pessoa_id' => $pessoa_id, 'formaco' => $dado->id]) }}" method="POST"
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
                                <td colspan="9">Nenhum registro encontrado!</td>
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
                    <a class="btn btn-custom inter inter-title" href="{{ route('pessoas.formacoes.create',['pessoa_id'=> $pessoa_id])}}">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

    @if (request()->is('controle/formacoes'))
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
