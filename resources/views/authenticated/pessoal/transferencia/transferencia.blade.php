@extends('templates.main')

@section('title', 'Transferencias')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Transferencias ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchEgresso') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="search" class="form-label">Origem</label>
                                <input type="text" class="form-control" id="search" name="descricao"
                                    placeholder="Pesquisar pela descrição">
                            </div>
                            <div class="col-6">
                                <label for="search" class="form-label">Destino(o)</label>
                                <input type="text" class="form-control" id="search" name="descricao"
                                    placeholder="Pesquisar pela descrição">
                            </div>


                        <div class="{{ request()->is('search/transferencias') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/transferencias'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/transferencias">Limpar Pesquisa</a>
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
                            <th scope="col">Data Transferência		</th>
                            <th scope="col">Pessoa</th>
                            <th scope="col">Província Origem	</th>
                            <th scope="col">Comunidade  Origem	</th>
                            <th scope="col">Província Destino	</th>
                            <th scope="col">Comunidade Destino </th>



                            @if(!(request()->is('pessoal/transferencias')))
                                <th scope="col">Cemitério</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->data_transferencia }}</td>
                                <td>{{ $dado->pessoa }}</td>
                                <td>{{ $dado->provincia_origem }}</td>
                                <td>{{ $dado->comunidade_origem }}</td>
                                <td>{{ $dado->provincia_destino }}</td>
                                <td>{{ $dado->comunidade_destino }}</td>

                                @if(!(request()->is('pessoal/transferencias')))
                                <td>
                                    <!-- Botão de editar -->
                                    <a class="btn-action" href="{{ route('falecimentos.edit', ['id' => $dado->id]) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a>

                                    <!-- Botão de excluir (usando um formulário para segurança) -->
                                    <form action="{{ route('falecimentos.delete', ['id' => $dado->id]) }}" method="POST"
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
                    <a class="btn btn-custom inter inter-title" target="{{ request()->is('relatorio/pessoal/transferencias/pdf') ? '_blank' : '_self' }}" href="{{ request()->is('relatorio/pessoal/transferencias/pdf') ? route('transferencias.pdf') : route('transferencias.new')  }}">{{ request()->is('relatorio/rede/transferencias') ? 'Imprimir' : 'Novo +'  }}</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
