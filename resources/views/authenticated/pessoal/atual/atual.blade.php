@extends('templates.main')

@section('title', 'Comunidades Atuais')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Relatórios de Comunidades Atuais ({{ $dados->total() }})</h2>
    </div>

    <form id="search" action="{{ route('atual.imprimir') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-10">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
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
                            <div class="col-6">
                                <label for="nome" class="form-label">Pessoa</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    value="{{ request()->has('nome') ? request()->input('nome') : '' }}">
                            </div>

                            {{-- <div class="col-6">
                                <label for="cod_comunidade_id" class="form-label">Comunidades<span
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
                            </div> --}}

                        </div>

                        <div class="row g-3 align-items-center mt-1">


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
    </form>

    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Província</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Pessoa</th>



                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            @if ($dado->itinerarios->isNotEmpty()) {{-- Verifica se há itinerários --}}
                                @php
                                    $itinerario = $dado->itinerarios->first(); // Obtém o itinerário mais recente
                                    $comAtual = $itinerario->com_atual; // Acessa a relação com_atual
                                @endphp
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $comAtual->provincia->descricao }}</td>
                                    <td>{{ $comAtual->descricao }}</td>
                                    <td>{{ $dado->nome }}</td>




                                </tr>
                                @endif
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
                        <input type="text" name="modulo" value="atual" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorios/pessoal/atual') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="action-button">{{ request()->is('relatorios/pessoal/atual') ? 'Imprimir' : 'Novo +' }}</button>
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
