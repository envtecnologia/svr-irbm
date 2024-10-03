<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Capitulos extends PdfService
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

    function capitulosPdf($dados)
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

        # Conteudo: dados is
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

        if ($dados->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatórios de Capítulos"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantidadeProvincia = 0;

            foreach($dados as $dado) {
                if ($provincia != $dado["cod_provincia_id"]) {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(204);

                    if ($quantidadeProvincia > 0) {
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(250, 2, "", 1, 0, "L", TRUE);
                        $this->SetTextColor(0);
                        $this->Ln();
                        $this->Ln(2);
                    }

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Capítulo"), 1, 0, "C", TRUE);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data"), 1, 0, "C", TRUE);
                    $this->Cell(210, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $data = substr($dado["data"], 8, 2) . "/" .
                    substr($dado["data"], 5, 2) . "/" .
                    substr($dado["data"], 0, 4);

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dado["numero"]), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $data), 1, 0, "C", FALSE);

                if ($dado["provincia"] != "") {
                    $provincia = $dado["provincia"]->descricao;
                } else {
                    $provincia = "Geral";
                }
                $quantidadeProvincia++;

                $this->Cell(210, 6, iconv("utf-8", "iso-8859-1", $provincia), 1, 0, "L", FALSE);
                $this->SetTextColor(0);
                $this->Ln();

                $this->SetDrawColor(220);
                $this->SetFillColor(204);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Descrição do Capítulo"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();

                $data = substr($dado["data"], 8, 2) . "/" .
                    substr($dado["data"], 5, 2) . "/" .
                    substr($dado["data"], 0, 4);

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->MultiCell(250, 4, iconv("utf-8", "iso-8859-1", $dado["detalhes"]), 1, "J", FALSE);
                $this->SetTextColor(0);

                $quantidadeConselheiras = 0;

                # verifica se houveram resultados
                if ($dado->equipes->isNotEmpty()) {
                    # equipe
                    $this->SetDrawColor(220);
                    $this->SetFillColor(204);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Conselheiras ({$dado->equipes->count()} registros)"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $this->SetX(22);
                    $this->SetFont("Arial", "", 8);
                    $this->Cell(58, 6, iconv("utf-8", "iso-8859-1", "Função"), 1, 0, "L", TRUE);
                    $this->Cell(96, 6, iconv("utf-8", "iso-8859-1", "Conselheira"), 1, 0, "L", TRUE);
                    $this->Cell(96, 6, iconv("utf-8", "iso-8859-1", "Nome Religioso"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $this->SetDrawColor(220);
                    $this->SetFillColor(204);

                    foreach ($dado->equipes as $equipe) {
                        $funcao = ($equipe["principal"] == 0 ? "Conselheira" : "Superiora Geral Eleita");
                        $nome = "{$equipe["pessoa"]->sobrenome}, {$equipe["pessoa"]->nome}";
                        $religiosa = ($equipe["pessoa"]->religiosa != "" ? $equipe["pessoa"]->religiosa : " --- ");
                        $quantidadeConselheiras++;

                        $this->SetX(22);
                        $this->SetFont("Arial", "", 8);
                        $this->Cell(8, 6, $quantidadeConselheiras, 1, 0, "R", FALSE);
                        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $funcao), 1, 0, "L", FALSE);
                        $this->Cell(96, 6, iconv("utf-8", "iso-8859-1", $nome), 1, 0, "L", FALSE);
                        $this->Cell(96, 6, iconv("utf-8", "iso-8859-1", $religiosa), 1, 0, "L", FALSE);
                        $this->Ln();
                    }
                } else {
                    $this->SetX(22);
                    $this->SetFont("Arial", "", 8);
                    $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "não há conselheiras cadastradas"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }
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
