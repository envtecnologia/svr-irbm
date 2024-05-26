<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

<style>

@page { margin: 100px 25px; }
        header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; background-color: #f8f8f8; text-align: center; line-height: 35px; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; background-color: #f8f8f8; text-align: center; line-height: 35px; }
        .page-number:before { content: counter(page); }
        .total-pages:before { content: counter(pages); }

    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    .header {
        text-align: center;
    }
    .header img {
        width: 100px;
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
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    .highlight {
        background-color: #ffc107;
        color: white;
        font-weight: bold;
        padding: 8px;
    }
</style>
</head>
<body>
    <header class="header">
            <img src="images/logo-coracao.png" alt="Logo">
            <div class="title">Sistema de Vida Religiosa</div>
            <div class="subtitle">Congregação das Irmãs do Imaculado Coração de Maria</div>
        </div>

<main class="table-container">
        <div class="highlight">Relatório de Dioceses ({{ count($dados) }} registros)</div>
        <table>
            <thead>
                <tr>
                    <th>Diocese</th>
                    <th>Situação</th>
                    <th>Cidade</th>
                    <th>Telefone(1)</th>
                    <th>E-mail</th>
                    <th>Bispo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dados as $index => $item)
                    <tr>
                        <td>{{ $item['descricao'] }}</td>
                        <td>{{ $item['situacao'] }}</td>
                        <td>{{ $item['cidade'] }}</td>
                        <td>{{ $item['telefone'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['bispo'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

</main>

<footer>
    <div id="footer-content"></div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 12;
            $pageNumber = isset($GLOBALS['pdf_page_number']) ? $GLOBALS['pdf_page_number'] : 1;
            $pageCount = isset($GLOBALS['pdf_page_count']) ? $GLOBALS['pdf_page_count'] : 1;
            $text = "Página $pageNumber de $pageCount";
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35; // Defina a posição correta de acordo com sua necessidade
            $pdf->text($x, $y, $text, $font, $size);
        }
    </script>
</footer>
</body>
</html>
