@extends('templates.main')

@section('title', 'Comunidades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Comunidades ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchComunidade') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Comunidade</label>
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

                        <div class="{{ request()->is('search/comunidades') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/comunidades'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/comunidades">Limpar Pesquisa</a>
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
                            <th scope="col">Código</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Cidade</th>
                            <th scope="col">Província</th>
                            <th scope="col">Paróquia</th>
                            <th scope="col">Comunidade</th>
                            <th scope="col">Aniversário</th>
                            <th scope="col">Telefone¹</th>
                            <th scope="col">E-mail</th>
                            @if(!(request()->is('relatorio/rede/comunidades')))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $dados->firstItem() + $key }}</th>
                                <td>{{ $dado->codantigo ?? 'N/A' }}</td>
                                <td>{{ $dado->situacao ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $dado->cidade->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->provincia->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->paroquia->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->descricao ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dado->fundacao)->format('d/m') }}</td>
                                <td>{{ $dado->telefone1 ?? 'N/A' }}</td>
                                <td>{{ $dado->email ?? 'N/A' }}</td>

                                @if(!(request()->is('relatorio/rede/comunidades')))
                                <td>

                                    <!-- Botão de endereços -->
                                    <a class="btn btn-link btn-action" href="{{ route('comunidades.map', ['id' => $dado->id]) }}">
                                        <i class="fa-solid fa-map-location-dot"></i></a>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('comunidades.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('comunidades.delete', ['id' => $dado->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-action"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            @endif

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
                    <a class="btn btn-custom inter inter-title" target="{{ request()->is('relatorio/rede/comunidades_aniv') ? '_blank' : '_self' }}" href="{{ request()->is('relatorio/rede/comunidades_aniv') ? route('comunidades.pdf') : route('comunidades.new')  }}">{{ request()->is('relatorio/rede/comunidades_aniv') ? 'Imprimir' : 'Novo +'  }}</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
