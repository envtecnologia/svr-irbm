@extends('templates.main')

@section('title', 'Títulos')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Comunidades ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchTitulo') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Títulos</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição" value="{{ old('descricao', $searchCriteria['descricao'] ?? '') }}">
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
                                        <option value="1" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 1 ? 'selected' : '' }}>Ativa</option>
                                        <option value="0" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 0 ? 'selected' : '' }}>Inativa</option>
                                </select>
                            </div>

                        <div class="{{ request()->is('search/titulos') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/titulos'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/titulos">Limpar Pesquisa</a>
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

            <div class="row d-flex justify-content-center mb-2">
                <div class="col-8">
                    <h6 id="text-pdf" style="display: none;" class="text-center">Gerando PDF</h6>
                    <div class="progress" style="display: none;" id="progressBarContainer">
                        <div id="progressBar" class="progress-bar bg-info" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            Carregando...
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center mb-2">
                <div id="div-pdf" class="col-8 text-center d-none">
                    <a id="btn-open-pdf" target="_blank" href="#" class="btn btn-primary btn-action-a">Abrir PDF</a>
                    <a id="btn-download-pdf" href="#" class="btn btn-primary btn-action-a">Baixar PDF</a>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Código</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Província</th>
                            <th scope="col">Paróquia</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Aniversário</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">E-mail¹</th>
                            @if(!(request()->is('relatorio/rede/titulos')))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $dados->firstItem() + $key }}</th>
                                <td>{{ $dado->codantigo ?? '-' }}</td>
                                <td>{{ $dado->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $dado->cidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->provincia->descricao ?? '-' }}</td>
                                <td>{{ $dado->paroquia->descricao ?? '-' }}</td>
                                <td>{{ $dado->descricao ?? '-' }}</td>
                                <td>{{ $dado->fundacao ? \Carbon\Carbon::parse($dado->fundacao)->format('d/m') : '-' }}</td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td>
                                <td>{{ $dado->email1 ?? '-' }}</td>

                                @if(!(request()->is('relatorio/rede/titulos')))
                                <td>

                                    <!-- Botão de endereços -->
                                    <a class="btn btn-link btn-action" href="{{ route('titulos.map', ['id' => $dado->id]) }}">
                                        <i class="fa-solid fa-map-location-dot"></i></a>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('titulos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('titulos.delete', ['id' => $dado->id]) }}" method="POST"
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
                                <td colspan="8">Nenhum registro encontrado!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                                <!-- Links de paginação -->
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        {{ $dados->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>



                                <div class="mb-2">
                                    <form method="POST" action="{{ route('actionButton') }}">
                                        @csrf
                                        <input type="text" name="modulo" value="titulos_aniv" hidden>
                                        <input type="text" name="action" value="{{ request()->is('relatorio/rede/titulos_aniv') ? 'pdf' : 'insert' }}" hidden>
                                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/titulos_aniv') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorio/rede/titulos_aniv') ? 'Imprimir' : 'Novo +'  }}</button>
                                    </form>
                                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
