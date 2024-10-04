<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Transferencias extends PdfService
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

    function transferenciaPdf($dados)
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
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Relatório de Transferências ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(28, 6, iconv("utf-8","iso-8859-1", "Data"), 1, 0, "C", TRUE);
            $this->Cell(46, 6, iconv("utf-8","iso-8859-1", "Pessoa"), 1, 0, "L", TRUE);
            $this->Cell(44, 6, iconv("utf-8","iso-8859-1", "Província Origem"), 1, 0, "L", TRUE);
            $this->Cell(44, 6, iconv("utf-8","iso-8859-1", "Comunidade Origem"), 1, 0, "L", TRUE);
            $this->Cell(44, 6, iconv("utf-8","iso-8859-1", "Província Destino"), 1, 0, "L", TRUE);
            $this->Cell(44, 6, iconv("utf-8","iso-8859-1", "Comunidade Destino"), 1, 0, "L", TRUE);
            $this->SetTextColor(0);
            $this->Ln();

            $quantitativo = 0;

            foreach ($dados as $transferencia)
            {
                $dataSaida = substr($transferencia["data_transferencia"], 8, 2) . "/"
                           . substr($transferencia["data_transferencia"], 5, 2) . "/"
                           . substr($transferencia["data_transferencia"], 0, 4);

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 6.5);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $dataSaida), 1, 0, "C", FALSE);
                $this->Cell(46, 6, iconv("utf-8","iso-8859-1", "{$transferencia['pessoa']["sobrenome"]}, {$transferencia['pessoa']["nome"]}"), 1, 0, "L", FALSE);
                $this->Cell(44, 6, iconv("utf-8","iso-8859-1", $transferencia["prov_origem"]->descricao), 1, 0, "L", FALSE);
                $this->Cell(44, 6, iconv("utf-8","iso-8859-1", $transferencia["com_origem"]->descricao), 1, 0, "L", FALSE);
                $this->Cell(44, 6, iconv("utf-8","iso-8859-1", $transferencia["prov_des"]->descricao), 1, 0, "L", FALSE);
                $this->Cell(44, 6, iconv("utf-8","iso-8859-1", $transferencia["com_des"]->descricao), 1, 0, "L", FALSE);
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
