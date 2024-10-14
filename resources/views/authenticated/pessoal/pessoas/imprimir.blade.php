@extends('templates.main')

@section('title', 'Impressão de Ficha Pessoal')

@section('content')
    <style>
        .icon-checkbox {
            cursor: pointer;
            /* Muda o cursor ao passar sobre o ícone */
        }
    </style>

    <div class="row mt-5">

        <div class="col d-flex justify-content-center align-items-center">
            @php
                $previousUrl = url()->previous();
            @endphp

            <div class="me-4 mb-2">
                <a href="{{ str_contains($previousUrl, 'search/pessoas') ? route('pessoas') : $previousUrl }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fas fa-fw fa-chevron-left"></i>
                </a>
            </div>
            <h2 class="text-center">
                Impressão de Ficha Pessoal
            </h2>

        </div>


        <div class="row d-flex justify-content-center g-3 mt-4">
            <div class="col-10">
                <div class="table-container">
                    <table class="table table-hover table-bordered table-custom">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $dados->nome }}</td>

                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

    </div>

    <div class="row d-flex justify-content-center g-3 mt-4">
        <div class="col-10">

            <form id="pdfForm" action="{{ route('pessoas.pdf', ["pessoa_id" => $pessoa_id]) }}" method="POST">
                @csrf

                <input name="pessoa_id" value="{{ $pessoa_id }}" hidden>

                <div class="card">
                    <div class="card-header" style="background-color: #FF6600; color: #FFFFFF;">
                        <strong>Selecione os módulos para impressão:</strong>
                    </div>
                    <div class="card-body">

                        <fieldset>
                            <div class="row text-center mt-4">
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-tasks fa-2x icon-checkbox" data-checkbox="chkAtividades"
                                        style="color:#FF6600;"></i><br>Atividades<br>
                                    <input type="checkbox" checked id="chkAtividades" name="chkAtividades"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-book-open fa-2x icon-checkbox" data-checkbox="chkCursos"
                                        style="color:#FF6600;"></i><br>Cursos<br>
                                    <input type="checkbox" checked id="chkCursos" name="chkCursos"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-users fa-2x icon-checkbox" data-checkbox="chkFamiliares"
                                        style="color:#FF6600;"></i><br>Familiares<br>
                                    <input type="checkbox" checked id="chkFamiliares" name="chkFamiliares"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-graduation-cap fa-2x icon-checkbox" data-checkbox="chkFormacoes"
                                        style="color:#FF6600;"></i><br>Formações<br>
                                    <input type="checkbox" checked id="chkFormacoes" name="chkFormacoes"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-briefcase fa-2x icon-checkbox" data-checkbox="chkFuncoes"
                                        style="color:#FF6600;"></i><br>Funções<br>
                                    <input type="checkbox" checked id="chkFuncoes" name="chkFuncoes"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-star fa-2x icon-checkbox" data-checkbox="chkHabilidades"
                                        style="color:#FF6600;"></i><br>Habilidades<br>
                                    <input type="checkbox" checked id="chkHabilidades" name="chkHabilidades"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-history fa-2x icon-checkbox" data-checkbox="chkHistoricos"
                                        style="color:#FF6600;"></i><br>Histórico<br>
                                    <input type="checkbox" checked id="chkHistoricos" name="chkHistoricos"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-map fa-2x icon-checkbox" data-checkbox="chkItinerarios"
                                        style="color:#FF6600;"></i><br>Itinerários<br>
                                    <input type="checkbox" checked id="chkItinerarios" name="chkItinerarios"
                                        class="form-check-input">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <i class="fas fa-file-medical fa-2x icon-checkbox" data-checkbox="chkLicencas"
                                        style="color:#FF6600;"></i><br>Ocor. Médicas<br>
                                    <input type="checkbox" checked id="chkLicencas" name="chkLicencas"
                                        class="form-check-input">
                                </div>
                            </div>
                        </fieldset>

                        <div class="row">
                            <div class="mb-2 d-flex align-items-end justify-content-end">
                                <button type="submit" class="btn btn-custom inter inter-title" target="_blank">Imprimir</button>
                            </div>
                        </div>

                    </div>
                </div>



        </div>
    </div>
    </form>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.icon-checkbox').click(function() {
                const checkboxId = $(this).data('checkbox');
                const checkbox = $('#' + checkboxId);
                checkbox.prop('checked', !checkbox.prop('checked'));
            });
        });
    </script>

<script>
    document.getElementById('pdfForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Previne o envio padrão do formulário
        const form = this;

        // Abre o formulário em uma nova aba
        const newTab = window.open();
        const formData = new FormData(form);

        // Cria uma requisição para enviar o formulário
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.blob())
        .then(blob => {
            const url = URL.createObjectURL(blob);
            newTab.location.href = url; // Abre o PDF na nova aba
        })
        .catch(error => {
            console.error('Erro ao gerar PDF:', error);
            newTab.close(); // Fecha a aba se houver erro
        });
    });
</script>



@endsection
