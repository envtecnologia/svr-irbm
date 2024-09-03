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
                            <th scope="col">Obra</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $obra->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $obra->cidade->descricao ?? '-' }}</td>
                                <td>{{ $obra->provincia->descricao ?? '-' }}</td>
                                <td>{{ $obra->descricao ?? '-' }}</td>

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
        <h2 class="text-center">Histórico de Endereços ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchEnderecoObra') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                    placeholder="Pesquisar pela descrição" value="{{ old('descricao', $searchCriteria['descricao'] ?? '') }}">
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
                                        <option value="1" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 1 ? 'selected' : '' }}>Ativa</option>
                                        <option value="0" {{ old('situacao', $searchCriteria['situacao'] ?? '') == 0 ? 'selected' : '' }}>Inativa</option>
                                </select>
                            </div>

                        <div class="{{ request()->is('search/enderecosObras') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/enderecosObras'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/enderecosObras">Limpar Pesquisa</a>
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
                                    <a class="btn btn-link btn-action" href="{{ route('enderecosObra.edit', ['id' => $dado->id, 'id_obra' => $obra->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('enderecosObra.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
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
                    <a class="btn btn-custom inter inter-title" href="/controle/enderecosObra/{{ $obra->id }}/new">Novo +</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
