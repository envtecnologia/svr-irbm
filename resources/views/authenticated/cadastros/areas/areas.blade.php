@extends('templates.main')

@section('title', 'Home')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Áreas Pastorais ({{ $dados->total(); }})</h2>
    </div>

    <form action="{{ route('searchAreas') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-5">

            <div class="col-8">

                <div class="row">

                    <div class="col-6 mb-3">
                        <label for="descricao" class="form-label">Área Pastoral</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Pesquisar pela descrição" value="{{ request()->has('descricao') ? request()->input('descricao') : '' }}">
                    </div>

                    <div class="col-6 mb-3 d-flex align-items-end justify-content-end">
                        <div>
                            <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                            @if(request()->is('search/areas'))
                                <a class="btn btn-custom inter inter-title" href="/cadastros/areas">Limpar Pesquisa</a>
                            @endif
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
                            <th scope="col">Descrição</th>
                            <th scope="col">Detalhes</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($dados as $key => $area)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td>{{ $area->descricao }}</td>
                            <td>{{ $area->detalhes }}</td>

                            <td>
                                <!-- Botão de editar -->
                                <a class="btn-action" href="{{ route('areas.edit', ['id' => $area->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>

                                <!-- Botão de excluir (usando um formulário para segurança) -->
                                <form action="{{ route('areas.delete', ['id' => $area->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-action"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum registro encontrado!</td>
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
                        <a class="btn btn-custom inter inter-title" href="{{ route('areas.new') }}">Novo +</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
