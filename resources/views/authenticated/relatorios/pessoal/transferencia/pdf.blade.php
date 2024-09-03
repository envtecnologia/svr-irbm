<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <style>
        .page-break {
            page-break-after: always;
        }



        header {
            background-color: #f8f8f8;
            text-align: center;
            padding: 5px 0;
        }
        footer {
            position: fixed;
            bottom: 15px;
            /* left: 0px; */
            right: 0px;
            /* height: 30px; */
            /* background-color: #f8f8f8; */
            text-align: center;
            /* line-height: 15px; */
        }

        .left-content {
            float: left;
            margin-left: 30px; /* Ajuste conforme necessário */
        }

        .right-content {
            float: right;
            margin-right: 30px; /* Ajuste conforme necessário */
        }
        .page-number:before {
            content: "Página " counter(page);
        }

        .total-pages:before {
            content: " de ";
            visibility: hidden; /* Esconde o número total de páginas */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Removi a margem padrão do body */

        }
        .header {
            text-align: center;
        }
        .header img {
            width: 80px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .subtitle {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .table-container {
            width: 100%;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 6px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .highlight {
            background-color: #ffc107;
            color: white;
            font-weight: bold;
            padding: 8px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <header class="header">
        {{-- <img src="images/logo-coracao.png" alt="Logo"> --}}
        <div class="title">Sistema de Vida Religiosa</div>
        <div class="subtitle">Congregação das Irmãs do Imaculado Coração de Maria</div>
    </header>

    <main class="table-container">

        <div style="text-align: center;" class="highlight">Relatório de Transferências ({{ $records }} registros)</div>
        @php $contadorGlobal = 0; @endphp

        @foreach ($chunks as $dados)
        <table>
            <thead>
                <tr>
                    <th style="text-align: right;">#</th>
                    <th scope="col">Data Transferência</th>
                    <th scope="col">Pessoa</th>
                    <th scope="col">Província Origem</th>
                    <th scope="col">Comunidade  Origem</th>
                    <th scope="col">Província Destino</th>
                    <th scope="col">Comunidade Destino</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados as $index => $dado)
                    <tr>
                        <td style="text-align: right;">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($dado['data_transferencia'])->format('d/m/Y') }}</td>
                        <td>{{ $dado['pessoa']['nome'] ?? '-'}}</td>
                        <td>{{ $dado['prov_origem']['descricao'] ?? '-' }}</td>
                        <td>{{ $dado['com_origem']['descricao'] ?? '-' }}</td>
                        <td>{{ $dado['prov_des']['descricao'] ?? '-' }}</td>
                        <td>{{ $dado['com_des']['descricao'] ?? '-' }}</td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        @php $contadorGlobal += count($dados); @endphp
        @endforeach
    </main>

    <footer>
        {{-- <div class="left-content">Sistema de Vida Religiosa</div> --}}
        <div class="right-content">
            <div class="page-number"></div>
            {{-- <div class="total-pages"></div> --}}
        </div>
    </footer>


</body>
</html>
