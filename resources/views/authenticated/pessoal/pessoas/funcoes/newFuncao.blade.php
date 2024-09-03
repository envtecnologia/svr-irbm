@extends('templates.main')

@section('title', 'Nova função')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/pessoas/funcoes') ? route('pessoas.funcoes.index') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (Route::currentRouteName() == 'pessoas.funcoes.create')
                    Nova
                @else
                    Editar
                @endif
                função
            </h2>

        </div>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ Route::currentRouteName() === 'pessoas.funcoes.edit' ? route('pessoas.funcoes.update', ['pessoa_id' => $pessoa_id, 'funco' => $funco]) : route('pessoas.funcoes.store', ['pessoa_id' => $pessoa_id, 'funcao' => $funcao])  }}"
        method="POST">
        @csrf

        @if (Route::currentRouteName() === 'pessoas.funcoes.edit')
            @method('PUT')
        @endif

        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">

                    <div class="col-6 mb-3">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cod_tipo_funcao_id" class="form-label">Função<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipo_funcao_id" name="cod_tipo_funcao_id"
                                        required>
                                        <option value="">Selecione...</option>
                                        @forelse($funcao as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'pessoas.funcoes.edit' && $r->id == $dados->cod_tipo_funcao_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma função cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cod_provincia_id" class="form-label">Provincia<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_provincia_id" name="cod_provincia_id"
                                        required>
                                        <option value="">Selecione...</option>
                                        @forelse($provincias as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'pessoas.funcoes.edit' && $r->id == $dados->cod_provincia_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma provincia cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row rounded p-2 mb-3">

                            <label for="cod_comunidade_id" class="form-label">Comunidade<span
                                    class="required">*</span></label>
                            <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id" required>
                                <option value="">Selecione...</option>
                                @forelse($comunidades as $r)
                                    <option value="{{ $r->id }}" @if (Route::currentRouteName() === 'pessoas.funcoes.edit' && $r->id == $dados->cod_comunidade_id) selected @endif>
                                        {{ $r->descricao }}
                                    </option>

                                @empty
                                    <option>Nenhuma comunidade cadastrada</option>
                                @endforelse
                            </select>

                        </div>

                        <div class="row mt-2">

                            <div class="col-6">
                                <label for="data" class="form-label">Data<span class="required">*</span></label>
                                <input type="date" id="data" name="datainicio" class="form-control"
                                    value="{{ Route::currentRouteName() === 'pessoas.funcoes.edit' ? $dados->datainicio : '' }}">
                            </div>


                        </div>

                        <div class="row mt-2">

                            <div class="col-6">
                                <label for="data" class="form-label">Data<span class="required">*</span></label>
                                <input type="date" id="data" name="datafinal" class="form-control"
                                    value="{{ Route::currentRouteName() === 'pessoas.funcoes.edit' ? $dados->datafinal : '' }}">
                            </div>


                        </div>



                        <div class="row mt-2">
                            <div class="col-12">
                                <input value="{{ $pessoa_id }}" name="cod_pessoa_id" hidden>

                                <label for="detalhes" class="form-label">Detalhes<span class="required">*</span></label>
                                <textarea type="text" class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.funcoes.edit' ? $dados->detalhes : '' }}</textarea>
                            </div>
                        </div>



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
