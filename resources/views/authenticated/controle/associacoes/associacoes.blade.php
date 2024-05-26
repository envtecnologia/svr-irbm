@extends('templates.main')

@section('title', 'Associações')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Associações ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchAssociacao') }}" method="POST">
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

                            <div class="col-3">
                                <label for="search" class="form-label">Situação</label>
                                <select class="form-select" name="situacao">
                                        <option value="1">Ativa</option>
                                        <option value="0">Inativa</option>
                                </select>
                            </div>

                        <div class="{{ request()->is('search/associacoes') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/associacoes'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/associacoes">Limpar Pesquisa</a>
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
                            <th scope="col">CNPJ</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Telefone ¹</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Responsável</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->cnpj }}</td>
                                <td>{{ $dado->descricao }}</td>
                                <td>{{ $dado->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $dado->tipo_associacoes->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->cidade->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->telefone1 ?? 'N/A' }}</td>
                                <td>{{ $dado->email ?? 'N/A' }}</td>
                                <td>{{ $dado->responsavel ?? 'N/A' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('associacoes.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('associacoes.delete', ['id' => $dado->id]) }}" method="POST"
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
                    <a class="btn btn-custom inter inter-title" href="{{ route('associacoes.new') }}">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
