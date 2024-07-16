@extends('templates.main')

@section('title', 'Atividades')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Atividades ({{ $dados->total() }})</h2>
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
                            <th scope="col">Situação</th>
                            <th scope="col">Atividade</th>
                            <th scope="col">Pessoa	</th>
                            <th scope="col">Local</th>
                            <th scope="col">Data Início	</th>
                            <th scope="col">Data Final                            </th>





                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->situacao }}</td>
                                <td>{{ $dado->nome}}{{$dado->sobrenome}}</td>
                                {{-- <td>{{ $dado->data_readmissao }}</td>
                                <td>{{ $dado->data_readmissao }}</td> --}}





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
                    <a class="btn btn-custom inter inter-title" target="{{ request()->is('relatorio/pessoal/admissao') ? '_blank' : '_self' }}" href="{{ request()->is('relatorio/pessoal/admissao') ? route('aniversarios.pdf') : route('aniversarios.new')  }}">{{ request()->is('relatorio/pessoal/admissao') ? 'Imprimir' : 'Novo +'  }}</a>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection
