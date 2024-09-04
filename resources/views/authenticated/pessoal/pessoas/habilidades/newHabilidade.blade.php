@extends('templates.main')

@section('title', 'Nova Habilidade')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Habilidade</h2>
    </div>

    <form
        action="{{ Route::currentRouteName() === 'pessoas.habilidades.create' ? route('pessoas.habilidades.store', ['pessoa_id' => $pessoa_id]) : route('pessoas.habilidades.update', ['pessoa_id' => $pessoa_id, 'habilidade' => $dados->id]) }}"
        method="POST">
        @csrf

        @if(Route::currentRouteName() === 'pessoas.habilidades.edit')
            @method('PUT')
        @endif

        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ Route::currentRouteName() === 'pessoas.habilidades.create' ? '' : $dados->id }}"
                        name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col-10">
                                    <label for="cod_tipo_habilidade_id" class="form-label">Tipo Habilidade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipo_habilidade_id" name="cod_tipo_habilidade_id"
                                        value="{{ Route::currentRouteName() === 'pessoas.habilidades.create' ? '' : $dados->cod_tipo_habilidade_id }}">
                                        <option value="">Selecione...</option>
                                        @forelse($tipos_habilidade as $r)
                                            <option value="{{ $r->id }}"
                                                {{ (Route::currentRouteName() === 'pessoas.habilidades.create' ? old('cod_tipo_habilidade_id') : $dados->cod_tipo_habilidade_id) == $r->id ? 'selected' : '' }}>
                                                {{ $r->descricao }}</option>
                                        @empty
                                            <option value="">Geral</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-2">
                                    <label for="grau" class="form-label">Grau</label>
                                    <input class="form-control" id="number" name="grau" value="{{ Route::currentRouteName() === 'pessoas.habilidades.create' ? '' : $dados->grau }}">
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
