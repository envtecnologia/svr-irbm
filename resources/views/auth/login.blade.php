<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Sistema SVR | Login</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="text-center">


    <main class="form-signin">
        <form action="/auth" method="POST">
            @csrf
            <img class="mb-4" src="{{ asset('images/logo-logged.png') }}" alt="" style="max-width: 320px">
            <!-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> -->



            <div class="form-floating">
                <input type="text" class="form-control" id="username" value="{{ old('username') }}" name="username" placeholder="Nome de Usuário" required>
                <label for="username">Login</label>
            </div>
            <div class="form-floating">
                <input id="password" type="password" class="form-control" id="senha" name="password"
                    placeholder="Senha" required>
                <label for="senha">Senha</label>
            </div>

            <div class="checkbox mb-3">
                <div style="text-align: right;">
                    <label>
                        <input type="checkbox"
                            onclick="document.getElementById('password').type === 'password' ? document.getElementById('password').type = 'text' : document.getElementById('password').type = 'password'">
                        Exibir a senha
                    </label>
                </div>
            </div>

            <div class="row justify-content-between mt-2">
                <small class="small"><a href="{{ route('password.request') }}">Esqueci minha Senha</a></small>
            </div>

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
                    type="submit">Acessar</button>

                <p class="mt-5 mb-3 text-muted">Todos os diretos reservados para Instituto Religioso Barbara Maix - IRBM - 2024</p>
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
