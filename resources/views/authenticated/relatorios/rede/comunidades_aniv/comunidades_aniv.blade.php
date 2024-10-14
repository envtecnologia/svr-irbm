@extends('templates.main')

@section('title', 'Comunidades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Aniversário das Comunidades ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('comunidades_aniv.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
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


                        </div>

                        <div class="row g-3">

                            <div class="col-6">
                                <label for="data_inicio" class="form-label">Data Início</label>
                                <input type="text" class="form-control" id="data_inicio" name="data_inicio"
                                    placeholder="dd/mm"
                                    value="{{ request()->has('data_inicio') ? request()->input('data_inicio') : '' }}">
                            </div>

                            <div class="col-6">
                                <label for="data_fim" class="form-label">Data Final</label>
                                <input type="text" class="form-control" id="data_fim" name="data_fim"
                                    placeholder="dd/mm"
                                    value="{{ request()->has('data_fim') ? request()->input('data_fim') : '' }}">
                            </div>


                            <div
                                class="{{ request()->is('search/comunidades') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
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

            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Código</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Província</th>
                            <th scope="col">Paróquia</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Aniversário</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">E-mail¹</th>
                            @if (!request()->is('relatorio/rede/comunidades'))
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
                                <td>{{ $dado->cidade->descricao ?? '-' }}</td>
                                <td>{{ $dado->provincia->descricao ?? '-' }}</td>
                                <td>{{ $dado->paroquia->descricao ?? '-' }}</td>
                                <td>{{ $dado->descricao ?? '-' }}</td>
                                <td>{{ $dado->fundacao ? \Carbon\Carbon::parse($dado->fundacao)->format('d/m') : '-' }}
                                </td>
                                <td>{{ $dado->telefone1 ?? '-' }}</td>
                                <td>{{ $dado->email1 ?? '-' }}</td>

                                @if (!request()->is('relatorio/rede/comunidades'))
                                    <td>

                                        <!-- Botão de endereços -->
                                        <a class="btn btn-link btn-action"
                                            href="{{ route('comunidades.map', ['id' => $dado->id]) }}">
                                            <i class="fa-solid fa-map-location-dot"></i></a>
                                        <!-- Botão de editar -->
                                        <a class="btn-action"
                                            href="{{ route('comunidades.edit', ['id' => $dado->id]) }}"><i
                                                class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                        <!-- Botão de excluir (usando um formulário para segurança) -->
                                        <form action="{{ route('comunidades.delete', ['id' => $dado->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-action" data-bs-toggle="popover" data-bs-content="Deletar"><i
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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="comunidades_aniv" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorio/rede/comunidades_aniv') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="action-button">{{ request()->is('relatorio/rede/comunidades_aniv') ? 'Imprimir' : 'Novo +' }}</button>
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
@section('js')
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
