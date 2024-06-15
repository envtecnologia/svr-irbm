@extends('templates.main')

@section('title', 'Egressos')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Egressos ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchEgresso') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="search" class="form-label">Instituição</label>
                                <input type="text" class="form-control" id="search" name="descricao"
                                    placeholder="Pesquisar pela descrição">
                            </div>


                        <div class="{{ request()->is('search/egressos') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/egressos'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/egressos">Limpar Pesquisa</a>
                                @endif
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
                            <th scope="col">Data Saída	</th>
                            <th scope="col">Readmissão</th>
                            <th scope="col">Egresso</th>

                            @if(!(request()->is('relatorio/rede/egressos')))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->data_saida }}</td>
                                <td>{{ $dado->data_readmissao }}</td>
                                <td>{{ $dado->detalhes ? 'Ativa' : 'Inativa' }}</td>
                                <td>{{ $dado->tipo_egressos->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->cidade->descricao ?? 'N/A' }}</td>
                                <td>{{ $dado->telefone1 ?? 'N/A' }}</td>
                                <td>{{ $dado->email ?? 'N/A' }}</td>
                                <td>{{ $dado->responsavel ?? 'N/A' }}</td>

                                @if(!(request()->is('relatorio/rede/egressos')))
                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('egressos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('egressos.delete', ['id' => $dado->id]) }}" method="POST"
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
                                <td colspan="10">Nenhum registro encontrado!</td>
                            </tr>
                        @endforelse
                    </tbody>
                                </table>

                                <!-- Links de paginação -->
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        {{ $dados->links() }}
                                    </div>
                                </div>

                <div class="mb-2">
                    <a class="btn btn-custom inter inter-title" target="{{ request()->is('relatorio/rede/egressos') ? '_blank' : '_self' }}" href="{{ request()->is('relatorio/rede/egressos') ? route('egressos.pdf') : route('egressos.new')  }}">{{ request()->is('relatorio/rede/egressos') ? 'Imprimir' : 'Novo +'  }}</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
