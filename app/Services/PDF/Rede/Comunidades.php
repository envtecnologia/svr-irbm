<?php

namespace App\Services\PDF\Rede;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Comunidades extends PdfService
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

    function comunidades_anivPdf($dados)
    {

        $this->AliasNbPages("{total}");
        $this->AddPage("L");

        # Logomarca (caminho da imagem, posicao a esquerda, posicao ao topo, largura, altura)
        $this->Image(public_path("images/logo.jpg"), 20, 5, 20);
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
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Relatórios de Aniversariantes - Comunidades ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $mes = "";
            $quantitativo = 0;

            foreach ($dados as $comunidade)
            {
                if ($provincia != $comunidade["provincia_nome"])
                {
                    if ($quantitativo > 0)
                    {
                        $this->SetDrawColor(220);
                        $this->SetFillColor(196,210,205);

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(250, 2, "", 1, 0, "L", TRUE);
                        $this->Ln();
                        $this->Ln(2);
                    }

                    $this->SetDrawColor(220);
                    $this->SetFillColor(196,210,205);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8","iso-8859-1", $comunidade["provincia_nome"]), 1, 0, "L", TRUE);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $provincia = $comunidade["provincia_nome"];

                    $verMes = substr($comunidade["fundacao"], 5, 2);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);

                    switch ($verMes)
                    {
                        case "01":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Janeiro"), 1, 0, "L", TRUE);
                            break;
                        case "02":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Fevereiro"), 1, 0, "L", TRUE);
                            break;
                        case "03":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Março"), 1, 0, "L", TRUE);
                            break;
                        case "04":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Abril"), 1, 0, "L", TRUE);
                            break;
                        case "05":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Maio"), 1, 0, "L", TRUE);
                            break;
                        case "06":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Junho"), 1, 0, "L", TRUE);
                            break;
                        case "07":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Julho"), 1, 0, "L", TRUE);
                            break;
                        case "08":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Agosto"), 1, 0, "L", TRUE);
                            break;
                        case "09":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Setembro"), 1, 0, "L", TRUE);
                            break;
                        case "10":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Outubro"), 1, 0, "L", TRUE);
                            break;
                        case "11":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Novembro"), 1, 0, "L", TRUE);
                            break;
                        case "12":
                            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Dezembro"), 1, 0, "L", TRUE);
                            break;
                    }

                    $this->Ln();
                    $mes = $verMes;

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(100, 6, iconv("utf-8","iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                    $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Aniversário"), 1, 0, "C", TRUE);
                    $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "Cidade"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "Telefone(1)"), 1, 0, "C", TRUE);
                    $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }
                else
                {
                    $verMes = substr($comunidade["fundacao"], 5, 2);

                    if ($mes != $verMes)
                    {
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);

                        switch ($verMes)
                        {
                            case "01":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Janeiro"), 1, 0, "L", TRUE);
                                break;
                            case "02":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Fevereiro"), 1, 0, "L", TRUE);
                                break;
                            case "03":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Março"), 1, 0, "L", TRUE);
                                break;
                            case "04":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Abril"), 1, 0, "L", TRUE);
                                break;
                            case "05":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Maio"), 1, 0, "L", TRUE);
                                break;
                            case "06":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Junho"), 1, 0, "L", TRUE);
                                break;
                            case "07":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Julho"), 1, 0, "L", TRUE);
                                break;
                            case "08":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Agosto"), 1, 0, "L", TRUE);
                                break;
                            case "09":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Setembro"), 1, 0, "L", TRUE);
                                break;
                            case "10":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Outubro"), 1, 0, "L", TRUE);
                                break;
                            case "11":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Novembro"), 1, 0, "L", TRUE);
                                break;
                            case "12":
                                $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Dezembro"), 1, 0, "L", TRUE);
                                break;
                        }

                        $this->Ln();
                        $mes = $verMes;

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 8);
                        $this->Cell(100, 6, iconv("utf-8","iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                        $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Aniversário"), 1, 0, "C", TRUE);
                        $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "Cidade"), 1, 0, "L", TRUE);
                        $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "Telefone(1)"), 1, 0, "C", TRUE);
                        $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                        $this->SetTextColor(0);
                        $this->Ln();
                    }
                }

                $cidade = ($comunidade["cidade"] != "" ? $comunidade["cidade"]->descricao : "---");
                $telefone1 = ($comunidade["telefone1"] != "" ? $comunidade["telefone1"] : "---");
                $email = ($comunidade["email"] != "" ? $comunidade["email"] : "---");

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(92, 6, iconv("utf-8","iso-8859-1", $comunidade["descricao"]), 1, 0, "L", FALSE);

                $aniversario = substr($comunidade["fundacao"], 8, 2) . "/"
                             . substr($comunidade["fundacao"], 5, 2);

                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $aniversario), 1, 0, "C", FALSE);
                $this->Cell(50, 6, iconv("utf-8","iso-8859-1", $cidade), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8","iso-8859-1", $telefone1), 1, 0, "C", FALSE);
                $this->Cell(50, 6, iconv("utf-8","iso-8859-1", $email), 1, 0, "L", FALSE);
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

    function comunidadesPdf($dados)
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
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Relatórios de Comunidades ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantidade = 0;

            foreach ($dados as $comunidade)
            {
                $c_provincia = ($comunidade["provincia"] ? $comunidade["provincia"]->descricao : '');
                if ($provincia != $c_provincia)
                {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(196,210,205);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8","iso-8859-1", $c_provincia), 1, 0, "L", TRUE);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $provincia = $c_provincia;

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(90, 6, iconv("utf-8","iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "Situação"), 1, 0, "L", TRUE);
                    $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "Cidade"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "Telefone(1)"), 1, 0, "C", TRUE);
                    $this->Cell(50, 6, iconv("utf-8","iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $quantidade++;

                if ($comunidade["situacao"] == "1")
                {
                    $encerramento = "Ativa";
                }
                else
                {
                    $encerramento = "Encerrada (".
                                    substr($comunidade["encerramento"],8,2)."/".
                                    substr($comunidade["encerramento"],5,2)."/".
                                    substr($comunidade["encerramento"],0,4).")";
                }

                $cidade = ($comunidade["cidade"] != "" ? $comunidade["cidade"]->descricao : "---");
                $telefone1 = ($comunidade["telefone1"] != "" ? $comunidade["telefone1"] : "---");
                $email = ($comunidade["email1"] != "" ? $comunidade["email1"] : "---");

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantidade, 1, 0, "R", FALSE);
                $this->Cell(82, 6, iconv("utf-8","iso-8859-1", $comunidade["descricao"]), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8","iso-8859-1", $encerramento), 1, 0, "L", FALSE);
                $this->Cell(50, 6, iconv("utf-8","iso-8859-1", $cidade), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8","iso-8859-1", $telefone1), 1, 0, "C", FALSE);
                $this->Cell(50, 6, iconv("utf-8","iso-8859-1", $email), 1, 0, "L", FALSE);
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
