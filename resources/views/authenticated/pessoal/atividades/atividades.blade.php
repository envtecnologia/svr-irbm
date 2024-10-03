@extends('templates.main')

@section('title', 'Atividades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Atividades ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('atividade.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row justify-content-center g-3">
                            <div class="col-6">
                                <label for="cod_tipoatividade_id" class="form-label">Tipo de Atividade<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_tipoatividade_id" name="cod_tipoatividade_id">
                                    <option value="">Selecione...</option>
                                    @forelse($tipo_atividades as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_tipoatividade_id') && $r->id == request('cod_tipoatividade_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhum tipo de atividade cadastrado</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="situacao" class="form-label">Situação</label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="">Selecione...</option>
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Em Andamento</option>
                                    <option value="0" @if (request()->has('situacao') && request()->input('situacao') == 0 && request()->input('situacao') != '') selected @endif>Concluído
                                    </option>
                                </select>
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
                                <td>{{ $dado->situacao ? 'Em Andamento' :'Concluído' }}</td>
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

@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
