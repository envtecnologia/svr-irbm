@extends('templates.main')

@section('title', 'Nova Egresso')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/egressos') ? route('egressos') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (request()->is('pessoal/egressos/new'))
                    Novo
                @else
                    Editar
                @endif
                Egresso
            </h2>

        </div>

    </div>

    <form action="{{ request()->is('pessoal/egressos/new') ? route('egressos.create') : route('egressos.update') }}"
        method="POST">
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
                                <select class="form-select" id="cod_pessoa_id" name="cod_pessoa_id" required>
                                    <option value="">Selecione...</option>
                                    @forelse($pessoas as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'egressos.edit' && $r->id == $dados->pessoa->id) selected @endif>
                                            {{ $r->nome }}
                                        </option>

                                    @empty
                                        <option>Nenhuma pessoa cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                        </div>

                        <div class="row mt-2">

                            <div class="col-6">
                                <label for="data_saida" class="form-label">Data Saída <span
                                        class="required">*</span></label>
                                <input type="date" class="form-control" id="data_saida" name="data_saida"
                                    value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->data_saida }}" required>
                            </div>


                            <div class="col-6">
                                <label for="data_readmissao" class="form-label">Data Regresso <span
                                        class="required">*</span></label>
                                <input type="date" class="form-control" id="data_readmissao" name="data_readmissao"
                                    value="{{ request()->is('pessoal/egressos/new') ? '' : $dados->data_readmissao }}" required>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <label for="detalhes" class="form-label">Detalhes<span class="required">*</span></label>
                                <textarea type="text" class="form-control" id="detalhes" name="detalhes" required>{{ request()->is('pessoal/egressos/new') ? '' : $dados->detalhes }}</textarea>
                            </div>

                        </div>



                        <div class="row mt-4">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>

                        {{-- SEGUNDA COLUNA --}}




                    </div>
    </form>

@endsection
