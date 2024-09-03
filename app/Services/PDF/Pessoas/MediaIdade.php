<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class MediaIdade extends PdfService
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

    function mediaIdadePdf($dados)
    {

        $this->AliasNbPages("{total}");
        $this->AddPage("L");

        # Logomarca (caminho da imagem, posicao a esquerda, posicao ao topo, largura, altura)
        $this->Image(public_path("images/logo.png"), 20, 5, 20);
        $this->Ln(20); # imprime linhas...
        $this->SetY(25);
        $this->SetX(0);

        $this->SetFillColor(196,210,205);
        $this->SetTextColor(0);
        $this->SetDrawColor(240);

        # Conteudo: dados pessoais
        $this->SetY(10);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Sistema de Vida Religiosa"), 0, 0, "C");
        $this->Ln();
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Congregação das"), 0, 0, "C");
        $this->Ln();
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Irmãs do Imaculado Coração de Maria"), 0, 0, "C");
        $this->Ln();
        $this->Ln(2);
        # verifica se houveram resultados
        if ($dados->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255,140,0);
            $this->SetTextColor(255,255,255);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Relatório de Faixa Etária : Média de Pessoas por Idade"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $total = $dados->count();
            $quantidade20 = 0;
            $quantidade30 = 0;
            $quantidade40 = 0;
            $quantidade50 = 0;
            $quantidade60 = 0;
            $quantidade70 = 0;
            $quantidade80 = 0;
            $quantidade90 = 0;
            $quantidadeMaior90 = 0;
            $somaIdade = 0;
            $provincia = "";

            foreach ($dados as $pessoa)
            {
                $idade = Carbon::parse($pessoa->datanascimento)->age;
                // if (isset($_GET["pro"]) && $_GET["pro"] > 0 && $provincia == "")
                // {
                //     $this->SetFillColor(196,210,205);

                //     $this->SetX(20);
                //     $this->SetFont("Arial", "B", 12);
                //     $this->Cell(170, 10, iconv("utf-8","iso-8859-1", $pessoa["provinciapessoa"]), 1, 0, "L", TRUE);
                //     $this->Ln();

                //     $provincia = $pessoa["provinciapessoa"];

                //     $this->SetFillColor(204);
                // }

                if ($idade <= 20) { $quantidade20++; }
                if ($idade > 20 and $idade <= 30) { $quantidade30++; }
                if ($idade > 30 and $idade <= 40) { $quantidade40++; }
                if ($idade > 40 and $idade <= 50) { $quantidade50++; }
                if ($idade > 50 and $idade <= 60) { $quantidade60++; }
                if ($idade > 60 and $idade <= 70) { $quantidade70++; }
                if ($idade > 70 and $idade <= 80) { $quantidade80++; }
                if ($idade > 80 and $idade <= 90) { $quantidade90++; }
                if ($idade > 90) { $quantidadeMaior90++; }

                $somaIdade += $idade;
            }

            $this->SetX(20);
            $this->SetFont("Arial", "B", 12);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "Faixa Etária"), 1, 0, "L", TRUE);
            $this->Cell(30, 7, iconv("utf-8","iso-8859-1", "Quantidade"), 1, 0, "C", TRUE);
            $this->Cell(40, 7, iconv("utf-8","iso-8859-1", "Percentual"), 1, 0, "C", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "Até 20 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade20, 1, 0, "C", FALSE);
            $media = number_format(($quantidade20 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 21 a 30 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade30, 1, 0, "C", FALSE);
            $media = number_format(($quantidade30 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 31 a 40 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade40, 1, 0, "C", FALSE);
            $media = number_format(($quantidade40 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 41 a 50 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade50, 1, 0, "C", FALSE);
            $media = number_format(($quantidade50 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 51 a 60 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade60, 1, 0, "C", FALSE);
            $media = number_format(($quantidade60 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 61 a 70 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade70, 1, 0, "C", FALSE);
            $media = number_format(($quantidade70 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 71 a 80 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade80, 1, 0, "C", FALSE);
            $media = number_format(($quantidade80 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "De 81 a 90 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidade90, 1, 0, "C", FALSE);
            $media = number_format(($quantidade90 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "Acima de 90 anos"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $quantidadeMaior90, 1, 0, "C", FALSE);
            $media = number_format(($quantidadeMaior90 * 100) / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$media}%", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetDrawColor(220);
            $this->SetFillColor(196,210,205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 12);
            $this->Cell(170, 2, "", 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);


            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 12);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "Geral"), 1, 0, "L", TRUE);
            $this->Cell(30, 7, iconv("utf-8","iso-8859-1", "Quantidade"), 1, 0, "C", TRUE);
            $this->Cell(40, 7, iconv("utf-8","iso-8859-1", "Média de Idade"), 1, 0, "C", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 10);
            $this->Cell(100, 7, iconv("utf-8","iso-8859-1", "Total de Pessoas"), 1, 0, "L", FALSE);
            $this->Cell(30, 7, $total, 1, 0, "C", FALSE);
            $mediaGeral = number_format($somaIdade / $total, 2, ",", ".");
            $this->Cell(40, 7, "{$mediaGeral}", 1, 0, "C", FALSE);
            $this->Ln();

            $this->SetDrawColor(220);
            $this->SetFillColor(196,210,205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 12);
            $this->Cell(170, 2, "", 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->Output();
        } else {
            $this->pdfVazio();

            $this->Output();
        }
    }
}
