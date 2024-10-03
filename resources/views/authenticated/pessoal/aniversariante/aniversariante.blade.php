@extends('templates.main')

@section('title', 'Aniversarios')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Aniversarios ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('aniversariante.imprimir') }}" method="GET">

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

                            <div class="col-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ request()->has('nome') ? request()->input('nome') : '' }}">
                            </div>

                            <div class="col-3">
                                <label for="data_inicio" class="form-label">Data Início</label>
                                <input type="text" class="form-control" id="data_inicio" name="data_inicio"
                                    placeholder="dd/mm"
                                    value="{{ request()->has('data_inicio') ? request()->input('data_inicio') : '' }}">
                            </div>

                            <div class="col-3">
                                <label for="data_fim" class="form-label">Data Final</label>
                                <input type="text" class="form-control" id="data_fim" name="data_fim"
                                    placeholder="dd/mm"
                                    value="{{ request()->has('data_fim') ? request()->input('data_fim') : '' }}">
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
                            <th scope="col">Província</th>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">Aniversário</th>
                            <th scope="col">Comunidade</th>



                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                    <td>{{$dado->provincia->descricao }}</td>
                                <td>{{$dado->sobrenome }}, {{ $dado->nome }}</td>
                                <td>{{ $dado->aniversario }}</td>
                                <td>{{ $dado->comunidade->descricao ?? '-' }}</td>




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
                        <input type="text" name="modulo" value="aniversariante" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/aniversariante') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/aniversariante') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/aniversariante') ? 'Imprimir' : 'Novo +'  }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection

@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#data_inicio').mask('00/00');
            $('#data_fim').mask('00/00');

            $('form').on('submit', function(e) {
                var dataInicio = $('#data_inicio').val();
                var dataFim = $('#data_fim').val();

                var diaInicio = parseInt(dataInicio.split('/')[0]);
                var mesInicio = parseInt(dataInicio.split('/')[1]);
                var diaFim = parseInt(dataFim.split('/')[0]);
                var mesFim = parseInt(dataFim.split('/')[1]);

                // Validação simples de exemplo
                if ((diaInicio < 1 || diaInicio > 31) || (mesInicio < 1 || mesInicio > 12) ||
                    (diaFim < 1 || diaFim > 31) || (mesFim < 1 || mesFim > 12)) {
                    alert('Data inválida. Por favor, insira um dia (1-31) e um mês (1-12).');
                    e.preventDefault(); // Impede o envio do formulário
                }
            });
        });
    </script>
@endsection
