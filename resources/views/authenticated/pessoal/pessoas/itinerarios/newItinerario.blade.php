@extends('templates.main')

@section('title', 'Novo Itinerário')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Itinerário</h2>
    </div>

    <form action="{{ Route::currentRouteName() === 'pessoas.itinerarios.create' ? route('pessoas.itinerarios.store', ['pessoa_id' => $pessoa_id]) : route('pessoas.itinerarios.update', ['pessoa_id' => $pessoa_id, 'itinerario' => $dados->id]) }}"
        method="POST">
        @csrf

        @if(Route::currentRouteName() === 'pessoas.itinerarios.edit')
            @method('PUT')
        @endif

        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ Route::currentRouteName() === 'pessoas.itinerarios.create' ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_comunidade_atual_id" class="form-label">Comunidade Atual<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_comunidade_atual_id" name="cod_comunidade_atual_id">
                                        <option value="">Selecione...</option>
                                        @forelse($comunidades as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.itinerarios.create' ? old('cod_comunidade_atual_id') : $dados->cod_comunidade_atual_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_comunidade_anterior_id" class="form-label">Comunidade Anterior<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_comunidade_anterior_id" name="cod_comunidade_anterior_id">
                                        <option value="">Selecione...</option>
                                        @forelse($comunidades as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.itinerarios.create' ? old('cod_comunidade_anterior_id') : $dados->cod_comunidade_anterior_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_comunidade_destino_id" class="form-label">Comunidade Destino<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_comunidade_destino_id" name="cod_comunidade_destino_id">
                                        <option value="">Selecione...</option>
                                        @forelse($comunidades as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.itinerarios.create' ? old('cod_comunidade_destino_id') : $dados->cod_comunidade_destino_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="chegada" class="form-label">Data Chegada<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="chegada" name="chegada"
                                        value="{{ Route::currentRouteName() === 'pessoas.itinerarios.create' ? '' : $dados->chegada }}"
                                        required>
                                </div>

                                <div class="col-6">
                                    <label for="saida" class="form-label">Data Saída<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="saida" name="saida"
                                        value="{{ Route::currentRouteName() === 'pessoas.itinerarios.create' ? '' : $dados->saida }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.itinerarios.create' ? '' : $dados->detalhes }}</textarea>
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
