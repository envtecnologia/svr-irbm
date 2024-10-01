@extends('templates.main')

@section('title', 'Pessoas')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Pessoas ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('pessoas.index') }}" method="GET">

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

                        <div class="row g-3 mt-1">

                            <div class="col-2">
                                <label for="id" class="form-label">Código</label>
                                <input type="text" class="form-control" id="id" name="id" value="{{ request()->has('id') ? request()->input('id') : '' }}">
                            </div>

                            <div class="col-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ request()->has('nome') ? request()->input('nome') : '' }}">
                            </div>

                            <div class="col-4">
                                <label for="situacao" class="form-label">Situação<span
                                        class="required">*</span></label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="">Selecione...</option>
                                        <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativos(as)</option>
                                        <option value="2" @if (request()->has('situacao') && request()->input('situacao') == 2) selected @endif>Egressos(as)</option>
                                        <option value="3" @if (request()->has('situacao') && request()->input('situacao') == 3) selected @endif>Falecidos(as)</option>
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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                {{-- <th>Código Antigo</th> --}}
                                <th>Situação</th>
                                <th>Nome Completo</th>
                                <th>Província</th>
                                {{-- <th>Data de Nascimento</th> --}}
                                {{-- <th>CPF</th> --}}
                                {{-- <th>Telefone</th> --}}
                                @if (!request()->is('relatorio/rede/pessoas'))
                                    <th scope="col">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dados as $key => $dado)
                                <tr>
                                    <th scope="row">{{ $dados->firstItem() + $key }}</th>
                                    <td>{{ $dado->id }}</td>
                                    {{-- <td>{{ $dado->codantigo ?? '-' }}</td> --}}
                                    <td>
                                        @if ($dado->situacao == 3)
                                            Falecido(a)
                                        @elseif ($dado->situacao == 2)
                                            Egresso(a)
                                        @elseif ($dado->situacao == 0)
                                            Inativo(a)
                                        @else
                                            Ativo(a)
                                        @endif
                                    </td>
                                    <td>{{ $dado->sobrenome }}, {{ $dado->nome }}</td>
                                    <td>{{ $dado->provincia->descricao ?? '-' }}</td>
                                    {{-- <td>{{ $dado->datanascimento ? \Carbon\Carbon::parse($dado->datanascimento)->format('d/m/Y') : '' }}</td>
                                <td>{{ $dado->cpf ?? '-' }}</td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td> --}}

                                    @if (!request()->is('relatorio/rede/pessoas'))
                                        <td>
                                            <!-- Botão de arquivos -->
                                            <a class="btn-action"
                                                href="{{ route('pessoas.arquivos.index', ['pessoa_id' => $dado->id]) }}"><i
                                                    class="fa-solid fa-folder-open  me-2"></i></a>

                                            @if ($dado->situacao == 1)
                                                <!-- Botão de atividades -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.atividades.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-list-check me-2"></i></a>
                                                <!-- Botão de cursos -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.cursos.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-book me-2"></i></a>
                                                <!-- Botão de parentes -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.parentes.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-users-line me-2"></i></a>
                                                <!-- Botão de formações -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.formacoes.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-graduation-cap me-2"></i></a>
                                                <!-- Botão de funções -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.funcoes.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-sliders me-2"></i></a>
                                                <!-- Botão de habilidades -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.habilidades.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-signal me-2"></i></a>
                                            @endif
                                            <!-- Botão de histórico -->
                                            <a class="btn-action"
                                                href="{{ route('pessoas.historico.index', ['pessoa_id' => $dado->id]) }}"><i
                                                    class="fa-solid fa-clock-rotate-left me-2"></i></a>
                                            @if ($dado->situacao == 1)
                                                <!-- Botão de itinerarios -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.itinerarios.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-wave-square me-2"></i></a>
                                                <!-- Botão de ocorrencias medicas -->
                                                <a class="btn-action"
                                                    href="{{ route('pessoas.ocorrenciasMedicas.index', ['pessoa_id' => $dado->id]) }}"><i
                                                        class="fa-solid fa-kit-medical me-2"></i></a>
                                            @endif
                                            <!-- Botão de imprimir -->
                                            <a class="btn-action"
                                                href="{{ route('pessoas.imprimir', ['pessoa_id' => $dado->id]) }}"><i
                                                    class="fa-solid fa-print me-2"></i></a>

                                            <!-- Botão de editar -->
                                            <a class="btn-action"
                                                href="{{ route('pessoas.edit', ['id' => $dado->id]) }}"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>


                                            <!-- Botão de excluir (usando um formulário para segurança) -->
                                            <form action="{{ route('pessoas.delete', ['id' => $dado->id]) }}"
                                                method="POST" class="d-inline">
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
                </div>

                <!-- Links de paginação -->
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{ $dados->appends(request()->except('page'))->links() }}
                    </div>
                </div>



                <div class="mb-2">
                    <a class="btn btn-custom inter inter-title"
                        target="{{ request()->is('relatorio/rede/pessoas') ? '_blank' : '_self' }}"
                        href="{{ request()->is('relatorio/rede/pessoas') ? route('pessoas.pdf') : route('pessoas.new') }}">{{ request()->is('relatorio/rede/pessoas') ? 'Imprimir' : 'Novo +' }}</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
