<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Atividades extends PdfService
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

    function atividadesPdf($dados)
    {

        if($dados->count() > 2000){
            echo "Muitos registros para serem impressos, reduza o numero com os filtros";
            return false;
        }

        $this->AliasNbPages("{total}");
        $this->AddPage();

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
        $this->SetX(22);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Sistema de Vida Religiosa"), 0, 0, "C");
        $this->Ln();
        $this->SetX(22);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Congregação das"), 0, 0, "C");
        $this->Ln();
        $this->SetX(22);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8","iso-8859-1", "Irmãs do Imaculado Coração de Maria"), 0, 0, "C");
        $this->Ln();
        $this->Ln(2);
           # verifica se houveram resultados
           if ($dados->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Relatórios por Atividades ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $pessoa = "";

            foreach ($dados as $atividade) {
                if ($pessoa != "{$atividade["pessoa"]["nome"]}{$atividade["tipo_atividade"]["descricao"]}") {
                    if ($pessoa != "") {
                        $this->AddPage();

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
                        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Sistema de Vida Religiosa"), 0, 0, "C");
                        $this->Ln();
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 10);
                        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Congregação das"), 0, 0, "C");
                        $this->Ln();
                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 10);
                        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Irmãs do Imaculado Coração de Maria"), 0, 0, "C");
                        $this->Ln();
                        $this->Ln(2);

                        $this->SetDrawColor(220);
                        $this->SetFillColor(255, 140, 0);
                        $this->SetTextColor(255, 255, 255);

                        $this->SetX(22);
                        $this->SetFont("Arial", "B", 10);
                        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Relatórios por Atividades ({$dados->count()} registros)"), 1, 0, "L", TRUE);
                        $this->Ln();
                        $this->Ln(2);

                        $this->SetTextColor(0);
                    }

                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    $situacao = "em andamento";

                    if ($atividade["datafinal"] != "") {
                        $dataFinal = substr($atividade["datafinal"], 8, 2) . "/"
                            . substr($atividade["datafinal"], 5, 2) . "/"
                            . substr($atividade["datafinal"], 0, 4);

                        if ($atividade["datafinal"] < date("Y-m-d")) {
                            $situacao = "concluído em {$dataFinal}";
                        }
                    }

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "{$atividade["tipo_atividade"]["descricao"]} ({$situacao})"), 1, 0, "L", TRUE);
                    $this->Ln();
                    $pessoa = "{$atividade["pessoa"]["nome"]}{$atividade["tipo_atividade"]["descricao"]}";

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                    $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", "Data Nascimento"), 1, 0, "C", TRUE);
                    $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", "Idade"), 1, 0, "C", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $idade = Carbon::parse($atividade["pessoa"]["datanascimento"])->age;

                    $data = substr($atividade["pessoa"]["datanascimento"], 8, 2) . "/"
                        . substr($atividade["pessoa"]["datanascimento"], 5, 2) . "/"
                        . substr($atividade["pessoa"]["datanascimento"], 0, 4);

                    $this->SetX(22);
                    $this->SetFont("Arial", "", 8);
                    $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "{$atividade["pessoa"]["sobrenome"]}, {$atividade["pessoa"]["nome"]}"), 1, 0, "L", FALSE);
                    $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", $data), 1, 0, "C", FALSE);
                    $this->Cell(35, 6, $idade . " anos", 1, 0, "C", FALSE);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(170, 2, "", 1, 0, "L", TRUE);
                    $this->Ln();
                    $this->Ln(2);
                }
                -$this->SetFillColor(204);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Local"), 1, 0, "L", TRUE);
                $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", "Data Início"), 1, 0, "C", TRUE);
                $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", "Data Final"), 1, 0, "C", TRUE);
                $this->SetTextColor(0);
                $this->Ln();

                $obra = ($atividade["obra"] != "" ? $atividade["obra"]["descricao"] : " {não informado}");

                $situacao = "em andamento";

                $dataInicio = substr($atividade["datainicio"], 8, 2) . "/"
                    . substr($atividade["datainicio"], 5, 2) . "/"
                    . substr($atividade["datainicio"], 0, 4);

                if ($atividade["datafinal"] != "") {
                    if ($atividade["datafinal"] < date("Y-m-d")) {
                        $situacao = "concluído";
                    }

                    $dataFinal = substr($atividade["datafinal"], 8, 2) . "/"
                        . substr($atividade["datafinal"], 5, 2) . "/"
                        . substr($atividade["datafinal"], 0, 4);
                } else {
                    $dataFinal = "---";
                }

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "{$obra}"), 1, 0, "L", FALSE);
                $this->Cell(35, 6, $dataInicio, 1, 0, "C", FALSE);
                $this->Cell(35, 6, $dataFinal, 1, 0, "C", FALSE);
                $this->SetTextColor(0);
                $this->Ln();

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Endereço da Obra"), 1, 0, "L", TRUE);
                $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Cidade/Estado"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();

                if ($atividade["obra"]->endereco != "") {
                    $endereco = $atividade["obra"]->endereco;
                } else {
                    $endereco = " {não informado}";
                }

                if ($atividade["cidade"] != "") {
                    $localidade  = "{$atividade["obra"]["cidade"]["descricao"]}, {$atividade["obra"]["cidade"]["estado"]["descricao"]}";
                    $localidade .= ($atividade["obra"]["cidade"]["estado"]["sigla"] != "" ? " ({$atividade["obra"]["cidade"]["estado"]["sigla"]})" : "");
                } else {
                    $localidade = " {não informado}";
                }

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "{$endereco}"), 1, 0, "L", FALSE);
                $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $localidade), 1, 0, "L", FALSE);
                $this->SetTextColor(0);
                $this->Ln();
                $this->Ln(2);
            }

            $this->Output();
        } else {
            $this->pdfVazio();

            $this->Output();
        }
    }
}
