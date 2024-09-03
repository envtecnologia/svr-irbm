@extends('templates.main')

@section('title', 'Home')

@section('content')

    <div class="row mt-5">
        <h2 class="text-center">Meus Dados</h2>
    </div>

    <form action="/meus-dados/update" method="POST">
        @csrf
        <div class="row justify-content-center g-3 d-flex mt-5">

            <div class="col-8">

                <div class="row g-3">

                    <div class="col-6 mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            disabled>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="cpf" class="form-label">CPF </label>
                        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $user->cpf }}"
                            disabled>
                    </div>

                </div>


                <div class="row g-3">

                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">E-mail <span class="required">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}"
                            required>
                    </div>

                </div>

                <div class="row g-3">

                    <div class="col-6 mb-3">
                        <label for="birthdate" class="form-label">Data de Nascimento</label>
                        <input type="text" class="form-control" id="birthdate" name="birthdate"
                            value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $user->birthdate)->format('d/m/Y') }}"
                            disabled>
                    </div>

                    <div class="col-6 mb-3">
                        <label for="phone" class="form-label">Celular <span class="required">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}"
                            required>
                    </div>

                </div>

                <div class="row">
                    <div>
                        <button class="btn btn-custom inter inter-title" type="submit">Salvar Dados</button>
                    </div>
                </div>

            </div>

        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
          $('#phone').mask('(00) 00000-0000');
          $('#phone').blur(function() {
            var phone = $(this).val().replace(/\D/g, '');
            if(phone.length === 10) {
              $(this).mask('(00) 0000-0000');
            } else {
              $(this).mask('(00) 00000-0000');
            }
          });
        });
        </script>

    <script>
        window.addEventListener('load', function() {
            // Função para aplicar a máscara de CPF
            function mascaraCPF(campo) {
                campo.value = campo.value.replace(/\D/g, '');
                campo.value = campo.value.replace(/(\d{3})(\d)/, '$1.$2');
                campo.value = campo.value.replace(/(\d{3})(\d)/, '$1.$2');
                campo.value = campo.value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }

            var campoCPF = document.getElementById('cpf');
            mascaraCPF(campoCPF);
        });
    </script>


@endsection
