@extends('templates.main')

@section('title', 'Cemitérios')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Cemitérios ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchCemiterio') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Cemitério</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição" value="{{ old('descricao', $searchCriteria['descricao'] ?? '') }}">
                            </div>

                            <div class="col-6">
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
                            </div>

                            <div class="col-2">
                                <label for="situacao" class="form-label">Situação</label>
                                <select class="form-select" name="situacao">
                                        <option value="1" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 1 ? 'selected' : '' }}>Ativa</option>
                                        <option value="0" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 0 ? 'selected' : '' }}>Inativa</option>
                                </select>
                            </div>

                        <div class="{{ request()->is('search/cemiterios') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/cemiterios'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/cemiterios">Limpar Pesquisa</a>
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
                            <th scope="col">Descrição</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">Telefone²</th>
                            <th scope="col">Contato</th>
                            @if(!(request()->is('relatorio/rede/cemiterios')))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td class="text-start">{{ $dado->descricao }}</td>
                                <td>{{ $dado->endereco ?? '-' }}</td>
                                <td>{{ $dado->cidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td>
                                <td>{{ $dado->telefone2 ?? '-' }}</td>
                                <td>{{ $dado->contato ?? '-' }}</td>

                                @if(!(request()->is('relatorio/rede/cemiterios')))
                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('cemiterios.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('cemiterios.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
                                                class="fa-solid fa-trash-can"></i></button>
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
                                        {{ $dados->links() }}
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                                        @csrf
                                        <input type="text" name="modulo" value="cemiterios" hidden>
                                        <input type="text" name="action" value="{{ request()->is('relatorio/rede/cemiterios') ? 'pdf' : 'insert' }}" hidden>
                                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/rede/cemiterios') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorio/rede/cemiterios') ? 'Imprimir' : 'Novo +'  }}</button>
                                    </form>
                                </div>
            </div>

        </div>
    </div>
    </div>

    @if (request()->is('controle/cemiterios'))
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
@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
