@extends('templates.main')

@section('title', 'Pessoas')

@section('content')

    <style>
        fieldset {
            border-radius: 25px;
        }

        legend {
            font-size: 1rem;
            font-weight: 600;
        }

        #porIdade,
        #porFormacao,
        #porFormacaoAcademica,
        #porPeriodoProvincia,
        #porFormacaoPeriodo {
            display: none;
        }
    </style>

    <div class="row mt-5">
        <h2 class="text-center">Relatório Pessoas ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('pessoa.imprimir') }}" method="GET">

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
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativas
                                    </option>
                                    <option value="2" @if (request()->has('situacao') && request()->input('situacao') == 2) selected @endif>Egressas
                                    </option>
                                    <option value="3" @if (request()->has('situacao') && request()->input('situacao') == 3) selected @endif>Falecidas
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="row g-3">
                            <div class="col-8">
                                <label for="cod_origem_id" class="form-label">Origem/Etnia<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_origem_id" name="cod_origem_id">
                                    <option value="">Selecione...</option>
                                    @forelse($origens as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_origem_id') && $r->id == request('cod_origem_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma origem/etnia cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="cod_raca_id" class="form-label">Raça/Cor<span class="required">*</span></label>
                                <select class="form-select" id="cod_raca_id" name="cod_raca_id">
                                    <option value="">Selecione...</option>
                                    @forelse($racas as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_raca_id') && $r->id == request('cod_raca_id')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma categoria cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>

                        <div class="row mt-4">
                            <!-- Relatório por Faixa Etária -->
                            <fieldset class="border p-2 mb-4">
                                <legend class="w-auto">
                                    <input type="radio" id="tipoFaixaEtaria" name="tipoRelatorio" value="faixa_etaria"
                                        tabindex="11">
                                    <label for="tipoFaixaEtaria">Relatório por Faixa Etária</label>
                                </legend>
                                <div id="porIdade" class="form-row">

                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-2">
                                                <label for="txtDe">De</label>
                                                <input type="number" maxlength="3" class="form-control" name="txtDe"
                                                    id="txtDe" tabindex="12">
                                            </div>

                                            <div class="col-2">
                                                <label for="txtAte">Até</label>
                                                <input type="number" maxlength="3" class="form-control" name="txtAte"
                                                    id="txtAte" tabindex="13">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group col-md-8 d-flex align-items-center">
                                        <span class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório organizado por idade.
                                        </span>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Relatório por Formação Religiosa -->
                            <fieldset class="border p-2 mb-4">
                                <legend class="w-auto">
                                    <input type="radio" id="tipoFormacao" name="tipoRelatorio" value="formacao"
                                        tabindex="14">
                                    <label for="tipoFormacao">Relatório por Formação Religiosa</label>
                                </legend>
                                <div id="porFormacao">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório por Formações.
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="selTiposFormacoes">Tipo de Formação</label>
                                        <select class="form-select" id="selTiposFormacoes" name="selTiposFormacoes"
                                            tabindex="15">
                                            <option value="" selected>Todos</option>
                                            @foreach ($tipos_formacao as $r)
                                                <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="selComunidadesFormacoes">Comunidades</label>
                                        <select class="form-select" id="selComunidadesFormacoes"
                                            name="selComunidadesFormacoes" tabindex="16">
                                            <option value="" selected>Todas</option>
                                            @foreach ($comunidades as $comunidade)
                                                <option value="{{ $comunidade->id }}">{{ $comunidade->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-row">

                                        <div class="form-group">

                                            <div class="row">

                                                <div class="form-group col-md-6">
                                                    <label for="txtDeFormacao">De</label>
                                                    <input type="date" class="form-control" name="txtDeFormacao"
                                                        id="txtDeFormacao" tabindex="17">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="txtAteFormacao">Até</label>
                                                    <input type="date" class="form-control" name="txtAteFormacao"
                                                        id="txtAteFormacao" tabindex="18">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            </fieldset>

                            <!-- Relatório por Formação Acadêmica -->
                            <fieldset class="border p-2 mb-4">
                                <legend class="w-auto">
                                    <input type="radio" id="tipoFormacaoAcademica" name="tipoRelatorio"
                                        value="formacao_academica" tabindex="19">
                                    <label for="tipoFormacaoAcademica">Relatório por Formação Acadêmica</label>
                                </legend>
                                <div id="porFormacaoAcademica">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório por Formações Acadêmicas.
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="selEscolaridades">Nível de Formação</label>
                                        <select class="form-control" id="selEscolaridades" name="selEscolaridades"
                                            tabindex="20">
                                            <option value="" selected>Todos</option>
                                            @foreach ($escolaridades as $escolaridade)
                                                <option value="{{ $escolaridade->id }}">{{ $escolaridade->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Relatório por Permanência na Comunidade -->
                            <fieldset class="border p-2 mb-4">
                                <legend class="w-auto">
                                    <input type="radio" id="tipoPermanencia" name="tipoRelatorio"
                                        value="permanencia_comunidade" tabindex="21">
                                    <label for="tipoPermanencia">Relatório por Permanência na Comunidade</label>
                                </legend>
                                <div id="porPeriodoProvincia" class="form-row">

                                    <div class="form-group">

                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="txtInicio">De</label>
                                                <input type="date" class="form-control" name="txtInicio"
                                                    id="txtInicio" tabindex="22">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="txtFinal">Até</label>
                                                <input type="date" class="form-control" name="txtFinal"
                                                    id="txtFinal" tabindex="23">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col d-flex align-items-center">
                                                <span class="font-weight-bold text-danger">
                                                    Esta opção exibirá um relatório gerado de acordo com o registrado nos
                                                    "Itinerários".
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                            </fieldset>
                        </div>


                        <div class="row">
                            <div class="mt-4 d-flex justify-content-end align-items-end">
                                <div class="me-2">
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                </div>
                                <div>
                                    <a class="btn btn-custom inter inter-title" href="{{ route('pessoa.imprimir') }}">Limpar Filtros</a>
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
                            <th scope="col">Província </th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Nome Completo </th>
                            <th scope="col">Origem </th>
                            <th scope="col">Raça </th>
                            <th scope="col">Categoria </th>






                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->provincia->descricao ?? '' }}</td>
                                <td>{{ $dado->comunidade->descricao ?? '' }}</td>
                                <td>
                                    @if ($dado->situacao == 3)
                                        Falecida
                                    @elseif ($dado->situacao == 2)
                                        Egressa
                                    @elseif ($dado->situacao == 0)
                                        Inativa
                                    @else
                                        Ativa
                                    @endif
                                </td>
                                <td>{{ $dado->sobrenome }}, {{ $dado->nome }}</td>
                                <td>{{ $dado->origem->descricao }}</td>
                                <td>{{ $dado->raca->descricao }}</td>
                                <td>{{ $dado->categoria->descricao }}</td>





                                @if (!request()->is('relatorio/rede/ '))
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
                        <input type="text" name="modulo" value="pessoa" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorios/pessoal/pessoa') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="action-button">{{ request()->is('relatorios/pessoal/pessoa') ? 'Imprimir' : 'Novo +' }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/pdfSocket.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Ocultar o fieldset inicialmente
            $("#toggleFieldset").hide();

            // Alternar a visualização do fieldset ao clicar no botão
            $("#toggleFieldsetBtn").click(function() {
                $("#toggleFieldset").toggle(400); // 400 é o tempo da animação em milissegundos
            });
        });
    </script>

    <script>
        $('input[name="tipoRelatorio"]').on('change', function() {
            var selectedValue = $('input[name="tipoRelatorio"]:checked').val();

            // Limpar campos antes de aplicar novas mudanças
            // $("#txtDe, #txtAte, #txtInicio, #txtFinal").val(""); // Limpa todos os campos de data
            // $("#selTiposFormacoes, #selComunidades, #selEscolaridades").val(0); // Limpa os selects

            // Esconder todos os campos
            $("#porIdade, #porFormacao, #porFormacaoAcademica, #porPeriodoProvincia, #porFormacaoPeriodo").hide();

            if (selectedValue === 'faixa_etaria') {
                // Exibir campos relacionados à Faixa Etária
                $("#porIdade").show();
                $("#txtDe").focus();
            } else if (selectedValue === 'formacao') {
                // Exibir campos relacionados à Formação Religiosa
                $("#porFormacao").show();
                $("#porFormacaoPeriodo").show();
                $("#selTiposFormacoes").focus();
            } else if (selectedValue === 'formacao_academica') {
                // Exibir campos relacionados à Formação Acadêmica
                $("#porFormacaoAcademica").show();
                $("#selEscolaridades").focus();
            } else if (selectedValue === 'permanencia_comunidade') {
                // Exibir campos relacionados à Permanência na Comunidade
                $("#porPeriodoProvincia").show();
                $("#txtInicio").focus();
            }
        });
    </script>


@endsection
