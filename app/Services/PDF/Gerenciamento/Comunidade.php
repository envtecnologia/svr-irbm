<?php

namespace App\Services\PDF\Gerenciamento;

use App\Models\Curso;
use App\Models\Endereco;
use App\Models\Familiares;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Formacao;
use App\Models\Pessoal\Funcao;
use App\Models\Pessoal\Habilidade;
use App\Models\Pessoal\Historico;
use App\Models\Pessoal\Itinerario;
use App\Models\Pessoal\OcorrenciaMedica;
use App\Models\Pessoal\Pessoa;
use App\Services\PdfService;
use Carbon\Carbon;

class Comunidade extends PdfService
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

    public function comunidadePdf($comunidade)
    {
        $this->AliasNbPages("{total}");
        $this->AddPage();
        $this->Image(public_path('images/logo.png'), 20, 5, 20);
        $this->Ln(20); # imprime linhas...
        $this->SetY(25);
        $this->SetX(0);

        $this->SetFillColor(196, 210, 205);
        $this->SetTextColor(0);
        $this->SetDrawColor(240);

        # Conteudo: dados comunidadeis
        $this->SetY(10);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 12);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Sistema de Vida Religiosa"), 0, 0, "C");
        $this->Ln();
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Congregação das"), 0, 0, "C");
        $this->Ln();
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Irmãs do Imaculado Coração de Maria"), 0, 0, "C");
        $this->Ln();
        $this->Ln(2);


        // Dados comunidade

        if (!empty($comunidade)) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Ficha Cadastral da Comunidade"), 1, 0, "C", TRUE);
            $this->Ln();
            $this->Ln(2);

            $foto = (!empty($comunidade["foto"]) ? public_path("storage/uploads/comunidades/{$comunidade->foto}") : public_path("storage/uploads/comunidades/fotos/comunidade.jpg"));

            $this->Image($foto, 25, $this->GetY() - 1, 75, 57);

            $foto2 = (!empty($comunidade["foto2"]) ? public_path("storage/uploads/comunidades/".$comunidade->foto2) : public_path("storage/uploads/comunidades/fotos/comunidade.jpg"));
            $this->Image($foto2, 110, $this->GetY() - 1, 75, 57);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->Ln(2);
            $this->SetY(106);
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(110, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Fundada em"), 1, 0, "C", TRUE);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Encerramento"), 1, 0, "C", TRUE);
            $this->Ln();

            $this->SetFillColor(204);

            $dataFundacao = (
                !empty($comunidade["fundacao"]) ?
                substr($comunidade["fundacao"], 8, 2) . "/"
                . substr($comunidade["fundacao"], 5, 2) . "/"
                . substr($comunidade["fundacao"], 0, 4)
                : "---");

            $dataEncerramento = (
                !empty($comunidade["encerramento"]) ?
                substr($comunidade["encerramento"], 8, 2) . "/"
                . substr($comunidade["encerramento"], 5, 2) . "/"
                . substr($comunidade["encerramento"], 0, 4)
                : "Ativa");

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(110, 6, iconv("utf-8", "iso-8859-1", $comunidade["descricao"]), 1, 0, "L", FALSE);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $dataFundacao), 1, 0, "C", FALSE);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $dataEncerramento), 1, 0, "C", FALSE);
            $this->Ln();
            $this->Ln(2);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", $comunidade["provincia"]->descricao), 1, 0, "L", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Diocese"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Bispo"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $comunidade["paroquia"]->diocese->descricao), 1, 0, "L", FALSE);
            $bispo = (!empty($comunidade["paroquia"]->diocese) ? $comunidade["paroquia"]->diocese->bispo : "---");
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $bispo), 1, 0, "L", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Paróquia"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Pároco"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $comunidade["paroquia"]->descricao), 1, 0, "L", FALSE);
            $paroco = (!empty($comunidade["paroquia"]) ? $comunidade["paroquia"]->paroco : "---");
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $paroco), 1, 0, "L", FALSE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Área Pastoral"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Setor Interno ICM"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $area = (!empty($comunidade["area"]) ? $comunidade["area"]->descricao : "---");
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $area), 1, 0, "L", FALSE);
            $setor = (!empty($comunidade->setor) ? $comunidade->setor->descricao : "---");
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $setor), 1, 0, "L", FALSE);
            $this->Ln();
            $this->Ln(2);

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->Ln(2);
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Contato"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);

            !empty($comunidade->endereco) ? $endereco = $comunidade->endereco : $endereco = "---";
            !empty($comunidade->cep) ? $cep = $comunidade->cep : $cep = "---";
            !empty($estado = ($comunidade->cidade) ? $comunidade->cidade->estado->sigla : $comunidade->cidade->estado->descricao);
            $localidade = "{$comunidade->cidade->estado->pais->descricao}, {$comunidade->cidade->descricao} ({$estado})";

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(80, 6, iconv("utf-8", "iso-8859-1", "Endereço"), 1, 0, "L", TRUE);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "CEP"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Localidade"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(80, 6, iconv("utf-8", "iso-8859-1", $endereco), 1, 0, "L", FALSE);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $cep), 1, 0, "L", FALSE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $localidade), 1, 0, "L", FALSE);
            $this->Ln();

            !empty($telefone1 = ($comunidade->telefone1) ? $comunidade->telefone1 : "---");
            !empty($telefone2 = ($comunidade->telefone2) ? $comunidade->telefone2 : "---");
            !empty($telefone3 = ($comunidade->telefone3) ? $comunidade->telefone3 : "---");
            !empty($caixaPostal = ($comunidade->caixapostal) ? $comunidade->caixapostal : "---");
            !empty($site = ($comunidade->site) ? $comunidade->site : "---");

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(1)"), 1, 0, "L", TRUE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(2)"), 1, 0, "L", TRUE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone(3)"), 1, 0, "L", TRUE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Caixa Postal"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Site"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $telefone1), 1, 0, "L", FALSE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $telefone2), 1, 0, "L", FALSE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $telefone3), 1, 0, "L", FALSE);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $caixaPostal), 1, 0, "L", FALSE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $site), 1, 0, "L", FALSE);
            $this->Ln();

            !empty($email1 = ($comunidade->email1) ? $comunidade->email1 : "---");
            !empty($email2 = ($comunidade->email2) ? $comunidade->email2 : "---");
            !empty($email3 = ($comunidade->email3) ? $comunidade->email3 : "---");

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", "E-mail(1)"), 1, 0, "L", TRUE);
            $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", "E-mail(2)"), 1, 0, "L", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "E-mail(3)"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $email1), 1, 0, "L", FALSE);
            $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $email2), 1, 0, "L", FALSE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $email3), 1, 0, "L", FALSE);
            $this->Ln();

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->Ln(2);
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Detalhes"), 1, 0, "L", TRUE);
            $this->Ln();

            $this->SetFillColor(204);
            $this->SetX(20);
            $this->SetFont("Arial", "", 8);
            !empty($detalhes = ($comunidade->detalhes) ? $comunidade->detalhes : "---");

            if (iconv("utf-8", "iso-8859-1", $detalhes) == "") {
                $this->MultiCell(170, 6, iconv("utf-8", "windows-1252", $detalhes), 1, "J", FALSE);
            } else {
                $this->MultiCell(170, 6, iconv("utf-8", "iso-8859-1", $detalhes), 1, "J", FALSE);
            }

            # verifica se tem historico de enderecos nas comunidades
            $enderecos = $comunidade->enderecos;

            if (count($enderecos) > 0) {
                $this->SetDrawColor(220);
                $this->SetFillColor(255, 140, 0);
                $this->SetTextColor(255, 255, 255);

                $this->Ln();
                $this->SetX(20);
                $this->SetFont("Arial", "B", 10);
                $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Histórico de Endereços"), 1, 0, "L", TRUE);
                $this->Ln();
                $this->Ln(2);

                $this->SetFillColor(204);
                $this->SetDrawColor(220);
                $this->SetTextColor(0);

                $filtro = "";

                $this->SetX(20);
                $this->SetFont("Arial", "B", 7);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Início"), 1, 0, "C", TRUE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Final"), 1, 0, "C", TRUE);
                $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", "Endereço"), 1, 0, "L", TRUE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "CEP"), 1, 0, "C", TRUE);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Localidade"), 1, 0, "L", TRUE);
                $this->SetTextColor(0);
                $this->Ln();

                foreach ($enderecos as $endereco) {
                    $dataInicio =
                        substr($endereco["datainicio"], 8, 2) . "/"
                        . substr($endereco["datainicio"], 5, 2) . "/"
                        . substr($endereco["datainicio"], 0, 4);
                    $prazo =
                        substr($endereco["datafinal"], 8, 2) . "/"
                        . substr($endereco["datafinal"], 5, 2) . "/"
                        . substr($endereco["datafinal"], 0, 4);

                    $this->SetX(20);
                    $this->SetFont("Arial", "", 8);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataInicio), 1, 0, "C", FALSE);
                    if ($prazo == "00/00/0000" || $endereco["prazo"] == "") {
                        $prazo = "atual";
                    }
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $prazo), 1, 0, "C", FALSE);
                    $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $endereco["endereco"]), 1, 0, "L", FALSE);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $endereco["cep"]), 1, 0, "C", FALSE);
                    $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "{$endereco->cidade->estado->pais->descricao}, {$endereco->cidade->descricao}, {$endereco->cidade->estado->sigla}"), 1, 0, "L", FALSE);
                    $this->SetTextColor(0);
                    $this->Ln();
                }

                $this->SetDrawColor(220);
                $this->SetFillColor(196, 210, 205);

                $this->SetX(20);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(170, 2, "", 1, 0, "L", TRUE);
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
