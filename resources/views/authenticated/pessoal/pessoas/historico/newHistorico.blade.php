@extends('templates.main')

@section('title', 'Novo Historico')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Historico</h2>
    </div>


    <form
        action="{{ Route::currentRouteName() === 'pessoas.historico.edit' ? route('pessoas.historico.update', ['pessoa_id' => $pessoa_id, 'historico' => $dados->id]) : route('pessoas.historico.store', ['pessoa_id' => $pessoa_id]) }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ Route::currentRouteName() === 'pessoas.historico.edit' ? route('pessoas.historico.update', ['pessoa_id' => $pessoa_id, 'historico' => $dados->id]) : route('pessoas.historico.store', ['pessoa_id' => $pessoa_id]) }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="detalhes" class="form-label">Detalhes</label>
                                    <textarea class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.historico.edit' ? $dados->detalhes : '' }}</textarea>
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
