@extends('templates.main')

@section('title', 'Endereços')

@section('content')

    <div class="row d-flex justify-content-center g-3 mt-4">

        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Província</th>
                            <th scope="col">Comunidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $comunidade->situacao ? 'Ativa' : 'Inativa' }}</td>
                            <td>{{ $comunidade->cidade->descricao ?? '-' }}</td>
                            <td>{{ $comunidade->provincia->descricao ?? '-' }}</td>
                            <td>{{ $comunidade->descricao ?? '-' }}</td>

                        </tr>
                    </tbody>
                </table>

                <!-- Links de paginação -->
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{ $dados->appends(request()->except('page'))->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/comunidades') ? route('comunidades') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">Histórico de Endereços ({{ $dados->total() }})</h2>

        </div>

    </div>

    <form action="{{ route('searchEndereco') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição"
                                    value="{{ old('descricao', $searchCriteria['descricao'] ?? '') }}">
                            </div>

                            {{-- <div class="col-6">
                                <label for="cidade" class="form-label">Cidade</label>
                                <select class="form-select" id="cod_cidade_id" name="cod_cidade_id">
                                    <option value="">Todas</option>
                                    @forelse($cidades as $r)
                                    <option value="{{ $r->id }}" {{ old('cod_cidade_id', $searchCriteria['cod_cidade_id'] ?? '') == $r->id ? 'selected' : '' }}>
                                        {{ $r->descricao }}
                                    </option>
                                    @empty
                                        <option>Nenhuma cidade cadastrada</option>
                                    @endforelse
                                </select>
                            </div> --}}

                            <div class="col-2">
                                <label for="situacao" class="form-label">Situação</label>
                                <select class="form-select" id="situacao" name="situacao">
                                    <option value="1"
                                        {{ old('situacao', $searchCriteria['situacao'] ?? '') == 1 ? 'selected' : '' }}>
                                        Ativa</option>
                                    <option value="0"
                                        {{ old('situacao', $searchCriteria['situacao'] ?? '') == 0 ? 'selected' : '' }}>
                                        Inativa</option>
                                </select>
                            </div>

                            <div
                                class="{{ request()->is('search/enderecos') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/enderecos'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/enderecos">Limpar
                                            Pesquisa</a>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>


                </div>


            </div>



        </div>

        </div>

        </div>
    </form>

    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">
            <div class="table-container">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Data Início</th>
                            <th scope="col">Data Final</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Localidade</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $dados->firstItem() + $key }}</th>
                                <td>{{ $dado->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dado->datainicio)->format('d/m/Y') }}</td>
                                <td>{{ $dado->datafinal ? \Carbon\Carbon::parse($dado->datafinal)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dado->endereco ?? '-' }}</td>
                                <td>{{ $dado->localidade ?? '-' }}</td>

                                <td>

                                    <!-- Botão de editar -->
                                    <a class="btn btn-link btn-action"
                                        href="{{ route('enderecos.edit', ['id' => $dado->id, 'id_comunidade' => $comunidade->id]) }}"><i
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="popover" data-bs-content="Editar"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('enderecos.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action" data-bs-toggle="popover" data-bs-content="Deletar"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Nenhum registro encontrado!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Links de paginação -->
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{ $dados->appends(request()->except('page'))->links() }}
                    </div>
                </div>



                <div class="mb-2">
                    <a class="btn btn-custom inter inter-title" href="/controle/enderecos/{{ $comunidade->id }}/new">Novo
                        +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
