<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Aniversariantes extends PdfService
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

    function aniversariantesPdf($dados)
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
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatórios de Aniversariantes ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $mes = "";
            $quantitativo = 0;

            foreach ($dados as $aniversariante) {
                if ($provincia != $aniversariante["provincia"]["descricao"]) {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    if ($quantitativo > 0) {
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(250, 2, "", 1, 0, "L", TRUE);
                        $this->Ln();
                        $this->Ln(2);
                    }

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", $aniversariante["provincia"]["descricao"]), 1, 0, "L", TRUE);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $provincia = $aniversariante["provincia"]["descricao"];

                    $verMes = substr($aniversariante["datanascimento"], 5, 2);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);

                    switch ($verMes) {
                        case "01":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Janeiro"), 1, 0, "L", TRUE);
                            break;
                        case "02":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Fevereiro"), 1, 0, "L", TRUE);
                            break;
                        case "03":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Março"), 1, 0, "L", TRUE);
                            break;
                        case "04":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Abril"), 1, 0, "L", TRUE);
                            break;
                        case "05":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Maio"), 1, 0, "L", TRUE);
                            break;
                        case "06":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Junho"), 1, 0, "L", TRUE);
                            break;
                        case "07":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Julho"), 1, 0, "L", TRUE);
                            break;
                        case "08":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Agosto"), 1, 0, "L", TRUE);
                            break;
                        case "09":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Setembro"), 1, 0, "L", TRUE);
                            break;
                        case "10":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Outubro"), 1, 0, "L", TRUE);
                            break;
                        case "11":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Novembro"), 1, 0, "L", TRUE);
                            break;
                        case "12":
                            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Dezembro"), 1, 0, "L", TRUE);
                            break;
                    }

                    $this->Ln();
                    $mes = $verMes;

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                    $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Aniversário"), 1, 0, "C", TRUE);
                    $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(1)"), 1, 0, "C", TRUE);
                    $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                } else {
                    $verMes = substr($aniversariante["datanascimento"], 5, 2);

                    if ($mes != $verMes) {
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);

                        switch ($verMes) {
                            case "01":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Janeiro"), 1, 0, "L", TRUE);
                                break;
                            case "02":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Fevereiro"), 1, 0, "L", TRUE);
                                break;
                            case "03":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Março"), 1, 0, "L", TRUE);
                                break;
                            case "04":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Abril"), 1, 0, "L", TRUE);
                                break;
                            case "05":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Maio"), 1, 0, "L", TRUE);
                                break;
                            case "06":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Junho"), 1, 0, "L", TRUE);
                                break;
                            case "07":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Julho"), 1, 0, "L", TRUE);
                                break;
                            case "08":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Agosto"), 1, 0, "L", TRUE);
                                break;
                            case "09":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Setembro"), 1, 0, "L", TRUE);
                                break;
                            case "10":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Outubro"), 1, 0, "L", TRUE);
                                break;
                            case "11":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Novembro"), 1, 0, "L", TRUE);
                                break;
                            case "12":
                                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Dezembro"), 1, 0, "L", TRUE);
                                break;
                        }

                        $this->Ln();
                        $mes = $verMes;

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                        $this->Cell(40, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Aniversário"), 1, 0, "C", TRUE);
                        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(1)"), 1, 0, "C", TRUE);
                        $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                        $this->SetTextColor(0);
                        $this->Ln();
                    }
                }

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(62, 6, iconv("utf-8", "iso-8859-1", "{$aniversariante["sobrenome"]}, {$aniversariante["nome"]}"), 1, 0, "L", FALSE);
                $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $aniversariante["comunidade"]["descricao"]), 1, 0, "L", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $aniversariante["aniversario"]), 1, 0, "C", FALSE);
                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $aniversariante["telefone1"]), 1, 0, "C", FALSE);
                $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", $aniversariante["email"]), 1, 0, "L", FALSE);
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
