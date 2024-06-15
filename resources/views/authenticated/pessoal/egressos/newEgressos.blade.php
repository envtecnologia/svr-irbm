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

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->id }}" name="id" hidden>
            {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="col-12">
                                <label for="data_saida" class="form-label">Egresso<span class="required">*</span></label>
                                <select class="form-select" id="tipo_instituicoes" name="tipo_instituicoes" value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->data_saida }}" required>
                                    @forelse($dados as $r)
                                        <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                    @empty
                                        <option>Nenhum tipo cadastrado</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="cnpj" class="form-label">Data Saída	<span class="required">*</span></label>
                                <input type="date" class="form-control" id="data_saida" name="cnpj" value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->data_saida }}" required>
                            </div>


                         <div class="col-4">
                                <label for="descricao" class="form-label">Data Regresso	<span class="required">*</span></label>
                                <input type="date" class="form-control" id="data_regresso" name="descricao" value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->readmissao }}" required>
                        </div>

                        <div class="row mt-2">
                            <div class="col-8">
                                <label for="site" class="form-label">Detalhes<span class="required">*</span></label>
                                <textarea type="text" class="form-control" id="site" name="site" value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->egresso }}" required></textarea>
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
