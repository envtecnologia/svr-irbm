@extends('templates.main')

@section('title', 'Atividades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Atividades ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchAniversarios') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="search" class="form-label">Instituição</label>
                                <input type="text" class="form-control" id="search" name="descricao"
                                    placeholder="Pesquisar pela descrição">
                            </div>


                        <div class="{{ request()->is('search/aniversarios') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/aniversarios'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/aniversarios">Limpar Pesquisa</a>
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
                            <th scope="col">Situação</th>
                            <th scope="col">Atividade</th>
                            <th scope="col">Pessoa	</th>
                            <th scope="col">Local</th>
                            <th scope="col">Data Início	</th>
                            <th scope="col">Data Final                            </th>





                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->situacao ? 'Concluído' : 'Em Andamento'}}</td>
                                <td>{{ $dado->tipo_atividade->descricao }}</td>
                                <td>{{ $dado->pessoa->nome ?? '-' }}</td>
                                <td>{{ $dado->cidade->descricao ?? '-'}}</td>
                                <td>{{ \Carbon\Carbon::parse($dado->datainicio)->format('d/m/Y') }}</td>
                                <td>{{ $dado->datafinal ? \Carbon\Carbon::parse($dado->datafinal)->format('d/m/Y') : '-' }}</td>






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
                        <input type="text" name="modulo" value="atividade" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/atividade') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="action-button">{{ request()->is('relatorios/pessoal/atividade') ? 'Imprimir' : 'Novo +'  }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
