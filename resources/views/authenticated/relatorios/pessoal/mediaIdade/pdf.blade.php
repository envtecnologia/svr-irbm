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
            margin: 120px 25px 0 25px; /* Aumentei a margem superior para acomodar o header */
        }
        header {
            position: fixed;
            top: -80px; /* Ajustei para -80px para que o header fique dentro da margem */
            left: 0px;
            right: 0px;
            height: 80px; /* Ajustei a altura */
            background-color: #f8f8f8;
            text-align: center;
            line-height: 25px;
        }
        footer {
            position: fixed;
            bottom: 30px;
            left: 0px;
            right: 0px;
            height: 30px;
            /* background-color: #f8f8f8; */
            text-align: center;
            line-height: 15px;
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
            padding: 20px 25px 70px 25px; /* Ajustei o padding para acomodar o header e footer */
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
        <div style="text-align: center;" class="highlight">Relatório de Faixa Etária: Média de Pessoas por Idade</div>

                    <table>
                            <thead>
                                <tr>
                                    <th>Faixa Etária</th>
                                    <th>Quantidade</th>
                                    <th>Percentual</th>

                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>Até 20 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['vinte'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['vinte_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 21 a 30 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['trinta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['trinta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 31 a 40 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['quarenta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['quarenta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 41 a 50 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['cinquenta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['cinquenta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 51 a 60 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['sessenta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['sessenta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 61 a 70 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['setenta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['setenta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 71 a 80 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['oitenta'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['oitenta_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>De 81 a 90 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['noventa'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['noventa_porcentagem'], 2) }}%</td>
                                    </tr>

                                    <tr>
                                        <td>Acima de 90 anos</td>
                                        <td style="width: 50px; text-align: center;">{{ $chunks['acima_noventa'] ?? 'N/A' }}</td>
                                        <td style="width: 50px; text-align: center;">{{ number_format($chunks['acima_porcentagem'], 2) }}%</td>
                                    </tr>
                            </tbody>
                    </table>

                    <table>
                        <thead>
                            <tr>
                                <th>Geral</th>
                                <th>Quantidade</th>
                                <th>Média de Idade</th>

                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>Total de Pessoas</td>
                                    <td style="width: 50px; text-align: center;">{{ $chunks['total'] }}</td>
                                    <td style="width: 50px; text-align: center;">{{ number_format($chunks['mediaIdades'], 2) }}</td>
                                </tr>
                        </tbody>
                </table>
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
