@extends('templates.main')

@section('title', 'Pessoas')

@section('content')

<style>
    fieldset{
        border-radius: 25px;
    }
    legend{
        font-size: 1rem;
        font-weight: 600;
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
                                    <option value="1" @if (request()->has('situacao') && request()->input('situacao') == 1) selected @endif>Ativos(as)
                                    </option>
                                    <option value="2" @if (request()->has('situacao') && request()->input('situacao') == 2) selected @endif>Egressos(as)
                                    </option>
                                    <option value="3" @if (request()->has('situacao') && request()->input('situacao') == 3) selected @endif>Falecidos(as)
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
                                <label for="cod_raca_id" class="form-label">Raça/Cor<span
                                        class="required">*</span></label>
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

                        {{-- <div class="row mt-4">
                            <!-- Relatório por Faixa Etária -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto">
                                    <input type="checkbox" id="chkPorIdade" name="chkPorIdade" tabindex="11">
                                    <label for="chkPorIdade">Relatório por Faixa Etária</label>
                                </legend>
                                <div id="porIdade" class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="txtDe">De</label>
                                        <input type="text" class="form-control" name="txtDe" id="txtDe" tabindex="12">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="txtAte">Até</label>
                                        <input type="text" class="form-control" name="txtAte" id="txtAte"
                                            tabindex="13">
                                    </div>
                                    <div class="form-group col-md-8 d-flex align-items-center">
                                        <span class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório organizado por idade.
                                        </span>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Relatório por Formação Religiosa -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto">
                                    <input type="checkbox" id="chkFormacao" name="chkFormacao" tabindex="14">
                                    <label for="chkFormacao">Relatório por Formação Religiosa</label>
                                </legend>
                                <div id="porFormacao">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório por Formações.
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="selTiposFormacoes">Tipo de Formação</label>
                                        <select class="form-control" id="selTiposFormacoes" name="selTiposFormacoes"
                                            tabindex="15">
                                            @foreach ($tipos_formacao as $r)
                                                <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="selComunidadesFormacoes">Comunidades</label>
                                        <select class="form-control" id="selComunidadesFormacoes"
                                            name="selComunidadesFormacoes" tabindex="16">
                                            @foreach ($comunidades as $comunidade)
                                                <option value="{{ $comunidade->id }}">{{ $comunidade->descricao }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="txtDeFormacao">De</label>
                                            <input type="text" class="form-control" name="txtDeFormacao"
                                                id="txtDeFormacao" tabindex="17">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="txtAteFormacao">Até</label>
                                            <input type="text" class="form-control" name="txtAteFormacao"
                                                id="txtAteFormacao" tabindex="18">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Relatório por Formação Acadêmica -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto">
                                    <input type="checkbox" id="chkFormacaoAcademica" name="chkFormacaoAcademica" tabindex="19">
                                        <label for="chkFormacaoAcademica">Relatório por Formação Acadêmica</label>
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
                                            <option value='0'> -- Todas -- </option>
                                            <option value='1'>Curso Livre</option>
                                            <option value='10'>Doutorado</option>
                                            <!-- Adicione os outros valores aqui -->
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Relatório por Permanência na Comunidade -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto">
                                    <input type="checkbox" id="chkPorPeriodoProvincia" name="chkPorPeriodoProvincia" tabindex="21">
                                        <label for="chkPorPeriodoProvincia">Relatório por Permanência na Comunidade</label>
                                </legend>
                                <div id="porPeriodoProvincia" class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="txtInicio">De</label>
                                        <input type="date" class="form-control" name="txtInicio" id="txtInicio"
                                            tabindex="22">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="txtFinal">Até</label>
                                        <input type="date" class="form-control" name="txtFinal" id="txtFinal"
                                            tabindex="23">
                                    </div>
                                    <div class="form-group col-md-8 d-flex align-items-center">
                                        <span class="font-weight-bold text-danger">
                                            Esta opção exibirá um relatório gerado de acordo com o registrado nos
                                            "Itinerários".
                                        </span>
                                    </div>
                                </div>
                            </fieldset>
                        </div> --}}

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
                                        Falecido(a)
                                    @elseif ($dado->situacao == 2)
                                        Egresso(a)
                                    @elseif ($dado->situacao == 0)
                                        Inativo(a)
                                    @else
                                        Ativo(a)
                                    @endif
                                </td>
                                <td>{{ $dado->nome }}</td>
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
        if ($("#chkPorIdade").is(':checked')) {
            $("#chkFormacao, #chkPorPeriodoProvincia").attr("checked", false);
            $("#selTiposFormacoes, #selComunidades, #selEscolaridades").val(0);
            $("#porFormacao, #porFormacaoAcademica").hide();
            $("#porPeriodoProvincia").hide();
            $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

            $("#porIdade").show();
            $("#txtDe").focus();
        } else {
            $("#txtDe, #txtAte").val("");
            $("#porIdade").hide();
        }

        $("#chkPorIdade").click(function() {
            if ($("#chkPorIdade").is(':checked')) {
                $("#chkFormacao, #chkFormacaoAcademica, #chkPorPeriodoProvincia").attr("checked", false);
                $("#selTiposFormacoes, #selComunidades, #selEscolaridades").val(0);
                $("#porFormacao, #porFormacaoAcademica").hide();
                $("#porPeriodoProvincia").hide();
                $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

                $("#porIdade").show();
                $("#txtDe").focus();
            } else {
                $("#txtDe, #txtAte").val("");
                $("#porIdade").hide();
            }
        });

        if ($("#chkFormacao").is(':checked')) {
            $("#chkPorIdade, #chkFormacaoAcademica, #chkPorPeriodoProvincia").attr("checked", false);
            $("#selEscolaridades").val(0);
            $("#porIdade").hide();
            $("#porFormacaoAcademica").hide();
            $("#porPeriodoProvincia").hide();
            $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

            $("#porFormacao").show();
            $("#porFormacaoPeriodo").show();
            $("#selTiposFormacoes").focus();
        } else {
            $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
            $("#txtDeFormacao, #txtParaFormacao").val("");
            $("#porFormacao").hide();
            $("#porFormacaoPeriodo").hide();
        }

        $("#chkFormacao").click(function() {
            if ($("#chkFormacao").is(':checked')) {
                $("#chkPorIdade, #chkFormacaoAcademica, #chkPorPeriodoProvincia").attr("checked", false);
                $("#selEscolaridades").val(0);
                $("#porIdade").hide();
                $("#porFormacaoAcademica").hide();
                $("#porPeriodoProvincia").hide();
                $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

                $("#porFormacao").show();
                $("#porFormacaoPeriodo").show();
                $("#selTiposFormacoes").focus();
            } else {
                $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
                $("#txtDeFormacao, #txtParaFormacao").val("");
                $("#porFormacao").hide();
                $("#porFormacaoPeriodo").hide();
            }
        });

        if ($("#chkFormacaoAcademica").is(':checked')) {
            $("#chkPorIdade, #chkFormacao, #chkPorPeriodoProvincia").attr("checked", false);
            $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
            $("#porIdade").hide();
            $("#porFormacao").hide();
            $("#porPeriodoProvincia").hide();
            $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

            $("#porFormacaoAcademica").show();
            $("#selEscolaridades").focus();
        } else {
            $("#selEscolaridades").val(0);
            $("#porFormacaoAcademica").hide();
        }

        $("#chkFormacaoAcademica").click(function() {
            if ($("#chkFormacaoAcademica").is(':checked')) {
                $("#chkPorIdade, #chkFormacao, #chkPorPeriodoProvincia").attr("checked", false);
                $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
                $("#porIdade").hide();
                $("#porFormacao").hide();
                $("#porPeriodoProvincia").hide();
                $("#txtDe, #txtAte, #txtInicio, #txtFinal").val("");

                $("#porFormacaoAcademica").show();
                $("#selEscolaridades").focus();
            } else {
                $("#selEscolaridades").val(0);
                $("#porFormacaoAcademica").hide();
            }
        });

        if ($("#chkPorPeriodoProvincia").is(':checked')) {
            $("#chkPorIdade, #chkFormacao, #chkFormacaoAcademica").attr("checked", false);
            $("#txtDe, #txtAte").val("");
            $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
            $("#porIdade").hide();
            $("#porFormacao").hide();
            $("#porFormacaoAcademica").hide();

            $("#porPeriodoProvincia").show();
            $("#txtInicio").focus();
        } else {
            $("#txtInicio, #txtFinal").val("");
            $("#porPeriodoProvincia").hide();
        }

        $("#chkPorPeriodoProvincia").click(function() {
            if ($("#chkPorPeriodoProvincia").is(':checked')) {
                $("#chkPorIdade, #chkFormacao, #chkFormacaoAcademica").attr("checked", false);
                $("#txtDe, #txtAte").val("");
                $("#selTiposFormacoes, #selComunidadesFormacoes").val(0);
                $("#porIdade").hide();
                $("#porFormacao").hide();
                $("#porFormacaoAcademica").hide();

                $("#porPeriodoProvincia").show();
                $("#txtInicio").focus();
            } else {
                $("#txtInicio, #txtFinal").val("");
                $("#porPeriodoProvincia").hide();
            }
        });
    </script>


@endsection
