@extends('templates.main')

@section('title', 'Novo Capítulo')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Capítulo</h2>
    </div>

    <form action="{{ Route::currentRouteName() === 'pessoas.cursos.create' ? route('capitulos.create') : route('capitulos.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ Route::currentRouteName() === 'pessoas.cursos.create' ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="cod_tipocurso_id" class="form-label">Curso<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipocurso_id" name="cod_tipocurso_id"
                                        value="{{ Route::currentRouteName() === 'pessoas.cursos.create' ? '' : $dados->cod_tipocurso_id }}"
                                        >
                                        <option value="">Selecione...</option>
                                        @forelse($tipo_cursos as $r)
                                            <option value="{{ $r->id }}" {{ (Route::currentRouteName() === 'pessoas.cursos.create' ? old('cod_tipocurso_id') : $dados->cod_tipocurso_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="numero" class="form-label">Número<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="numero" name="numero"
                                        value="{{ Route::currentRouteName() === 'pessoas.cursos.create' ? '' : $dados->numero }}"
                                        required>
                                </div>

                                <div class="col-6">
                                    <label for="data" class="form-label">Data<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="data" name="data"
                                        value="{{ Route::currentRouteName() === 'pessoas.cursos.create' ? '' : $dados->data }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.cursos.create' ? '' : $dados->detalhes }}</textarea>
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
