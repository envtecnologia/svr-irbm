<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema SVR | @yield('title')</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- GOOGLE FONTS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        window.baseUrl = @json(url('/'));
    </script>

</head>

<body class="{{ request()->is('home') ? 'home-bg' : '' }}" style="background-color: #F4EED8;">

    <header class="bg-menu">

        {{-- <div id="barra" class="py-3">
            <div class="container">

                <div class="row">
                    <div class="col">
                        <div class="text-white" id="clock"></div>
                    </div>

                    <div class="col d-flex align-items-center justify-content-end">
                        <div>
                            <p id="txtUsuario"><b>Usuário: </b> {{ Auth::user()->name }} </p>
                        </div>
                    </div>

                </div>

            </div>
        </div> --}}

        <div class="container hr">
            <img alt="SVR" title="SVR" class="pb-2 pt-2" src="{{ asset('images/logo-logged.png') }}"
                height="75" />
        </div>

        <nav class="navbar navbar-expand navbar-light" style="background-color: #FFFFFF;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownPrincipal" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Início
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdownPrincipal">
                                <li class="custom-dropdown-item"><a class="dropdown-item" href="/home">Início</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item" href="/meus-dados">Meus
                                        Dados</a></li>
                                <!-- <li><hr class="dropdown-divider"></li> -->
                                <li class="custom-dropdown-item"><a class="dropdown-item" href="/logout">Sair do
                                        Sistema</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownUsuario" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Cadastros Básicos
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdownUsuario">
                                <li class="custom-dropdown-item"><a class="dropdown-item" href="/cadastros/areas">Áreas
                                        Pastorais</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/doencas">Doenças</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/origens">Origens</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/parentescos">Parentescos</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/profissoes">Profissões</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/situacoes">Situações</a></li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_arquivos">Tipos de Arquivos</a></li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_atividades">Tipos de Atividades</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_cursos">Tipos de
                                        Cursos</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_formReligiosa">Tipos Form. Relig.</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_funcao">Tipos de
                                        Funções</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_habilidades">Tipos de Habilidades</a></li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_instituicoes">Tipos de Instituições</a></li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_obras">Tipos de
                                        Obras</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_pessoas">Tipos de
                                        Pessoas</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_tratamento">Tipos
                                        de Tratamento</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/cadastros/tipo_titulo">Títulos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownGerenciamento" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Gerenciamento
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu"
                                aria-labelledby="navbarDropdownGerenciamento">
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/associacoes">Associações</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/capitulos">Capítulos</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/cemiterios">Cemitérios</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/comunidades">Comunidades e Obras</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/dioceses">Dioceses</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/obras">Obras | Com. |
                                        Local</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/paroquias">Paróquias</a>
                                </li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/provincias">Províncias</a></li>

                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/controle/setores">Setores</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownPessoal" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pessoal
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdownPessoal">
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/pessoal/egressos">Egressos</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/pessoal/falecimentos">Falecimentos</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/pessoal/pessoas">Pessoas</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/pessoal/transferencia">Transferências</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownRelatoriosPessoas" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Relatórios Pessoas
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu"
                                aria-labelledby="navbarDropdownRelatoriosPessoas">
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/admissoes">Admissões</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/aniversariante">Aniversariantes</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/atividade">Atividades</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/capitulos">Títulos</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/atual">Atual</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/egresso">Egressos</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/falecimento">Falecimentos</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/mediaIdade">Média de Idade</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/pessoa">Pessoas</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/civil">Relatório Civil</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/relatorios/pessoal/transferencia">Transferências</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownRelatoriosRede" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Relatórios Rede
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu"
                                aria-labelledby="navbarDropdownRelatoriosRede">
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('associacoes.imprimir') }}">Associações</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('cemiterios.imprimir') }}">Cemitérios</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('comunidades.imprimir') }}">Comunidades</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('comunidades_aniv.imprimir') }}">Comunidades
                                        (aniv.)</a></li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('dioceses.imprimir') }}">Dioceses</a>
                                </li>
                                {{-- <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('funcoes.imprimir') }}">Funções</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('obras.imprimir') }}">Obras</a></li> --}}
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('paroquias.imprimir') }}">Paróquias</a>
                                </li>
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="{{ route('provincias.imprimir') }}">Províncias</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link  " href="#" id="navbarDropdownRelatoriosRede" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ajuda
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu"
                                aria-labelledby="navbarDropdownRelatoriosRede">
                                <li class="custom-dropdown-item"><a class="dropdown-item"
                                        href="/sobre">Sobre</a></li>
                        </li>

                        <!-- <li class="nav-item dropdown">
              <a class="nav-link  " href="#" id="navbarDropdownAjuda" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Ajuda
              </a>
              <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdownAjuda">
                  <li class="custom-dropdown-item"><a class="dropdown-item" href="ajuda/equipe.php" ><i class="fas fa-laptop-code dropdown-icon"></i>Equipe Técnica</a></li>
                  <li class="custom-dropdown-item"><a class="dropdown-item" href="ajuda/sobre.php" ><i class="fas fa-info dropdown-icon"></i>Sobre o Sistema</a></li>
              </ul>
          </li> -->

                    </ul>

                </div>
        </nav>

        <div class="alert alert-warning alert-dismissible fade show text-center d-none" id="progressBarContainer" role="alert">
            <div id="spinner" class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <br>
            <strong id="text-info">Gerando PDF...</strong>
        </div>

        <div id="text-pdf" class="alert alert-warning alert-dismissible fade show text-center d-none" role="alert">
            <strong>Seu PDF está pronto!</strong><br> <a href="#" id="btn-open-pdf" target="_blank">Abrir PDF</a> / <a href="#" id="btn-download-pdf">Salvar PDF</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </header>

    <main class="container mb-5">
        @yield('content')
    </main>

    <div id="barra" class="py-2">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p id="txtUsuario"><b><i class="fa-solid fa-user fa-sm me-1"></i> Usuário: </b> {{ Auth::user()->name }} </p>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    <div>
                        <div class="text-white" id="clock"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Sucesso!",
                text: "{{ session('success') }}",
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

@yield('js')

@if (session('pdf'))
    {{-- <script>
        updateProgressBar();
    </script> --}}
@endif

</body>

</html>
