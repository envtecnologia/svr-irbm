@extends('templates.main')

@section('title', 'Falecimentos')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Falecimentos ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ request()->routeIs('falecimentos.index') ? route('falecimentos.index') : route('falecimento.imprimir') }}" action="{{ route('paroquias.index') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Falecida(o)</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição"
                                    value="{{ request()->has('descricao') ? request()->input('descricao') : '' }}">
                            </div>

                            <div class="col-6">
                                <label for="cod_cemiterio_id" class="form-label">Cemitério<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_cemiterio_id" name="cod_cemiterio_id">
                                    <option value="">Selecione...</option>
                                    @forelse($cemiterios as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_cemiterio_id') && $r->id == request('cod_cemiterio_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma cidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div>


                            <div
                                class="{{ request()->is('search/falecimentos') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/falecimentos'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/falecimentos">Limpar
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
                            <th scope="col">#</th>
                            <th scope="col">Data </th>
                            <th scope="col">Jazigo</th>
                            <th scope="col">Falecida(o)</th>
                            <th scope="col">Cemitério</th>


                            @if (!request()->is('relatorio/pessoal/falecimento'))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->datafalecimento ? \Carbon\Carbon::parse($dado->datafalecimento)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $dado->jazigo }}</td>
                                <td>{{ $dado->pessoa->sobrenome ?? '-' }}, {{ $dado->pessoa->nome ?? '-' }}</td>
                                <td>{{ $dado->cemiterio->descricao }}</td>


                                @if (!request()->is('relatorio/pessoal/falecimento'))
                                    <td>
                                        <!-- Botão de editar -->
                                        <a class="btn-action"
                                            href="{{ route('falecimentos.edit', ['id' => $dado->id]) }}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <!-- Botão de excluir (usando um formulário para segurança) -->
                                        <form action="{{ route('falecimentos.delete', ['id' => $dado->id]) }}"
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
                        <input type="text" name="modulo" value="falecimentos" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorios/pessoal/falecimento') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="{{ request()->is('relatorios/pessoal/falecimento') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/falecimento') ? 'Imprimir' : 'Novo +' }}</button>
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
