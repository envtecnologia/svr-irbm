@extends('templates.main')

@section('title', 'Capítulos')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Capítulos ({{ $dados->total() }})</h2>
    </div>
    {{-- {{ route('searchCapitulo') }} --}}
    <form id="search" action="{{ request()->routeIs('capitulos.index') ? route('capitulos.index') : route('capitulos.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-4">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero"
                                    value="{{ request()->has('numero') ? request()->input('numero') : '' }}">
                            </div>

                            <div class="col-4">
                                <label for="data_inicio" class="form-label">Data de Ínicio</label>
                                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                    value="{{ request()->has('data_inicio') ? request()->input('data_inicio') : '' }}">
                            </div>

                            <div class="col-4">
                                <label for="data_fim" class="form-label">Data de Final</label>
                                <input type="date" class="form-control" id="data_fim" name="data_fim"
                                    value="{{ request()->has('data_fim') ? request()->input('data_fim') : '' }}">
                            </div>

                        </div>

                        <div class="row g-3 mt-1">

                            <div class="col">
                                <label for="cod_provincia_id" class="form-label">Província<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_provincia_id" name="cod_provincia_id">
                                    <option value="">Selecione...</option>
                                    @forelse($provincias as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_provincia_id') && $r->id == request('cod_provincia_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma província cadastrada</option>
                                    @endforelse
                                </select>


                            </div>

                        </div>

                        <div class="row justify-content-end">

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
                            {{-- <th scope="col">#</th> --}}
                            <th scope="col">Capítulo</th>
                            <th scope="col">Data</th>
                            <th scope="col">Província</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                {{-- <th scope="row">{{ $key + 1 }}</th> --}}
                                <td>{{ $dado->numero }}</td>
                                <td>{{ $dado->data ? \Carbon\Carbon::parse($dado->data)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->provincia->descricao ?? 'Geral' }}</td>
                                <td>{{ $dado->detalhes ?? '-' }}</td>

                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('capitulos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('capitulos.delete', ['id' => $dado->id]) }}" method="POST"
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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="capitulos" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/capitulos') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="{{ request()->routeIs('capitulos.index') ? 'new-button' : 'action-button' }}">{{ request()->is('relatorios/pessoal/capitulos') ? 'Imprimir' : 'Novo +'  }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

    @if (request()->is('controle/capitulos'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Obtém a data atual
                var today = new Date();
                var day = String(today.getDate()).padStart(2, '0');
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Janeiro é 0!
                var year = today.getFullYear();

                // Formata a data no padrão YYYY-MM-DD
                var currentDate = year + '-' + month + '-' + day;
                var oldDate = (year - 50) + '-' + month + '-' + day;


                // Define o valor padrão dos campos de data
                // document.getElementById('data_inicio').value = oldDate;
                document.getElementById('data_fim').value = currentDate;
            });
        </script>
    @endif

@endsection

@section('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection

