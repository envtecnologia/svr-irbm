@extends('templates.main')

@section('title', 'Egressas')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Egressas ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ request()->routeIs('egressos') ? route('egressos') : route('egresso.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-5">

            <div class="col-8">

                <div class="row">

                    <div class="col-12 col-sm-6 mb-3">
                        <label for="descricao" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="descricao" name="descricao"
                            placeholder="Pesquisar pela descrição"
                            value="{{ request()->has('descricao') ? request()->input('descricao') : '' }}">
                    </div>

                    <div class="col-6 col-sm-3">
                        <label for="data_inicio" class="form-label">Data Ínicio</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                            value="{{ request()->has('data_inicio') ? request()->input('data_inicio') : '' }}">
                    </div>

                    <div class="col-6 col-sm-3">
                        <label for="data_fim" class="form-label">Data Final</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim"
                            value="{{ request()->has('data_fim') ? request()->input('data_fim') : '' }}">
                    </div>

                    <div class="col-12 mb-3 d-flex align-items-end justify-content-end">
                        <div>
                            <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                            @if(request()->is('search/setores'))
                                <a class="btn btn-custom inter inter-title" href="/controle/setores">Limpar Pesquisa</a>
                            @endif
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
                            <th scope="col">Data Saída	</th>
                            {{-- <th scope="col">Readmissão</th> --}}
                            <th scope="col">Egresso</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->data_saida ? \Carbon\Carbon::parse($dado->data_saida)->format('d/m/Y') : '-' }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($dado->data_readmissao)->format('d/m/Y') }}</td> --}}
                                <td>{{ $dado->pessoa->sobrenome ?? '-'}}, {{ $dado->pessoa->nome ?? '-'}}</td>


                                @if(!(request()->is('relatorio/rede/egressos')))
                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('egressos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('egressos.delete', ['id' => $dado->id]) }}" method="POST"
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
                                <td colspan="3">Nenhum registro encontrado!</td>
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
                                        <input type="text" name="modulo" value="egressos" hidden>
                                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/egresso') ? 'pdf' : 'insert' }}" hidden>
                                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/egresso') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/egresso') ? 'Imprimir' : 'Novo +'  }}</button>
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
