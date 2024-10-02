@extends('templates.main')

@section('title', 'Obras')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Obras ({{ $dados->total() }})</h2>
    </div>


    <form action="{{ route('obras.index') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

                <div class="row justify-content-center">

                    <div class="col-10">
                        <div class="row justify-content-center">

                            <div class="col-6">
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

                            <div class="col-6">
                                <label for="cod_cidade_id" class="form-label">Cidade<span class="required">*</span></label>
                                <select class="form-select" id="cod_cidade_id" name="cod_cidade_id">
                                    <option value="">Selecione...</option>
                                    @forelse($cidades as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_cidade_id') && $r->id == request('cod_cidade_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma cidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3 justify-content-center">
                            <div class="col-7">
                                <label for="descricao" class="form-label">Comunidade</label>
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

                            <div class="col-3">
                                <label for="situacao" class="form-label">Situação</label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="">Selecione...</option>
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativa</option>
                                    <option value="0" @if (request()->has('situacao') && request()->input('situacao') == 0 && request()->input('situacao') != '') selected @endif>Inativa
                                    </option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="id" class="form-label">Código</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ request()->has('id') ? request()->input('id') : '' }}">
                            </div>

                            <div
                                class="{{ request()->is('search/comunidades') ? 'col-6' : 'col-3 mt-4' }} d-flex justify-content-center align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/comunidades'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/comunidades">Limpar
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
                            <th scope="col">Tipo de Obra</th>
                            <th scope="col">Província</th>
                            <th scope="col">Obra</th>
                            @if(!(request()->is('relatorio/rede/obras')))
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
                                <td>{{ $dado->tipo_obra->descricao ?? '-' }}</td>
                                <td>{{ $dado->provincia->descricao ?? '-' }}</td>
                                <td>{{ $dado->descricao ?? '-' }}</td>

                                @if(!(request()->is('relatorio/rede/obras')))
                                <td>

                                    <!-- Botão de endereços -->
                                    <a class="btn btn-link btn-action" href="{{ route('obras.map', ['id' => $dado->id]) }}">
                                        <i class="fa-solid fa-map-location-dot"></i></a>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('obras.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('obras.delete', ['id' => $dado->id]) }}" method="POST"
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
                                        {{ $dados->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>



                                <div class="mb-2">
                                    <form method="POST" action="{{ route('actionButton') }}">
                                        @csrf
                                        <input type="text" name="modulo" value="obras" hidden>
                                        <input type="text" name="action" value="{{ request()->is('relatorio/rede/obras') ? 'pdf' : 'insert' }}" hidden>
                                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/rede/obras') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorio/rede/obras') ? 'Imprimir' : 'Novo +'  }}</button>
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
