@extends('templates.main')

@section('title', 'Paróquias')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Paróquias ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ request()->routeIs('paroquias.index') ? route('paroquias.index') : route('paroquias.imprimir') }}" action="{{ route('paroquias.index') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Paróquia</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição"
                                    value="{{ request()->has('descricao') ? request()->input('descricao') : '' }}">
                            </div>

                            {{-- <div class="col-6">
                                <label for="cidade" class="form-label">Cidade</label>
                                <select class="form-select" id="cod_cidade_id" name="cod_cidade_id">
                                    <option value="">Todas</option>
                                    @forelse($cidades as $r)
                                    <option value="{{ $r->id }}" {{ old('cod_cidade_id', $searchCriteria['cod_cidade_id'] ?? '') == $r->id ? 'selected' : '' }}>
                                        {{ $r->descricao }}
                                    </option>
                                    @empty
                                        <option>Nenhuma cidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div> --}}

                            <div class="col-2">
                                <label for="situacao" class="form-label">Situação</label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="">Selecione...</option>
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativa</option>
                                    <option value="0" @if (request()->has('situacao') && request()->input('situacao') == 0 && request()->input('situacao') != '') selected @endif>Inativa
                                    </option>
                                </select>
                            </div>

                            <div
                                class="{{ request()->is('search/paroquias') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/paroquias'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/paroquias">Limpar
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

        </div>
    </form>

    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">

            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Diocese</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Pároco</th>
                            @if (!request()->is('relatorio/rede/paroquias'))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->descricao }}</td>
                                <td>{{ $dado->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $dado->diocese->descricao ?? '-' }}</td>
                                <td>{{ $dado->cidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td>
                                <td>{{ $dado->email ?? '-' }}</td>
                                <td>{{ $dado->paroco ?? '-' }}</td>

                                @if (!request()->is('relatorio/rede/paroquias'))
                                    <td>
                                        <!-- Botão de editar -->
                                        <a class="btn-action" href="{{ route('paroquias.edit', ['id' => $dado->id]) }}"><i
                                                class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                        <!-- Botão de excluir (usando um formulário para segurança) -->
                                        <form action="{{ route('paroquias.delete', ['id' => $dado->id]) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-link btn-action delete-btn" data-bs-toggle="popover" data-bs-content="Deletar">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif

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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="paroquias" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorio/rede/paroquias') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                        id="{{ request()->routeIs('paroquias.index') ? 'new-button' : 'action-button' }}">{{ request()->is('relatorio/rede/paroquias') ? 'Imprimir' : 'Novo +' }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
