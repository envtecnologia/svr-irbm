@extends('templates.main')

@section('title', 'Nova Falecimento')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Novo Falecimento</h2>
    </div>

    <form action="{{ request()->is('pessoal/falecimentos/new') ? route('falecimentos.create') : route('falecimentos.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->id }}" name="id" hidden>
            {{-- PRIMEIRA COLUNA --}}
            <div class="col-6 mb-3">
                <h3>Dados Principais</h3>
                <div class="row mt-2">
                    <div class="col-12">
                        <label for="data_saida" class="form-label">Novo Cadastro de Falecida(o) <span class="required">*</span></label>
                        <select class="form-select" id="tipo_instituicoes" name="tipo_instituicoes" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->data_saida }}" required>
                            @forelse($dados as $r)
                                <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                            @empty
                                <option>Nenhum tipo cadastrado</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="falecida" class="form-label">Falecida(o)(*) <span class="required">*</span></label>
                        <input type="date" class="form-control" id="falecida" name="cnpj" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->data_saida }}" required>
                    </div>
                    <div class="col-4">
                        <label for="data_falecida" class="form-label">Data(*) <span class="required">*</span></label>
                        <input type="date" class="form-control" id="data_falecida" name="descricao" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->data_falecida }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="jazigo" class="form-label">Jazigo <span class="required">*</span></label>
                        <input type="text" class="form-control" id="jazigo" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->jazigo }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="certidao" class="form-label">Certidão No. <span class="required">*</span></label>
                        <input type="text" class="form-control" id="certidao" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="data_certidao" class="form-label">Data Certidão <span class="required">*</span></label>
                        <input type="text" class="form-control" id="data_certidao" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->data_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="livro_certidao" class="form-label">Livro Certidão <span class="required">*</span></label>
                        <input type="text" class="form-control" id="livro_certidao" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->livro_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="zona_certidao" class="form-label">Zona Certidão <span class="required">*</span></label>
                        <input type="text" class="form-control" id="zona_certidao" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->zona_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="translado" class="form-label">Translado <span class="required">*</span></label>
                        <input type="text" class="form-control" id="translado" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->falecimento }}" required>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-8">
                        <div class="row mt-4">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>




            <div class="col-6 mb-3">
                <h3>Motivos</h3>
                <div class="row mt-2">
                    <div class="col-8">
                        <label for="doenca1" class="form-label">Doença1 <span class="required">*</span></label>
                        <input type="text" class="form-control" id="doenca1" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->data_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="doenca2" class="form-label">Doença2 <span class="required">*</span></label>
                        <input type="text" class="form-control" id="doenca2" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->livro_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="doenca3" class="form-label">Doença3 <span class="required">*</span></label>
                        <input type="text" class="form-control" id="doenca3" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->zona_certidao }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <label for="detalhes" class="form-label">Detalhes <span class="required">*</span></label>
                        <input type="text" class="form-control" id="detalhes" name="site" value="{{ request()->is('pessoal/falecimentos/new') ? '' : $dados->falecimento }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-8">
                        <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                    </div>
                </div>
            </div>




    </form>

@endsection
