@extends('templates.main')

@section('title', 'Nova Egresso')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Egresso</h2>
    </div>

    <form action="{{ request()->is('pessoal/egressos/new') ? route('egressos.create') : route('egressos.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                @csrf

                <div class="row justify-content-center g-3 d-flex mt-5">
                    <div class="col-12">
                        <div class="row d-flex justify-content-center g-3">
                            <input value="{{ request()->is('pessoal/egressos/new') ? '' : ($dados->id ?? '') }}" name="id" hidden>

                            {{-- PRIMEIRA COLUNA --}}
                            <div class="col-6 mb-3">
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="data_saida" class="form-label">Egresso<span class="required">*</span></label>
                                        <select class="form-select" id="cod_pessoa_id" name="cod_pessoa_id" required>
                                            @if(isset($dados) && !empty($dados->cod_pessoa_id))
                                                <option value="{{ $dados->cod_pessoa_id }}">{{ $dados->descricao }}</option>
                                            @else
                                                <option>Nenhum tipo cadastrado</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="data_saida" class="form-label">Data Saída<span class="required">*</span></label>
                                        <input type="date" class="form-control" id="data_saida" name="data_saida" value="{{ request()->is('pessoal/egressos/new') ? '' : ($dados->data_saida ?? '') }}" required>
                                    </div>

                                    <div class="col-4">
                                        <label for="descricao" class="form-label">Data Regresso<span class="required">*</span></label>
                                        <input type="date" class="form-control" id="data_regresso" name="data_regresso" value="{{ request()->is('pessoal/egressos/new') ? '' : ($dados->data_regresso ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEGUNDA COLUNA --}}



            </div>

        </div>
    </form>

@endsection
