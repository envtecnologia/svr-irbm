@extends('templates.main')

@section('title', 'Nova Ocorrência Médica')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Ocorrência Médica</h2>
    </div>

    <form action="{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? route('pessoas.ocorrenciasMedicas.store', ["pessoa_id" => $pessoa_id]) : route('pessoas.ocorrenciasMedicas.update', ["pessoa_id" => $pessoa_id, "ocorrenciasMedica" => $dados->id]) }}"
        method="POST">
        @csrf

        @if(Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.edit')
            @method('PUT')
        @endif

        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_doenca_id" class="form-label">Doença<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_doenca_id" name="cod_doenca_id">
                                        <option value="">Selecione...</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? old('cod_doenca_id') : $dados->cod_doenca_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
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
                                    <select class="form-select" id="cod_tipo_tratamento_id" name="cod_tipo_tratamento_id">
                                        <option value="">Selecione...</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? old('cod_tipo_tratamento_id') : $dados->cod_tipo_tratamento_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
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
                                    <select class="form-select" id="cod_tipo_ocorrencia_id" name="cod_tipo_ocorrencia_id"
                                        value="{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? '' : $dados->cod_doenca_id }}"
                                        >
                                        <option value="">Selecione...</option>
                                        @forelse($doencas as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? old('cod_tipo_ocorrencia_id') : $dados->cod_tipo_ocorrencia_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>


                            <div class="row mt-2">

                                <div class="col-6">
                                    <label for="datainicio" class="form-label">Data Início<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="datainicio" name="datainicio"
                                        value="{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? '' : $dados->datainicio }}"
                                        required>
                                </div>

                                <div class="col-6">
                                    <label for="datafinal" class="form-label">Data Final<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="datafinal" name="datafinal"
                                        value="{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? '' : $dados->datafinal }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.ocorrenciasMedicas.create' ? '' : $dados->detalhes }}</textarea>
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
