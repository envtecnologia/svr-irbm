@extends('templates.main')

@section('title', 'Civil')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Civil ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('civil.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-8">
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

                            <div class="col-4">
                                <label for="cod_tipopessoa_id" class="form-label">Categoria<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_tipopessoa_id" name="cod_tipopessoa_id">
                                    <option value="">Selecione...</option>
                                    @forelse($categorias as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_tipopessoa_id') && $r->id == request('cod_tipopessoa_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma categoria cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>

                        <div class="row g-3">

                            <div class="col-12">
                                <label for="cod_comunidade_id" class="form-label">Comunidade<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id">
                                    <option value="">Selecione...</option>
                                    @forelse($comunidades as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_comunidade_id') && $r->id == request('cod_comunidade_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma comunidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>

                        <div class="row g-3">

                            <div class="col-8">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    value="{{ request()->has('nome') ? request()->input('nome') : '' }}">
                            </div>

                            <div class="col-4">
                                <label for="situacao" class="form-label">Situação<span class="required">*</span></label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="">Selecione...</option>
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativos(as)
                                    </option>
                                    <option value="2" @if (request()->has('situacao') && request()->input('situacao') == 2) selected @endif>Egressos(as)
                                    </option>
                                    <option value="3" @if (request()->has('situacao') && request()->input('situacao') == 3) selected @endif>Falecidos(as)
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="mt-4 d-flex justify-content-end align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                </div>
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
                                <td>{{ $dado->situacao ? 'Ativo' : 'Inativo' }}</td>
                                <td>{{ $dado->nome }}</td>
                                <td>{{ $dado->rg }}</td>
                                <td>{{ $dado->cpf }}</td>
                                <td>{{ $dado->datanascimento ? \Carbon\Carbon::parse($dado->datanascimento)->format('d/m/Y') : '-' }}
                                </td>






                                {{-- @if (!request()->is('relatorio/rede/civil'))
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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="civil" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorios/pessoal/civil') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="{{ request()->is('relatorios/pessoal/civil') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/civil') ? 'Imprimir' : 'Novo +' }}</button>
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
