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
                                    <td>{{$dado->provincia->descricao }}</td>
                                <td>{{$dado->sobrenome }}, {{ $dado->nome }}</td>
                                <td>{{ $dado->aniversario }}</td>
                                <td>{{ $dado->comunidade->descricao ?? '-' }}</td>




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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="aniversariante" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/aniversariante') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="{{ request()->is('relatorios/pessoal/aniversariante') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/aniversariante') ? 'Imprimir' : 'Novo +'  }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection

@section ('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
