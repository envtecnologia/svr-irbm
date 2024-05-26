@extends('templates.main')

@section('title', 'Tipo de Atividades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Tipos de Atividades ({{ $dados->total(); }})</h2>
    </div>

    <form action="{{ route('searchTipoAtividades') }}" method="POST">
        @csrf
        <div class="row d-flex justify-content-center g-3 mt-5">

            <div class="col-8">

                <div class="row">

                    <div class="col-6 mb-3">
                        <label for="search" class="form-label">Tipo de Atividades</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Pesquisar pela descrição">
                    </div>

                    <div class="col-6 mb-3 d-flex align-items-end justify-content-end">
                        <div>
                            <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                            @if(request()->is('search/tipo_atividades'))
                                <a class="btn btn-custom inter inter-title" href="/cadastros/tipo_atividades">Limpar Pesquisa</a>
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
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($dados as $key => $dado)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td>{{ $dado->descricao }}</td>

                            <td>
                                <!-- Botão de editar -->
                                <a class="btn-action" href="{{ route('tipo_atividades.edit', ['id' => $dado->id]) }}"><i class="fa-solid fa-pen-to-square"></i></a>

                                <!-- Botão de excluir (usando um formulário para segurança) -->
                                <form action="{{ route('tipo_atividades.delete', ['id' => $dado->id]) }}" method="POST" class="d-inline">
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
                        <a class="btn btn-custom inter inter-title" href="{{ route('tipo_atividades.new') }}">Novo +</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
