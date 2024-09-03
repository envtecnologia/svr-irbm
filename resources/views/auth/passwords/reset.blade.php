<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Sistema SVR | Redefinição</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="text-center">


    <main class="form-signin">
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <img class="mb-4" src="{{ asset('images/logo.jpg') }}" alt="" style="max-width: 320px">
            <!-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> -->


            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" name="email" value="{{ $email ?? old('email') }}" hidden>


            <div class="row mb-2">
                <div class="col-12">
                    <input class="form-control" type="password" name="password" placeholder="Nova Senha" required>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <input class="form-control" type="password" name="password_confirmation"
                        placeholder="Confirme a Nova Senha" required>
                </div>
                @error('password_confirmation')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror


                @error('password')
                    <div style="color: red;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @error('email')
                <div class="mt-2" style="color: red;">
                    {{ $message }}
                </div>
            @enderror

            @if (session('status'))
                <script>
                    Swal.fire({
                        title: "Sucesso!",
                        text: "{{ session('status') }}",
                        icon: "success"
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: "Oops!",
                        text: "{{ session('error') }}",
                        icon: "error"
                    });
                </script>
            @endif

            <button id="acessar_btn" name="acessar" value="login" class="w-100 btn btn-lg mt-4"
                type="submit">Redefinir Senha</button>

            <p class="mt-5 mb-3 text-muted">Todos os direitos reservados &copy; Ondaweb - 2024</p>
        </form>
    </main>



    <!-- <script>
        document.getElementById("cpf").addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove caracteres não numéricos
        });
    </script>
      <script>
          // Função para aplicar a máscara de CPF
          function mascaraCPF(campo) {
              campo.value = campo.value.replace(/\D/g, '');
              campo.value = campo.value.replace(/(\d{3})(\d)/, '$1.$2');
              campo.value = campo.value.replace(/(\d{3})(\d)/, '$1.$2');
              campo.value = campo.value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
          }

          var campoCPF = document.getElementById('cpf');
          campoCPF.addEventListener('input', function() {
              mascaraCPF(this);
          });
      </script> -->

</body>

</html>
