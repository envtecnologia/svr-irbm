@extends('templates.main')

@section('title', 'Parentes')

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
                            <td>{{ $pessoa->nome }}</td>

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
                <a href="{{ str_contains($previousUrl, 'search/pessoas/parentes') ? route('pessoas.parentes.index', ["pessoa_id" => $pessoa_id]) : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">Parentes ({{ $dados->total() }})</h2>
        </div>

    </div>


    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Parentesco</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Nome do Familiar</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ ($dados->currentPage() - 1) * $dados->perPage() + $loop->iteration }}
                                </th>
                                <td>{{ $dado->datafalecimento ? 'Falecido' : 'Ativo' }}</td>
                                <td>{{ $dado->parentesco->descricao ?? '-' }}</td>
                                <td>{{ $dado->sexo ? 'Masculino' : 'Feminino' }}</td>
                                <td>{{ $dado->nome ?? '-' }}</td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td>
                                <td>{{ $dado->email ?? '-' }}</td>
                                <td>{{ $dado->cidade->descricao ?? 'Geral' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('pessoas.parentes.edit', ['pessoa_id' => $pessoa_id,
                                    'parente' => $dado->id]) }}"><i
                                        class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('parentes.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action" data-bs-toggle="popover" data-bs-content="Deletar"><i
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

                    <a class="btn btn-custom inter inter-title" href="{{ route('pessoas.parentes.create',['pessoa_id'=> $pessoa_id]) }}">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

    @if (request()->is('controle/parentes'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Obtém a data atual
                var today = new Date();
                var day = String(today.getDate()).padStart(2, '0');
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
                var year = today.getFullYear();

                // Formata a data no padrão YYYY-MM-DD
                var currentDate = year + '-' + month + '-' + day;
                var oldDate = (year - 1) + '-' + month + '-' + day;


                // Define o valor padrão dos campos de data
                document.getElementById('data_inicio').value = oldDate;
                document.getElementById('data_fim').value = currentDate;
            });
        </script>
    @endif

@endsection
