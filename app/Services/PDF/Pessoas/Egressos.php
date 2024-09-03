<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Egressos extends PdfService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function pdfVazio()
    {
        $this->SetFillColor(196, 210, 205);
        $this->SetTextColor(0);
        $this->SetDrawColor(240);


        $this->AliasNbPages("{total}");
        $this->AddPage();

        $this->SetX(20);
        $this->SetFont('Courier');
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Não há dados a exibir para a consulta selecionada."), 0, 0, "L", TRUE);
        $this->Ln();
    }

    function Footer()
    {
        # Posiciona a informacao do rodape
        $this->SetY(-15);
        $this->SetX(20);
        # Fonte
        $this->SetTextColor(160);
        $this->SetFont("Arial", "B", 8);
        $this->SetDrawColor(0);
        $this->Cell(200, 5, iconv("utf-8", "iso-8859-1", "Sistema de Vida Religiosa (SRVICM)"), 0, 0, "L");
        $this->SetFont("Arial", "", 8);
        # Numero da pagina
        $this->Cell(50, 5, iconv("utf-8", "iso-8859-1", "Página " . $this->PageNo() . " de {total}"), 0, 0, "R");
        $this->Ln();
    }

    function egressosPdf($dados)
    {

        $this->AliasNbPages("{total}");
        $this->AddPage("L");

        # Logomarca (caminho da imagem, posicao a esquerda, posicao ao topo, largura, altura)
        $this->Image(public_path("images/logo.png"), 20, 5, 20);
        $this->Ln(20); # imprime linhas...
        $this->SetY(25);
        $this->SetX(0);

        $this->SetFillColor(196, 210, 205);
        $this->SetTextColor(0);
        $this->SetDrawColor(240);

        # Conteudo: dados pessoais
        $this->SetY(10);
        $this->SetX(22);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Sistema de Vida Religiosa"), 0, 0, "C");
        $this->Ln();
        $this->SetX(22);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Congregação das"), 0, 0, "C");
        $this->Ln();
        $this->SetX(22);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Irmãs do Imaculado Coração de Maria"), 0, 0, "C");
        $this->Ln();
        $this->Ln(2);

        # verifica se houveram resultados
        if ($dados->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255,140,0);
            $this->SetTextColor(255,255,255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Relatórios de Egressos ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantitativo = 0;

            foreach ($dados as $egresso)
            {
                $dataSaida = substr($egresso["data_saida"], 8, 2) . "/"
                           . substr($egresso["data_saida"], 5, 2) . "/"
                           . substr($egresso["data_saida"], 0, 4);

                           $provinciaPessoa = $egresso["pessoa"] ? $egresso["pessoa"]["provincia"]->descricao : '---';
                if ($provincia != $provinciaPessoa)
                {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(196,210,205);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8","iso-8859-1", $provinciaPessoa), 1, 0, "L", TRUE);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $provincia = $provinciaPessoa;

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(28, 6, iconv("utf-8","iso-8859-1", "Data Saída"), 1, 0, "L", TRUE);
                    $this->Cell(112, 6, iconv("utf-8","iso-8859-1", "Egresso"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "Telefone(1)"), 1, 0, "L", TRUE);
                    $this->Cell(80, 6, iconv("utf-8","iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $quantitativo++;

                $sobrenome = $egresso["pessoa"] ? $egresso["pessoa"]["sobrenome"] : '---';
                $nome = $egresso["pessoa"] ? $egresso["pessoa"]["nome"] : '---';

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $dataSaida), 1, 0, "L", FALSE);
                $this->Cell(112, 6, iconv("utf-8","iso-8859-1", "{$sobrenome}, {$nome}"), 1, 0, "L", FALSE);
                $telefone1 = ($egresso["pessoa"] != "" ? $egresso["pessoa"]["telefone1"] : "---");
                $this->Cell(30, 6, iconv("utf-8","iso-8859-1", $telefone1), 1, 0, "L", FALSE);
                $email = ($egresso["pessoa"] != "" ? $egresso["pessoa"]["email"] : "---");
                $this->Cell(80, 6, iconv("utf-8","iso-8859-1", $email), 1, 0, "L", FALSE);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196,210,205);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(250, 2, "", 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->Output();
        } else {
            $this->pdfVazio();

            $this->Output();
        }
    }
}
