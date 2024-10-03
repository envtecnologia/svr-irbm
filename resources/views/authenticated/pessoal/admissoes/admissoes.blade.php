@extends('templates.main')

@section('title', 'Admissoes')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Admissoes ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('admissoes.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row justify-content-center g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pelo nome"
                                    value="{{ request()->has('descricao') ? request()->input('descricao') : '' }}">
                            </div>

                            <div class="col-3">
                                <label for="data_inicio" class="form-label">Data Ínicio</label>
                                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                                    value="{{ request()->has('data_inicio') ? request()->input('data_inicio') : '' }}">
                            </div>

                            <div class="col-3">
                                <label for="data_fim" class="form-label">Data Final</label>
                                <input type="date" class="form-control" id="data_fim" name="data_fim"
                                    value="{{ request()->has('data_fim') ? request()->input('data_fim') : '' }}">
                            </div>


                        <div class="{{ request()->is('search/admissoes') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/admissoes'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/admissoes">Limpar Pesquisa</a>
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
                            <th scope="col">Data Cadastro	</th>
                            <th scope="col">Egresso</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->datacadastro ? \Carbon\Carbon::parse($dado->datacadastro)->format('d/m/Y') : '-' }}</td>
                                <td>{{$dado->sobrenome}}, {{ $dado->nome }}</td>
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
                        <input type="text" name="modulo" value="admissoes" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/admissoes') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/admissoes') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/admissoes') ? 'Imprimir' : 'Novo +'  }}</button>
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
