<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class RelatorioCivil extends PdfService
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

    function relatorioCivilPdf($dados)
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
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatórios de Pessoas ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantitativo = 0;

                $this->SetDrawColor(220);
                $this->SetFillColor(204);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(110, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "RG"), 1, 0, "L", TRUE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Orgão Emissor"), 1, 0, "L", TRUE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "CPF"), 1, 0, "L", TRUE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Data Nascimento"), 1, 0, "L", TRUE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();


            foreach ($dados as $pessoa) {
                $situacao = ($pessoa["situacao"] == 1 ? "ativa(o)" :  "inativo(o)");

                # verifica falecimento
                if ($pessoa->situacaopessoa == 0) {
                    $falecimento = $pessoa->falecimento()->first();
                    if ($falecimento) {
                        if (!is_null($falecimento->datafalecimento)) {
                            $dataFalecimento = Carbon::make($falecimento->datafalecimento)->format('d/m/Y');
                        } else {
                            $dataFalecimento = '//';
                        }
                        $situacao = "Falecido(a) em {$dataFalecimento}";
                    }
                }

                    if ($provincia != $pessoa["provincia"]->descricao) {
                        $this->SetDrawColor(220);
                        $this->SetFillColor(196, 210, 205);

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", $pessoa["provincia"]->descricao), 1, 0, "L", TRUE);
                        $this->Ln();

                        $this->SetFillColor(204);
                        $provincia = $pessoa["provincia"]->descricao;

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(110, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "RG"), 1, 0, "L", TRUE);
                        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Orgão Emissor"), 1, 0, "L", TRUE);
                        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "CPF"), 1, 0, "L", TRUE);
                        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Data Nascimento"), 1, 0, "L", TRUE);
                        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "L", TRUE);
                        $this->SetTextColor(0);
                        $this->Ln();
                    }


                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);

                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(102, 6, iconv("utf-8", "iso-8859-1", " {$pessoa["nome"]}"), 1, 0, "L", FALSE);

                if ($pessoa["rg"] != "") {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["rg"]), 1, 0, "L", FALSE);
                } else {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "---"), 1, 0, "L", FALSE);
                }
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["rgorgao"]), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["cpf"]), 1, 0, "L", FALSE);
                $pessoa["datanascimento"] != ""
                    ? $dataNascimento =
                    substr($pessoa["datanascimento"], 8, 2) . "/"
                    . substr($pessoa["datanascimento"], 5, 2) . "/"
                    . substr($pessoa["datanascimento"], 0, 4)
                    : $dataNascimento = "---";
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $dataNascimento), 1, 0, "L", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $situacao), 1, 0, "L", FALSE);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

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
