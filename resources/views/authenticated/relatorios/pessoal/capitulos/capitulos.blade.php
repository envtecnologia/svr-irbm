

@extends('templates.main')

@section('title', 'Civil')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Civil ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchEgresso') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="search" class="form-label">Instituição</label>
                                <input type="text" class="form-control" id="search" name="descricao"
                                    placeholder="Pesquisar pela descrição">
                            </div>


                        <div class="{{ request()->is('search/civil') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/civil'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/civil">Limpar Pesquisa</a>
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
                            <th scope="col">Província</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">RG</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Nascimento</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->provincia->descricao }}</td>
                                <td>{{ $dado->comunidade->descricao }}</td>
                                <td>{{ $dado->situacao ? 'Ativo': 'Inativo' }}</td>
                                <td>{{ $dado->nome }}</td>
                                <td>{{ $dado->rg }}</td>
                                <td>{{ $dado->cpf }}</td>
                                <td>{{ $dado->datanascimento ? \Carbon\Carbon::parse($dado->datanascimento)->format('d/m/Y') : '-' }}</td>






                                {{-- @if(!(request()->is('relatorio/rede/civil')))
                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('civil.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('civil.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            @endif --}}

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">Nenhum registro encontrado!</td>
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
                    <form method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="civil" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/civil') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="action-button">{{ request()->is('relatorios/pessoal/civil') ? 'Imprimir' : 'Novo +'  }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
