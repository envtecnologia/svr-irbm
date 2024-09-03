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
                                    <label for="cod_tipo_habilidade_id" class="form-label">Tipo Habilidade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipo_habilidade_id" name="cod_tipo_habilidade_id"
                                        value="{{ request()->is('controle/capitulos/new') ? '' : $dados->cod_tipo_habilidade_id }}"
                                        >
                                        <option value="">Geral</option>
                                        @forelse($provincias as $r)
                                            <option value="{{ $r->id }}" {{ (request()->is('controle/capitulos/new') ? old('cod_tipo_habilidade_id') : $dados->cod_tipo_habilidade_id) == $r->id ? 'selected' : '' }}>{{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="grau" class="form-label">Grau</label>
                                    <textarea class="form-control" id="grau" name="grau">{{ request()->is('controle/capitulos/new') ? '' : $dados->grau }}</textarea>
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
