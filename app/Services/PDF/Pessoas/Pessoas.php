<?php

namespace App\Services\PDF\Pessoas;

use App\Services\PdfService;
use Carbon\Carbon;
use Exception;

class Pessoas extends PdfService
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

    function pessoasPdf($dados)
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

                if ($provincia != $pessoa["provincia"]["descricao"]) {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", $pessoa["provincia"]["descricao"]), 1, 0, "L", TRUE);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $provincia = $pessoa["provincia"]["descricao"];

                    $this->SetX(22);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(80, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                    $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Categoria"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Origem"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Raça"), 1, 0, "L", TRUE);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(72, 6, iconv("utf-8", "iso-8859-1", $pessoa["comunidade"]->descricao), 1, 0, "L", FALSE);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["sobrenome"]}, {$pessoa["nome"]}"), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["tipo_pessoa"]->descricao), 1, 0, "L", FALSE);

                if ($pessoa["origem"] != "") {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["origem"]->descricao), 1, 0, "L", FALSE);
                } else {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "---"), 1, 0, "L", FALSE);
                }

                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["raca"]->descricao), 1, 0, "L", FALSE);
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

    function faixasetarias($dados)
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
        if ($dados->isNotNull()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatório por Faixa Etária ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantitativo = 0;

            foreach ($dados as $pessoa) {
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
                    $this->Cell(28, 6, iconv("utf-8", "iso-8859-1", "Idade"), 1, 0, "C", TRUE);
                    $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Categoria"), 1, 0, "L", TRUE);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Origem"), 1, 0, "L", TRUE);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Raça"), 1, 0, "L", TRUE);
                    $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(1)"), 1, 0, "L", TRUE);
                    $this->Cell(57, 6, iconv("utf-8", "iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $pessoa["idade"]), 1, 0, "C", FALSE);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["sobrenome"]}, {$pessoa["nome"]}"), 1, 0, "L", FALSE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["tipo_pessoa"]->descricao), 1, 0, "L", FALSE);

                if ($pessoa["origem"] != "") {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["origem"]->descricao), 1, 0, "L", FALSE);
                } else {
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "---"), 1, 0, "L", FALSE);
                }

                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $pessoa["raca"]), 1, 0, "L", FALSE);
                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $pessoa["telefone1"]), 1, 0, "L", FALSE);
                $this->Cell(57, 6, iconv("utf-8", "iso-8859-1", $pessoa["email"]), 1, 0, "L", FALSE);
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
        }
    }

    function formacoes($dados)
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
        if ($dados->isNotNull()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatório por Faixa Etária ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantitativo = 0;

            foreach ($dados as $pessoa) {
                $this->SetDrawColor(220);
                $this->SetFillColor(196, 210, 205);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["tipo_formacao"]->descricao}"), 1, 0, "L", TRUE);
                $this->Ln();

                $this->SetFillColor(204);
                $tipo = $pessoa["tipo_formacao"]->descricao;

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(28, 6, iconv("utf-8", "iso-8859-1", "Início"), 1, 0, "C", TRUE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Prazo"), 1, 0, "C", TRUE);
                $this->Cell(122, 6, iconv("utf-8", "iso-8859-1", "Pessoa"), 1, 0, "L", TRUE);
                $this->Cell(80, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();


                $data = substr($pessoa["data"], 8, 2) . "/"
                    . substr($pessoa["data"], 5, 2) . "/"
                    . substr($pessoa["data"], 0, 4);

                $prazo =
                    substr($pessoa["prazo"], 8, 2) . "/"
                    . substr($pessoa["prazo"], 5, 2) . "/"
                    . substr($pessoa["prazo"], 0, 4);

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);
                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $data), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $prazo), 1, 0, "C", FALSE);
                $this->Cell(122, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["sobrenome"]}, {$pessoa["nome"]}"), 1, 0, "L", FALSE);
                $this->Cell(80, 6, iconv("utf-8", "iso-8859-1", $pessoa["comunidade"]->descricao), 1, 0, "L", FALSE);
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
        }
    }

    function formacoesAcademicas($dados)
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
        if ($dados->isNotNull()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "Relatório por Faixa Etária ({$dados->count()} registros)"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $provincia = "";
            $quantitativo = 0;

            foreach ($dados as $pessoa) {
                $this->SetDrawColor(220);
                $this->SetFillColor(196, 210, 205);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $escolaridadeImpressao = ($pessoa["escolaridade"] != "" ? $pessoa["escolaridade"] : "{não informada}");
                $this->Cell(250, 6, iconv("utf-8", "iso-8859-1", "{$escolaridadeImpressao}"), 1, 0, "L", TRUE);
                $this->Ln();
                $escolaridade = $pessoa["escolaridade"];

                $this->SetFillColor(204);

                $this->SetX(22);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Nome"), 1, 0, "L", TRUE);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", TRUE);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Categoria"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $quantitativo++;

            $this->SetX(22);
            $this->SetFont("Arial", "", 8);
            $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
            $this->Cell(92, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["sobrenome"]}, {$pessoa["nome"]}"), 1, 0, "L", FALSE);
            $provincia = ($pessoa["provincia"] != "" ? $pessoa["provincia"]->descricao : "---");
            $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", $provincia), 1, 0, "L", FALSE);
            $comunidade = ($pessoa["comunidade"] != "" ? $pessoa["comunidade"]->descricao : "---");
            $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", $comunidade), 1, 0, "L", FALSE);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa["tipo_pessoa"]->descricao), 1, 0, "L", FALSE);
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
    }

    function porPeriodoProvincia($dados)
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
        if ($dados->isNotNull()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255,140,0);
            $this->SetTextColor(255,255,255);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "Relatórios de Pessoas por Comunidade no Período"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $quantitativo = 0;

            $this->SetDrawColor(220);
            $this->SetFillColor(196,210,205);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(250, 6, iconv("utf-8","iso-8859-1", "{$pessoa["provincia"]->descricao} -> {$pessoa["comunidade"]->descricao}"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetX(22);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(140, 6, iconv("utf-8","iso-8859-1", "Nome Completo"), 1, 0, "L", TRUE);
            $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Chegada"), 1, 0, "C", TRUE);
            $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Saída"), 1, 0, "C", TRUE);
            $this->Cell(30, 6, iconv("utf-8","iso-8859-1", "CPF"), 1, 0, "C", TRUE);
            $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Data Nasc."), 1, 0, "C", TRUE);
            $this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Situação"), 1, 0, "L", TRUE);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($dados as $pessoa) {
                $situacao = ($pessoa["situacao"] == 1 ? "ativa(o)" :  "inativo(o)");

                # verifica falecimento
                if ($pessoa["situacao"] == 0)
                {
                    $falecimentos = new Repositorio("icmsec_svr", "falecimentos");
                    $falecimentos->campos = array("fkcodpessoa");
                    $falecimentos->dados = array($pessoa["codpessoa"]);
                    $retornoFalecimento = $falecimentos->retornarDados();

                    if ($falecimentos->quantidade_linhas > 0)
                    {
                        $situacao = "falecido(a)";
                    }
                }

                $dataEgresso = new Repositorio("icmsec_svr", "vwitinerarios");
                $dataEgresso->query = " select chegada, saida from icmsec_svr.vwitinerarios
                                        where codpessoa = {$pessoa["codpessoa"]}
                                            and codprovinciaatual = {$_GET["pro"]}
                                            and codcomunidadeatual = {$_GET["com"]}
                                        order by chegada desc limit 1;
                                        ";
                $retornoEgresso = $dataEgresso->carregarConsultaPersonalizada();

                $pessoaEgresso = mysqli_fetch_array($retornoEgresso);

                $dataEntrada =
                      substr($pessoaEgresso["chegada"], 8, 2) . "/"
                    . substr($pessoaEgresso["chegada"], 5, 2) . "/"
                    . substr($pessoaEgresso["chegada"], 0, 4);

                if ($pessoaEgresso["saida"] != "")
                {
                    $dataSaida =
                          substr($pessoaEgresso["saida"], 8, 2) . "/"
                        . substr($pessoaEgresso["saida"], 5, 2) . "/"
                        . substr($pessoaEgresso["saida"], 0, 4);
                }
                else
                {
                    $dataSaida = "---";
                }

                $quantitativo++;

                $this->SetX(22);
                $this->SetFont("Arial", "", 8);

                $this->Cell(8, 6, $quantitativo, 1, 0, "R", FALSE);
                $this->Cell(132, 6, iconv("utf-8","iso-8859-1", " {$pessoa["nome"]}"), 1, 0, "L", FALSE);

                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $dataEntrada), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $dataSaida), 1, 0, "C", FALSE);
                $this->Cell(30, 6, iconv("utf-8","iso-8859-1", $pessoa["cpf"]), 1, 0, "C", FALSE);
                $pessoa["datanascimento"] != ""
                    ? $dataNascimento =
                          substr($pessoa["datanascimento"], 8, 2) . "/"
                        . substr($pessoa["datanascimento"], 5, 2) . "/"
                        . substr($pessoa["datanascimento"], 0, 4)
                    : $dataNascimento = "---";
                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $dataNascimento), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8","iso-8859-1", $situacao), 1, 0, "L", FALSE);
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
    }
}
}
