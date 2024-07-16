@extends('templates.main')

@section('title', 'Novo Arquivo')

@section('content')

<div class="row mt-5">
    <h2 class="text-center">Novo Arquivo</h2>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('arquivo.create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center g-3 d-flex mt-5">

        <div class="col-12">

            <div class="row d-flex justify-content-center g-3">

                <div class="col-6 mb-3">

                    <div class="form-group">
                        <label for="cod_tipoarquivo_id" class="form-label">Tipo de Arquivo<span
                                class="required">*</span></label>
                        <select class="form-select" id="cod_tipoarquivo_id" name="cod_tipoarquivo_id" required>
                            <option value="">Selecione o tipo de arquivo</option>
                            @forelse($tipos_arquivos as $r)
                                <option value="{{ $r->id }}">{{ $r->descricao }}</option>
                            @empty
                                <option>Nenhum tipo de arquivo cadastrado</option>
                            @endforelse
                        </select>
                    </div>

                    <input value="{{ $pessoa_id }}" name="cod_pessoa_id" hidden>

                    <label for="descricao" class="form-label">Descrição<span class="required">*</span></label>
                    <input type="text" class="form-control" id="descricao" name="descricao">

                    <div class="form-group">
                        <label for="file">Escolha um arquivo</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>

                    <div class="row mt-2">
                        <div>
                            <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                        </div>
                    </div>

                </div>



            </div>




        </div>

    </div>
</form>


@endsection
