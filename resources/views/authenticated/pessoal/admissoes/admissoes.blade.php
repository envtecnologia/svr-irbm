@extends('templates.main')

@section('title', 'Admissoes')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Admissoes ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('searchAdmissoes') }}" method="POST">
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


                        <div class="{{ request()->is('search/admissoes') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                            <div>
                                <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                @if (request()->is('search/admissoes'))
                                    <a class="btn btn-custom inter inter-title" href="/controle/admissoes">Limpar Pesquisa</a>
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
                            <th scope="col">Data Cadastro	</th>
                            <th scope="col">Egresso</th>


                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->datacadastro ? \Carbon\Carbon::parse($dado->datacadastro)->format('d/m/Y') : '-' }}</td>
                                <td>{{$dado->sobrenome}}, {{ $dado->nome }}</td>
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
                        <input type="text" name="modulo" value="admissoes" hidden>
                        <input type="text" name="action" value="{{ request()->is('relatorios/pessoal/admissoes') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title" id="action-button">{{ request()->is('relatorios/pessoal/admissoes') ? 'Imprimir' : 'Novo +'  }}</button>
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
