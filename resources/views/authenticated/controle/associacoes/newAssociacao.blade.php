@extends('templates.main')

@section('title', 'Nova Associação')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Nova Associação</h2>
    </div>

    <form action="{{ request()->is('controle/associacoes/new') ? route('associacoes.create') : route('associacoes.update') }}" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-12">

                <div class="row d-flex justify-content-center g-3">
                    <input value="{{ request()->is('controle/associacoes/new') ? '' : $dados->id }}" name="id" hidden>
            {{-- PRIMEIRA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="col-8">
                                <label for="tipo_instituicoes" class="form-label">Tipo de Instituição<span class="required">*</span></label>
                                <select class="form-select" id="tipo_instituicoes" name="tipo_instituicoes" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->tipo_instituicoes_id }}" required>
                                    @forelse($tipo_instituicoes as $r)
                                        <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                                    @empty
                                        <option>Nenhum tipo cadastrado</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="cnpj" class="form-label">CNPJ<span class="required">*</span></label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->cnpj }}" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                                <input type="text" class="form-control" id="descricao" name="descricao" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->descricao }}" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-8">
                                <label for="site" class="form-label">Site<span class="required">*</span></label>
                                <input type="text" class="form-control" id="site" name="site" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->site }}" required>
                            </div>

                            <div class="col-4">
                                <label for="caixapostal" class="form-label">Caixa Postal<span class="required">*</span></label>
                                <input type="text" class="form-control" id="caixapostal" name="caixapostal" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->caixapostal }}" required>
                            </div>
                        </div>

                        <div class="row mt-2 pb-4 hr">
                            <div class="col">
                                <label for="email" class="form-label">E-mail<span class="required">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->email }}" required>
                            </div>
                        </div>



                        <div class="row mt-4">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                            </div>
                        </div>

                    </div>
                {{-- SEGUNDA COLUNA --}}
                    <div class="col-6 mb-3">

                        <div class="row mt-2">
                            <div class="col-8">
                                <label for="endereco" class="form-label">Endereço<span class="required">*</span></label>
                                <input type="text" class="form-control" id="endereco" name="endereco" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->endereco }}" required>
                            </div>

                            <div class="col-4">
                                <label for="cep" class="form-label">CEP<span class="required">*</span></label>
                                <input type="text" class="form-control" id="cep" name="cep" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->cep }}" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="pais" class="form-label">País<span class="required">*</span></label>
                                <input type="text" class="form-control" id="pais" name="pais" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->pais }}" required>
                            </div>

                            <div class="col-4">
                                <label for="estado" class="form-label">Estado<span class="required">*</span></label>
                                <input type="text" class="form-control" id="estado" name="estado" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->estado }}" required>
                            </div>

                            <div class="col-4">
                                <label for="cod_cidade_id" class="form-label">Cidade<span class="required">*</span></label>
                                <select class="form-select" id="cod_cidade_id" name="cod_cidade_id" required>
                                    <option>Selecione a cidade</option>
                                    @forelse($cidades as $r)
                                    <option value="{{ $r->id }}" {{ old('cod_cidade_id', $searchCriteria['cod_cidade_id'] ?? '') == $r->id ? 'selected' : '' }}>
                                        {{ $r->descricao }}
                                    </option>
                                    @empty
                                        <option>Selecione a cidade</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="telefone1" class="form-label">Telefone 01<span class="required">*</span></label>
                                <input type="text" class="form-control" id="telefone1" name="telefone1" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->telefone1 }}" required>
                            </div>

                            <div class="col-4">
                                <label for="telefone2" class="form-label">Telefone 02<span class="required">*</span></label>
                                <input type="text" class="form-control" id="telefone2" name="telefone2" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->telefone2 }}" required>
                            </div>

                            <div class="col-4">
                                <label for="telefone3" class="form-label">Telefone 03<span class="required">*</span></label>
                                <input type="text" class="form-control" id="telefone3" name="telefone3" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->telefone3 }}" required>
                            </div>
                        </div>

                        <div class="row mt-2 pb-4 hr">
                            <div class="col">
                                <label for="responsavel" class="form-label">Responsável<span class="required">*</span></label>
                                <input type="text" class="form-control" id="responsavel" name="responsavel" value="{{ request()->is('controle/associacoes/new') ? '' : $dados->responsavel }}" required>
                            </div>
                        </div>

                    </div>



                </div>




            </div>

        </div>
    </form>

@endsection
