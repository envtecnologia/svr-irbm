@extends('templates.main')

@section('title', 'Novo Capítulo')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Capítulo</h2>
    </div>

    <form action="{{ request()->is('controle/capitulos/new') ? route('capitulos.create') : route('capitulos.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('controle/capitulos/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_doencia_id" class="form-label">Doença<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_doencia_id" name="cod_doencia_id"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->cod_doenca_id }}"
                                        >
                                        <option value="">Geral</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (request()->is('controle/capitulos/new') ? old('cod_doencia_id') : $dados->cod_doencia_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_tipo_tratamento_id" class="form-label">Tipo de Tratamento<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipo_tratamento_id" name="cod_tipo_tratamento_id"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->cod_doenca_id }}"
                                        >
                                        <option value="">Geral</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (request()->is('controle/capitulos/new') ? old('cod_tipo_tratamento_id') : $dados->cod_tipo_tratamento_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_tipo_ocorrencia_id" class="form-label">Tipo de Ocorrência<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_ocorrencia_tratamento_id" name="cod_ocorrencia_tratamento_id"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->cod_doenca_id }}"
                                        >
                                        <option value="">Geral</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (request()->is('controle/capitulos/new') ? old('cod_tipo_tratamento_id') : $dados->cod_tipo_tratamento_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>


                            <div class="row mt-2">

                                <div class="col-6">
                                    <label for="data" class="form-label">Data<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="datainicio" name="datainicio"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->datainicio }}"
                                        required>
                                </div>

                                <div class="col-6">
                                    <label for="data" class="form-label">Data<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="datafinal" name="datafinal"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->datafinal }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ request()->is('controle/capitulos/new') ? '' : $dados->detalhes }}</textarea>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                                </div>
                            </div>

                        </div>





                    </div>

                </div>
    </form>

@endsection
