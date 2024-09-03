@extends('templates.main')

@section('title', 'Nova Transferencia')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/transferencias') ? route('transferencias') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (request()->is('pessoal/transferencia/new'))
                    Nova
                @else
                    Editar
                @endif
                Transferência
            </h2>

        </div>

    </div>

    <form
        action="{{ request()->is('pessoal/transferencia/new') ? route('transferencia.create') : route('transferencia.update') }}"
        method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->id }}" name="id" hidden>
                    {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">

                            <div class="col-8">
                                <label for="cod_pessoa_id" class="form-label">Pessoa<span class="required">*</span></label>
                                <select class="form-select" id="cod_pessoa_id" name="cod_pessoa_id" required>
                                    <option value="">Selecione...</option>
                                    @forelse($pessoas as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'transferencia.edit' && $r->id == $dados->pessoa->id) selected @endif>
                                            {{ $r->nome }}
                                        </option>

                                    @empty
                                        <option>Nenhuma pessoa cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="data_transferencia" class="form-label">Data Transferencia<span
                                        class="required">*</span></label>
                                <input type="date" class="form-control" id="data_transferencia" name="data_transferencia"
                                    value="{{ request()->is('pessoal/transferencia/new') ? '' : $dados->data_transferencia }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label for="cod_provinciaori" class="form-label">Província de Origem<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_provinciaori" name="cod_provinciaori" required>
                                    <option value="">Selecione...</option>
                                    @forelse($provincias as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'transferencia.edit' && $r->id == $dados->cod_provinciaori) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma província cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="cod_comunidadeori" class="form-label">Comunidade de Origem<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_comunidadeori" name="cod_comunidadeori" required>
                                    <option value="">Selecione...</option>
                                    @forelse($comunidades as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'transferencia.edit' && $r->id == $dados->cod_comunidadeori) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma comunidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="cod_provinciades" class="form-label">Província de Destino<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_provinciades" name="cod_provinciades" required>
                                    <option value="">Selecione...</option>
                                    @forelse($provincias as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'transferencia.edit' && $r->id == $dados->cod_provinciades) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma província cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="cod_comunidadedes" class="form-label">Comunidade de Destino<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_comunidadedes" name="cod_comunidadedes" required>
                                    <option value="">Selecione...</option>
                                    @forelse($comunidades as $r)
                                        <option value="{{ $r->id }}"
                                            @if (Route::currentRouteName() === 'transferencia.edit' && $r->id == $dados->cod_comunidadedes) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma comunidade cadastrada</option>
                                    @endforelse
                                </select>
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
