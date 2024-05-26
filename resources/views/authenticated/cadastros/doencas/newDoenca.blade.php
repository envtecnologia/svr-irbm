@extends('templates.main')

@section('title', 'Nova Doença')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Doença</h2>
    </div>

    <form action="{{ request()->is('cadastros/doencas/new') ? route('doencas.create') : route('doencas.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">

                    <div class="col-6 mb-3">
                        <input value="{{ request()->is('cadastros/doencas/new') ? '' : $dados->id }}" name="id" hidden>
                         <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ request()->is('cadastros/doencas/new') ? '' : $dados->descricao }}" required>
                        <label for="detalhes">Detalhes</label>
                        <textarea class="form-control" id="detalhes" name="detalhes">{{ request()->is('cadastros/doencas/new') ? '' : $dados->detalhes }}</textarea>

                        <div class="row mt-2">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>

                    </div>



                </div>




            </div>

        </div>
    </form>

@endsection
