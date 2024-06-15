@extends('templates.main')

@section('title', 'Nova Transferencia')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Transferencia</h2>
    </div>

    <form action="{{ request()->is('pessoal/transferencia/new') ? route('transferencia.create') : route('transferencia.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->id }}" name="id" hidden>
            {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="col-12">
                                <label for="data_saida" class="form-label">Transferencia<span class="required">*</span></label>
                                <select class="form-select" id="tipo_instituicoes" name="tipo_instituicoes" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->data_saida }}" required>
                                    @forelse($dados as $r)
                                        <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                    @empty
                                        <option>Nenhum tipo cadastrado</option>
                                    @endforelse
                                </select>
                            </div>


                         <div class="col-4">
                                <label for="descricao" class="form-label">Data Transferencia	<span class="required">*</span></label>
                                <input type="date" class="form-control" id="data_transferencia" name="descricao" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->readmissao }}" required>
                        </div>

                         <div class="col-4">
                                <label for="site" class="form-label">Pessoa<span class="required">*</span></label>
                                <input type="text" class="form-control" id="pessoa" name="site" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->pessoa }}" required></input>
                         </div>

                        <div class="col-4">
                                <label for="site" class="form-label">Comunidade Origem	<span class="required">*</span></label>
                                <input type="text" class="form-control" id="comunidade_origem" name="site" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->comunidade_origem }}" required></input>
                        </div>

                        <div class="col-4">
                            <label for="site" class="form-label">Província Destino<span class="required">*</span></label>
                            <input type="text" class="form-control" id="provincia" name="site" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->provincia }}" required></input>
                        </div>

                        <div class="col-4">
                            <label for="site" class="form-label">Comunidade  Destino<span class="required">*</span></label>
                            <input type="text" class="form-control" id="comunidade_provincia" name="site" value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->comunidade_provincia }}" required></input>
                        </div>



                        <div class="row mt-4">
                            <div>

                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>

                    </div>
                {{-- SEGUNDA COLUNA --}}



            </div>

        </div>
    </form>

@endsection
