@extends('templates.main')

@section('title', 'Transferencias')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Transferencias ({{ $dados->total() }})</h2>
    </div>

    <form action="{{ route('transferencias') }}" method="GET">

        <div class="row d-flex justify-content-center g-3 mt-3">

            <div class="col-8">

                <div class="row justify-content-center">

                    <div class="col-10">

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="cod_provinciaori" class="form-label">Província Origem<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_provinciaori" name="cod_provinciaori">
                                    <option value="">Selecione...</option>
                                    @forelse($provincias_origem as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_provinciaori') && $r->id == request('cod_provinciaori')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma província cadastrada</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="cod_provinciades" class="form-label">Província Origem<span
                                        class="required">*</span></label>
                                <select class="form-select" id="cod_provinciades" name="cod_provinciades">
                                    <option value="">Selecione...</option>
                                    @forelse($provincias_destino as $r)
                                        <option value="{{ $r->id }}"
                                            @if (request()->has('cod_provinciades') && $r->id == request('cod_provinciades')) selected @endif>
                                            {{ $r->descricao }}
                                        </option>

                                    @empty
                                        <option>Nenhuma província cadastrada</option>
                                    @endforelse
                                </select>
                            </div>


                            <div
                                class="{{ request()->is('search/transferencias') ? 'col-6' : 'col-3 mt-4' }} d-flex align-items-end">
                                <div>
                                    <button class="btn btn-custom inter inter-title" type="submit">Pesquisar</button>
                                    @if (request()->is('search/transferencias'))
                                        <a class="btn btn-custom inter inter-title" href="/controle/transferencias">Limpar
                                            Pesquisa</a>
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
                            <th scope="col">Data Transferência</th>
                            <th scope="col">Pessoa</th>
                            <th scope="col">Província Origem</th>
                            <th scope="col">Comunidade Origem</th>
                            <th scope="col">Província Destino</th>
                            <th scope="col">Comunidade Destino</th>



                            @if (!request()->is('relatorios/pessoal/transferencia'))
                                <th scope="col">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dados as $key => $dado)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $dado->data_transferencia ? \Carbon\Carbon::parse($dado->data_transferencia)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $dado->pessoa->nome ?? '-' }}</td>
                                <td>{{ $dado->prov_origem->descricao ?? '-' }}</td>
                                <td>{{ $dado->com_origem->descricao ?? '-' }}</td>
                                <td>{{ $dado->prov_des->descricao ?? '-' }}</td>
                                <td>{{ $dado->com_des->descricao ?? '-' }}</td>

                                @if (!request()->is('relatorios/pessoal/transferencia'))
                                    <td>
                                        <!-- Botão de editar -->
                                        <a class="btn-action"
                                            href="{{ route('transferencia.edit', ['id' => $dado->id]) }}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <!-- Botão de excluir (usando um formulário para segurança) -->
                                        <form action="{{ route('transferencia.delete', $dado->id) }}" method="POST"
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
                    <form id="pdfForm" method="POST" action="{{ route('actionButton') }}">
                        @csrf
                        <input type="text" name="modulo" value="transferencia" hidden>
                        <input type="text" name="action"
                            value="{{ request()->is('relatorios/pessoal/transferencia') ? 'pdf' : 'insert' }}" hidden>
                        <button class="btn btn-custom inter inter-title"
                            id="{{ request()->is('relatorios/pessoal/transferencia') ? 'action-button' : 'new-button' }}">{{ request()->is('relatorios/pessoal/transferencia') ? 'Imprimir' : 'Novo +' }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/pdfSocket.js') }}"></script>
@endsection
