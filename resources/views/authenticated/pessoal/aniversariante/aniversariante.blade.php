@extends('templates.main')

@section('title', 'Aniversarios')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Aniversarios ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchAniversarios') }}" method="POST">
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


                        <div class="{{ request()->is('search/aniversarios') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/aniversarios'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/aniversarios">Limpar Pesquisa</a>
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
                            <th scope="col">Província</th>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">Aniversário</th>
                            <th scope="col">Comunidade</th>



                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{$dado->sobrenome }}, {{ $dado->nome }}</td>
                                <td>{{ $dado->aniversario }}</td>
                                <td>{{ $dado->comunidade->descricao ?? 'N/A' }}</td>




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
                    <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/aniversariante') ? 'generate-pdf-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/aniversariante') ? 'Imprimir' : 'Novo +'  }}</button>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection

@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
