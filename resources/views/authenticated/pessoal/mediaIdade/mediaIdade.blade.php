@extends('templates.main')

@section('title', 'medIdade')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Media Idade ({{ $total }})</h2>
    </div>

    <form id="search" action="{{ route('mediaIdade.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

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


                            <div
                                class="{{ request()->is('search/medIdade') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/medIdade'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/medIdade">Limpar
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
                            <th scope="col">Até 20 anos </th>
                            <th scope="col">21 a 30 anos</th>
                            <th scope="col">31 a 40 anos</th>
                            <th scope="col">41 a 50 anos</th>
                            <th scope="col">51 a 60 anos</th>
                            <th scope="col">61 a 70 anos</th>
                            <th scope="col">71 a 80 anos</th>
                            <th scope="col">81 a 90 anos</th>
                            <th scope="col">Acima de 90 anos</th>
                            <th scope="col">Média de Idade</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <th scope="row">{{ $vinte }} ({{ number_format($vinte_porcentagem, 2) }}%)</th>
                            <td>{{ $trinta }} ({{ number_format($trinta_porcentagem, 2) }}%)</td>
                            <td>{{ $quarenta }} ({{ number_format($quarenta_porcentagem, 2) }})%</td>
                            <td>{{ $cinquenta }} ({{ number_format($cinquenta_porcentagem, 2) }}%)</td>
                            <td>{{ $sessenta }} ({{ number_format($sessenta_porcentagem, 2) }}%)</td>
                            <td>{{ $setenta }} ({{ number_format($setenta_porcentagem, 2) }})%</td>
                            <td>{{ $oitenta }} ({{ number_format($oitenta_porcentagem, 2) }}%)</td>
                            <td>{{ $noventa }} ({{ number_format($noventa_porcentagem, 2) }}%)</td>
                            <td>{{ $acima_noventa }} ({{ number_format($acima_porcentagem, 2) }}%)</td>
                            <td> {{ $mediaIdades }}</td>

                            @if (!request()->is('relatorio/rede/medIdade'))
                                {{-- <td> --}}
                                <!-- Botão de editar -->
                                {{-- <a class="btn-action" href="{{ route('medIdade.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a> --}}

                                <!-- Botão de excluir (usando um formulário para segurança) -->
                                {{-- <form action="{{ route('medIdade.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form> --}}
                                {{-- </td> --}}
                            @endif

                        </tr>


                    </tbody>
                </table>

                <!-- Links de paginação -->
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{-- {{ $dados->links() }} --}}
                    </div>
                </div>

                <div class="{{ request()->is('search/medIdade') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                    <div>
                        <div class="mb-2">
                            <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                                @csrf
                                <input type="text" name="modulo" value="mediaIdade" hidden>
                                <input type="text" name="action"
                                    value="{{ request()->is('relatorios/pessoal/mediaIdade') ? 'pdf' : 'insert' }}" hidden>
                                <button class="btn btn-custom inter inter-title"
                                    id="{{ request()->is('relatorios/pessoal/mediaIdade') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/mediaIdade') ? 'Imprimir' : 'Novo +' }}</button>
                            </form>
                        </div>
                        @if (request()->is('search/medIdade'))
                            <a class="btn btn-custom inter inter-title" href="/controle/medIdade">Limpar Pesquisa</a>
                        @endif
                    </div>
                </div>


            </div>

        </div>
    </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
