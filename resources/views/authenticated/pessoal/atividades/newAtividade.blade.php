@extends('templates.main')

@section('title', 'Nova Atividade')

@section('content')

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/pessoas/atividades') ? route('pessoas.atividades.index') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                @if (Route::currentRouteName() == 'pessoas.atividades.create')
                    Nova
                @else
                    Editar
                @endif
                Atividade
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

    <form action="{{ route('pessoas.atividades.store', ['pessoa_id' => $pessoa_id]) }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">

                    <div class="col-6 mb-3">

                        <div class="row rounded p-2 mb-3" style="background-color: #e0dac5">

                            <label for="cod_comunidade_id" class="form-label">Comunidade<span
                                    class="required">*</span></label>
                            <select class="form-select" id="cod_comunidade_id" name="cod_comunidade_id" required>
                                <option value="">Selecione...</option>
                                @forelse($comunidades as $r)
                                    <option value="{{ $r->id }}"
                                        @if (Route::currentRouteName() === 'pessoas.atividades.edit' && $r->id == $dados->cod_comunidade_id) selected @endif>
                                        {{ $r->descricao }}
                                    </option>

                                @empty
                                    <option>Nenhuma comunidade cadastrada</option>
                                @endforelse
                            </select>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cod_tipoatividade_id" class="form-label">Tipo de atividade<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_tipoatividade_id" name="cod_tipoatividade_id"
                                        required>
                                        <option value="">Selecione...</option>
                                        @forelse($tipos_atividades as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'pessoas.atividades.edit' && $r->id == $dados->cod_tipoatividade_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma atividade cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cod_obra_id" class="form-label">Obra<span
                                            class="required">*</span></label>
                                    <select class="form-select" id="cod_obra_id" name="cod_obra_id" required>
                                        <option value="">Selecione...</option>
                                        @forelse($obras as $r)
                                            <option value="{{ $r->id }}"
                                                @if (Route::currentRouteName() === 'pessoas.atividades.edit' && $r->id == $dados->cod_obra_id) selected @endif>
                                                {{ $r->descricao }}
                                            </option>

                                        @empty
                                            <option>Nenhuma obra cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-2">

                            <div class="col-6">
                                <label for="datainicio" class="form-label">Chegada<span
                                        class="required">*</span></label>
                                <input type="date" id="datainicio" name="datainicio" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.atividades.edit' ? $dados->datainicio : '' }}">
                            </div>

                            <div class="col-6">
                                <label for="datafinal" class="form-label">Saída</label>
                                <input type="date" id="datafinal" name="datafinal" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.atividades.edit' ? $dados->datafinal : '' }}">
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <label for="responsavel" class="form-label">Responsável</label>
                                <input type="text" name="responsavel" class="form-control" value="{{ Route::currentRouteName() === 'pessoas.atividades.edit' ? $dados->responsavel : '' }}">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <input value="{{ $pessoa_id }}" name="cod_pessoa_id" hidden>

                                <label for="detalhes" class="form-label">Detalhes<span class="required">*</span></label>
                                <textarea type="text" class="form-control" id="detalhes" name="detalhes">{{ Route::currentRouteName() === 'pessoas.atividades.edit' ? $dados->responsavel : '' }}</textarea>
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
