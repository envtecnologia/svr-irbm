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

        @page {
           /* margin: 120px 25px 0 25px;  Aumentei a margem superior para acomodar o header */
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
           /* padding: 20px 25px 70px 25px;  Ajustei o padding para acomodar o header e footer */
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
            margin-bottom: 20px;
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
            margin-bottom: 5px;
        }
        .mes {
            background-color: #f2f2f2;
            color: #000;
            border: 1px solid #ddd;
            border-bottom: #fff solid 1px;
            font-weight: bold;
            padding: 8px 0;
            text-align: center;
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
        <div class="highlight">Relatório de Comunidades ({{ $records }} registros)</div>

        @php $contadorGlobal = 0; @endphp

        @foreach ($chunks as $provincia => $meses)
        <div class="mes">{{ $provincia }}</div>
            @foreach ($meses as $mes => $dados)
            <div class="mes">{{ $mes }}</div>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: right; width: 15px;">#</th>
                        <th style="width: 28px;">Código</th>
                        <th style="width: 150px;">Comunidade</th>
                        <th style="width: 50px;">Aniversário</th>
                        <th style="width: 100px;">Cidade</th>
                        <th style="width: 100px;">Telefone¹</th>
                        <th style="width: 150px;">E-mail¹</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dados as $index => $item)
                        <tr>
                            <td style="text-align: right;">{{ $contadorGlobal + $index + 1 }}</td>
                            <td>{{ $item['codantigo'] ?? 'N/A' }}</td>
                            <td>{{ $item['descricao'] }}</td>
                            <td style="text-align: center;">{{ sprintf('%02d', $item['dia_aniversario']) }}/{{ sprintf('%02d', $item['mes_aniversario']) }}</td>
                            <td>{{ $item['cidade'] }}</td>
                            <td>{{ $item['telefone1'] ?? 'N/A' }}</td>
                            <td>{{ $item['email1'] ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        @endforeach
        @php $contadorGlobal += count($dados); @endphp
        @endforeach
    </main>

    <footer>
        <div class="left-content">Sistema de Vida Religiosa</div>
        <div class="right-content">
            <div class="page-number"></div>
            {{-- <div class="total-pages"></div> --}}
        </div>
    </footer>


</body>
</html>
