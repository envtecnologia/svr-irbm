<?php

namespace App\Services\PDF\Pessoas;

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

class Ficha extends PdfService
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

    public function generateReport($codPessoa)
    {

        $pessoa = Pessoa::with(['egresso', 'falecimento', 'tipo_pessoa'])->findOrFail($codPessoa);

        $this->AliasNbPages("{total}");
        $this->AddPage();
        $this->Image(public_path('images/logo.png'), 20, 5, 20);
        $this->Ln(20);
        $this->SetY(25);
        $this->SetX(0);
        // Foto da Pessoa
        $foto = $pessoa->foto ? public_path("storage/uploads/pessoas/{$pessoa->foto}") : public_path("storage/uploads/pessoas/fotos/foto.jpeg");
        $this->Image($foto, 166, 5, 24, 24);
        $this->Ln(20);

        $this->SetFillColor(196, 210, 205);
        $this->SetTextColor(0);
        $this->SetDrawColor(240);
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

        // Dados Pessoais
        $this->SetDrawColor(220);
        $this->SetFillColor(255, 140, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Identificação"), 1, 0, "L", TRUE);
        $this->Ln();
        $this->Ln(2);

        $this->SetTextColor(0);
        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Dados Pessoais"), 1, 0, "L", TRUE);
        $this->Ln();
        $this->Ln(2);

        $this->SetFillColor(204);

        $situacao = $pessoa->situacaopessoa == 1 ? "Ativa(o)" : "Egressa(o)";

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

        $egresso = $pessoa->egresso()->orderBy('data_saida', 'desc')->first();
        if ($egresso) {
            $data = Carbon::make($egresso->data_saida)->format('d/m/Y');
            $situacao = "Egressa(o) em {$data}";
        }

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Nome"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "{$pessoa->sobrenome}, {$pessoa->nome}"), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Data Nascimento"), 1, 0, "L", TRUE);

        $dataNascimento = $pessoa->datanascimento ? Carbon::make($pessoa->datanascimento)->format('d/m/Y') : "---";
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataNascimento), 1, 0, "L", FALSE);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", $situacao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Categoria"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $pessoa->tipo_pessoa->descricao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Código ICM"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $pessoa->id), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(145, 6, iconv("utf-8", "iso-8859-1", $pessoa->provincia->descricao), 1, 0, "L", FALSE);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(145, 6, iconv("utf-8", "iso-8859-1", $pessoa->comunidade->descricao), 1, 0, "L", FALSE);
        $this->Ln();


        $pessoa->opcao != "" ? $opcao = $pessoa->opcao : $opcao = "---";
        $pessoa->religiosa != "" ? $nomeReligioso = $pessoa->religiosa : $nomeReligioso = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Opção"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", $opcao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Nome Religioso"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", $nomeReligioso), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Local Nascim."), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", "{$pessoa->local->descricao}, {$pessoa->local->estado->descricao} ({$pessoa->local->estado->pais->descricao})"), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Nacionalidade"), 1, 0, "L", TRUE);

        $this->SetFont("Arial", "", 8);
        $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", $pessoa->local->estado->pais->nacionalidade), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Raça"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", $pessoa->raca->descricao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Tipo Sangue"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $rh = ($pessoa["rh"] == 0 ? " - (negativo)" : " + (positivo)");
        $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", "{$pessoa["gruposanguineo"]}{$rh}"), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);

        $this->Ln(2);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Documentação"), 1, 0, "L", TRUE);
        $this->Ln();
        $this->Ln(2);

        $this->SetFillColor(204);

        $pessoa["escolaridade"] != "" ? $escolaridade = $pessoa["escolaridade"]->descricao : $escolaridade = "---";
        $pessoa["profissao"] != "" ? $profissao = $pessoa["profissao"]->descricao : $profissao = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Escolaridade"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", $escolaridade), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Profissão"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(65, 6, iconv("utf-8", "iso-8859-1", $profissao), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["rg"] != "" ? $rg = $pessoa["rg"] : $rg = "---";
        $pessoa["rgorgao"] != "" ? $rgOrgao = $pessoa["rgorgao"] : $rgOrgao = "---";
        $pessoa["rgdata"] != ""
            ? $rgData =
            substr($pessoa["rgdata"], 8, 2) . "/"
            . substr($pessoa["rgdata"], 5, 2) . "/"
            . substr($pessoa["rgdata"], 0, 4)
            : $rgData = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "RG"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $rg), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Órgão Expedidor"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $rgOrgao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Data Expedição"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $rgData), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["inscricaonumero"] != "" ? $inscricao = $pessoa["inscricaonumero"] : $inscricao = "---";
        $pessoa["inscricaoorgao"] != "" ? $inscricaoOrgao = $pessoa["inscricaoorgao"] : $inscricaoOrgao = "---";
        $pessoa["inscricaodata"] != ""
            ? $inscricaoData =
            substr($pessoa["inscricaodata"], 8, 2) . "/"
            . substr($pessoa["inscricaodata"], 5, 2) . "/"
            . substr($pessoa["inscricaodata"], 0, 4)
            : $inscricaoData = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Inscrição"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $inscricao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Órgão Inscrição"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $inscricaoOrgao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Data Inscrição"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $inscricaoData), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["cpf"] != "" ? $cpf = $pessoa["cpf"] : $cpf = "---";
        $pessoa["titulo"] != "" ? $titulo = $pessoa["titulo"] : $titulo = "---";
        $pessoa["titulozona"] != "" ? $zona = $pessoa["titulozona"] : $zona = "---";
        $pessoa["titulosecao"] != "" ? $secao = $pessoa["titulosecao"] : $secao = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "CPF"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $cpf), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Título Eleitor"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $titulo), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(22, 6, iconv("utf-8", "iso-8859-1", "Zona Eleitoral"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(15, 6, iconv("utf-8", "iso-8859-1", $zona), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Seção Eleitoral"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(13, 6, iconv("utf-8", "iso-8859-1", $secao), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["habilitacaonumero"] != "" ?
            $habilitacao = $pessoa["habilitacaonumero"] :
            $habilitacao = "---";
        $pessoa["habilitacaolocal"] != "" ?
            $orgaoHabilitacao = $pessoa["habilitacaolocal"] :
            $orgaoHabilitacao = "---";
        $pessoa["habilitacaodata"] != ""
            ? $dataHabilitacao =
            substr($pessoa["habilitacaodata"], 8, 2) . "/"
            . substr($pessoa["habilitacaodata"], 5, 2) . "/"
            . substr($pessoa["habilitacaodata"], 0, 4)
            : $dataHabilitacao = "---";
        $pessoa["habilitacaocategoria"] != "" ?
            $categoriaHabilitacao = $pessoa["habilitacaocategoria"] :
            $categoriaHabilitacao = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Habilitação"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "{$habilitacao} ({$categoriaHabilitacao})"), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Órgão (Hab.)"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $orgaoHabilitacao), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Data (Hab.)"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataHabilitacao), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["ctps"] != "" ? $ctps = $pessoa["ctps"] : $ctps = "---";
        $pessoa["ctpsserie"] != "" ? $ctpsSerie = $pessoa["ctpsserie"] : $ctpsSerie = "---";
        $pessoa["pis"] != "" ? $pis = $pessoa["pis"] : $pis = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "PIS/PASEP"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $pis), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "CTPS"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $ctps), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Série (CTPS)"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $ctpsSerie), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["secretaria"] != "" ? $secretaria = $pessoa["secretaria"] : $secretaria = "---";
        $pessoa["passaporte"] != "" ? $passaporte = $pessoa["passaporte"] : $passaporte = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Secretaria"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $secretaria), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Passaporte"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(50, 6, iconv("utf-8", "iso-8859-1", $passaporte), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", ""), "L", 0, "L", FALSE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", ""), 0, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $pessoa["aposentadoriadata"] != ""
            ? $aposentadoriaData =
            substr($pessoa["aposentadoriadata"], 8, 2) . "/"
            . substr($pessoa["aposentadoriadata"], 5, 2) . "/"
            . substr($pessoa["aposentadoriadata"], 0, 4)
            : $aposentadoriaData = "";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "INSS"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", $pessoa["inss"]), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", "Órgão Aposentadoria"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $pessoa["aposentadoriaorgao"]), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Data Aposentadoria"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1",  $aposentadoriaData), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();


        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);

        $this->Ln(2);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Contato"), 1, 0, "L", TRUE);
        $this->Ln();
        $this->Ln(2);

        $this->SetFillColor(204);

        $pessoa["endereco"] != "" ? $endereco = $pessoa["endereco"] : $endereco = "---";
        $pessoa["cep"] != "" ? $cep = $pessoa["cep"] : $cep = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Endereço"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $endereco), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "CEP"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $cep), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "E-mail"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);

        $pessoa["email"] != "" ? $email = $pessoa["email"] : $email = "---";

        $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $email), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->SetFont("Arial", "", 8);
        $this->Ln();

        $pessoa["telefone1"] != "" ? $telefone1 = $pessoa["telefone1"] : $telefone1 = "---";
        $pessoa["telefone2"] != "" ? $telefone2 = $pessoa["telefone2"] : $telefone2 = "---";
        $pessoa["telefone3"] != "" ? $telefone3 = $pessoa["telefone3"] : $telefone3 = "---";

        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone1"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $telefone1), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone2"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $telefone2), 1, 0, "L", FALSE);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Telefone3"), 1, 0, "L", TRUE);
        $this->SetFont("Arial", "", 8);
        $this->Cell(35, 6, iconv("utf-8", "iso-8859-1", $telefone3), 1, 0, "L", FALSE);
        $this->SetTextColor(0);
        $this->Ln();

        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);

        $this->Ln(2);
        $this->SetX(20);
        $this->SetFont("Arial", "B", 8);
        $this->Cell(170, 2, "", 1, 0, "L", TRUE);
        $this->Ln();
        $this->Ln(2);
    }

    public function formacaoReligiosa($codPessoa)
    {

        $dados = Formacao::with(['cidade.estado.pais'])->where('cod_pessoa_id', $codPessoa)->orderBy('data')->orderBy('cod_comunidade_id', 'desc')->get();

        $this->SetDrawColor(220);
        $this->SetFillColor(255, 140, 0);
        $this->SetTextColor(255, 255, 255);

        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Formação Religiosa'), 1, 0, 'L', true);
        $this->Ln();
        $this->Ln(2);

        $this->SetFillColor(204);
        $this->SetDrawColor(220);
        $this->SetTextColor(0);

        $filtro = '';

        foreach ($dados as $linha) {
            $dataInicio = Carbon::make($linha->data)->format('d/m/Y');
            $prazo = $linha->prazo ? Carbon::make($linha->prazo)->format('d/m/Y') : '---';
            $cidade = $linha['cidade'] ? $linha['cidade']->descricao : '---';
            $estado = $linha['cidade'] ? $linha['cidade']['estado']->descricao : '---';
            $pais = $linha['cidade'] ? $linha['cidade']['estado']['pais']->descricao : '---';
            $detalhes = $linha['detalhes'] ? $linha['detalhes'] : '---';

            if ($filtro !== $linha->comunidade->descricao) {
                $this->SetDrawColor(220);
                $this->SetFillColor(196, 210, 205);

                $this->SetX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', $linha->comunidade->descricao), 1, 0, 'L', true);
                $this->Ln();

                $this->SetFillColor(204);
                $filtro = $linha->comunidade->descricao;

                $this->SetX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Início'), 1, 0, 'C', true);
                $this->Cell(30, 6, iconv('utf-8', 'iso-8859-1', 'Tipo de Formação'), 1, 0, 'L', true);
                $this->Cell(60, 6, iconv('utf-8', 'iso-8859-1', 'Local'), 1, 0, 'L', true);
                $this->Cell(60, 6, iconv('utf-8', 'iso-8859-1', 'Detalhes'), 1, 0, 'L', true);
                $this->Ln();
            }

            $this->SetX(20);
            $this->SetFont('Arial', '', 8);
            $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $dataInicio), 1, 0, 'C', false);
            $this->Cell(30, 6, iconv('utf-8', 'iso-8859-1', $linha->tipo_formacao->descricao), 1, 0, 'L', false);
            $this->Cell(60, 6, iconv('utf-8', 'iso-8859-1', $pais), 1, 0, 'L', false);
            $this->Cell(60, 6, iconv('utf-8', 'iso-8859-1', $detalhes), 1, 0, 'L', false);
            $this->Ln();
        }


        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(170, 2, '', 1, 0, 'L', true);
        $this->Ln();
        $this->Ln(2);
    }

    public function formacaoReligiosaAntigo($codPessoa)
    {

        $dados = Formacao::where('cod_pessoa_id', $codPessoa)
            ->get();

        $this->SetDrawColor(220);
        $this->SetFillColor(255, 140, 0);
        $this->SetTextColor(255, 255, 255);

        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Formação Religiosa'), 1, 0, 'L', true);
        $this->Ln();
        $this->Ln(2);

        $this->SetFillColor(204);
        $this->SetDrawColor(220);
        $this->SetTextColor(0);

        $filtro = '';

        $this->SetX(20);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', 'Início'), 1, 0, 'C', true);
        $this->Cell(40, 6, iconv('utf-8', 'iso-8859-1', 'Comunidade'), 1, 0, 'L', true);
        $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Tipo de Formação'), 1, 0, 'L', true);
        $this->Cell(50, 6, iconv('utf-8', 'iso-8859-1', 'Local'), 1, 0, 'L', true);
        $this->Cell(45, 6, iconv('utf-8', 'iso-8859-1', 'Detalhes'), 1, 0, 'L', true);
        $this->Ln();

        foreach ($dados as $linha) {
            $dataInicio = Carbon::make($linha->data)->format('d/m/Y');
            $prazo = $linha->prazo ? Carbon::make($linha->prazo)->format('d/m/Y') : '---';

            $this->SetX(20);
            $this->SetFont('Arial', '', 6);
            $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', $dataInicio), 1, 0, 'C', false);
            $this->Cell(40, 6, iconv('utf-8', 'iso-8859-1', $linha->comunidade->descricao), 1, 0, 'L', false);
            $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $linha->tipo_formacao->descricao), 1, 0, 'L', false);
            $this->Cell(50, 6, iconv('utf-8', 'iso-8859-1', "{$linha->cidade->estado->pais->descricao}, {$linha->cidade->descricao}, {$linha->cidade->estado->descricao}"), 1, 0, 'L', false);
            $this->Cell(45, 6, iconv('utf-8', 'iso-8859-1', $linha->detalhes), 1, 0, 'L', false);
            $this->Ln();
        }


        $this->SetDrawColor(220);
        $this->SetFillColor(196, 210, 205);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(170, 2, '', 1, 0, 'L', true);
        $this->Ln();
        $this->Ln(2);
    }

    public function cursos($codPessoa)
    {

        $cursos = Curso::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datafinal', 'asc')
            ->orderBy('datainicio', 'asc')
            ->orderBy('cod_tipocurso_id')
            ->get();


        if ($cursos->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "INSTRUÇÃO - Cursos Acadêmicos e Outros"), 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "C", true);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Início"), 1, 0, "C", true);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Final"), 1, 0, "C", true);
            $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Curso"), 1, 0, "L", true);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($cursos as $curso) {
                $situacao = 'agendado';
                $dataFinal = '';

                if ($curso->datacancelamento) {
                    $situacao = "cancelado";
                    $dataFinal = \Carbon\Carbon::make($curso->datacancelamento)->format('d/m/Y');
                } else {
                    if ($curso->datainicio <= now()->format('Y-m-d')) {
                        $situacao = "andamento";
                    }
                    if ($curso->datafinal < now()->format('Y-m-d')) {
                        $situacao = "concluído";
                    }
                    if (!is_null($curso->datafinal)) {
                        $dataFinal = \Carbon\Carbon::make($curso->datafinal)->format('d/m/Y');
                    } else {
                        $dataFinal = '//';
                    }
                }

                $dataInicio = \Carbon\Carbon::make($curso->datainicio)->format('d/m/Y');

                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $situacao), 1, 0, "C", false);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataInicio), 1, 0, "C", false);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataFinal), 1, 0, "C", false);
                $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $curso->tipo_curso->descricao), 1, 0, "L", false);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 2, "", 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);
        }
    }

    public function itinerarios($codPessoa)
    {

        $itinerarios = Itinerario::where('cod_pessoa_id', $codPessoa)
            ->orderBy('chegada', 'asc')
            ->get();


        if ($itinerarios->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Itinerários"), 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 7);
            $this->Cell(15, 6, "Chegada", 1, 0, "L", true);
            $this->Cell(60, 6, "Comunidade", 1, 0, "L", true);
            $this->Cell(40, 6, "Local", 1, 0, "L", true);
            $this->Cell(30, 6, "UF", 1, 0, "L", true);
            $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Situação"), 1, 0, "C", true);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($itinerarios as $itinerario) {
                $situacao = $itinerario->chegada > now() ? "agendado" : "em curso";

                if (!empty($itinerario->saida) && $itinerario->saida <= now()) {
                    $situacao = "concluído";
                }

                $chegada = \Carbon\Carbon::make($itinerario->chegada)->format('d/m/Y');

                $this->SetX(20);
                $this->SetFont("Arial", "", 7);
                $this->Cell(15, 6, iconv("utf-8", "iso-8859-1", $chegada), 1, 0, "C", false);
                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", $itinerario->com_atual->descricao), 1, 0, "L", false);

                // Obtendo endereços
                $enderecos = Endereco::where('cod_comunidade_id', $itinerario->cod_comunidade_atual_id)
                    ->whereDate('datainicio', '<=', $itinerario->chegada)
                    ->whereDate('datafinal', '>=', $itinerario->chegada)
                    ->orderBy('datafinal', 'desc')
                    ->first();

                if ($enderecos) {
                    $this->Cell(40, 6, iconv("utf-8", "iso-8859-1", $enderecos->cidade->descricao), 1, 0, "L", false);
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $enderecos->cidade->estado->descricao), 1, 0, "L", false);
                } else {
                    $cidade = !empty($itinerario->cid_atual->descricao) ? $itinerario->cid_atual->descricao : "---";
                    $this->Cell(40, 6, iconv("utf-8", "iso-8859-1", $cidade), 1, 0, "L", false);

                    $estado = !empty($itinerario->cid_atual->estado->descricao) ? $itinerario->cid_atual->estado->descricao : "---";
                    $this->Cell(30, 6, iconv("utf-8", "iso-8859-1", $estado), 1, 0, "L", false);
                }

                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $situacao), 1, 0, "C", false);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 2, "", 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);
        }
    }

    public function funcoes($codPessoa)
    {

        $funcoes = Funcao::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datainicio', 'asc')
            ->orderBy('cod_provincia_id')
            ->orderBy('cod_comunidade_id')
            ->orderBy('cod_tipo_funcao_id')
            ->get();

        if ($funcoes->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "FUNÇÃO NO CONSELHO: da Comunidade e/ou da Província ou do Setor Geral"), 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $filtro = '';
            foreach ($funcoes as $funcao) {
                if ($filtro !== $funcao->comunidade->descricao) {

                    $this->SetFillColor(204);
                    $this->SetX(20);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", true);
                    $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", true);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    $this->SetX(20);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $funcao["provincia"]->descricao), 1, 0, "L", true);
                    $comunidade = ($funcao["comunidade"] !== "" ? $funcao["comunidade"]->descricao : "---");
                    $this->Cell(100, 6, iconv("utf-8", "iso-8859-1", $comunidade), 1, 0, "L", true);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $this->SetX(20);
                    $this->SetFont("Arial", "B", 8);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Início"), 1, 0, "C", true);
                    $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Final"), 1, 0, "C", true);
                    $this->Cell(130, 6, iconv("utf-8", "iso-8859-1", "Tipo de Função"), 1, 0, "L", true);
                    $this->SetTextColor(0);
                    $this->Ln();

                    $filtro = $funcao->comunidade->descricao;
                }
                $dataInicio = \Carbon\Carbon::make($funcao["datainicio"])->format('d/m/Y');


                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataInicio), 1, 0, "C", false);

                $dataFinal = $funcao["datafinal"] !== ""
                    ? \Carbon\Carbon::make($funcao["datafinal"])->format('d/m/Y')
                    : "em andamento";

                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataFinal), 1, 0, "C", false);
                $this->Cell(130, 6, iconv("utf-8", "iso-8859-1", $funcao["tipo_funcao"]->descricao), 1, 0, "L", false);
                $this->SetTextColor(0);
                $this->Ln();
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 2, "", 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);
        }
    }
    public function funcoesAntigo($codPessoa)
    {

        $funcoes = Funcao::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datainicio', 'asc')
            ->orderBy('cod_provincia_id')
            ->orderBy('cod_comunidade_id')
            ->orderBy('cod_tipo_funcao_id')
            ->get();

        if ($funcoes->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "FUNÇÃO NO CONSELHO: da Comunidade e/ou da Província ou do Setor Geral"), 1, 0, "L", true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetFillColor(204);
            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(40, 6, iconv("utf-8", "iso-8859-1", "Província"), 1, 0, "L", true);
            $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", "Comunidade"), 1, 0, "L", true);
            $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", "Tipo de Função"), 1, 0, "L", true);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Início"), 1, 0, "C", true);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Final"), 1, 0, "C", true);

            $this->SetTextColor(0);
            $this->Ln();

            foreach ($funcoes as $funcao) {
                $dataInicio = \Carbon\Carbon::make($funcao["datainicio"])->format('d/m/Y');
                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $this->Cell(40, 6, iconv("utf-8", "iso-8859-1", $funcao["provincia"]->descricao), 1, 0, "L", false);
                $comunidade = ($funcao["comunidade"]->descricao !== "" ? $funcao["comunidade"]->descricao : "---");
                $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", $comunidade), 1, 0, "L", false);
                $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", $funcao["tipo_funcao"]->descricao), 1, 0, "L", false);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataInicio), 1, 0, "C", false);

                $dataFinal = $funcao["datafinal"] !== ""
                    ? \Carbon\Carbon::make($funcao["datafinal"])->format('d/m/Y')
                    : "em andamento";

                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataFinal), 1, 0, "C", false);
                $this->SetTextColor(0);
                $this->Ln();
            }
        }
    }

    public function atividades($codPessoa)
    {

        // Consulta Eloquent para buscar as atividades
        $atividades = Atividade::with(['obra', 'cidade', 'tipo_atividade'])
            ->where('cod_pessoa_id', $codPessoa)
            ->orderBy('datainicio', 'asc')
            ->orderBy('cod_tipoatividade_id')
            ->orderBy('cod_obra_id')
            ->get();

        if ($atividades->isNotEmpty()) {
            // Similar lógica ao anterior, mas com mudança de estruturação
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Atividades"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $tipoAtividade = "";

            foreach ($atividades as $atividade) {
                $situacao = '';
                $dataHoje = Carbon::today()->format('Y-m-d');

                if ($atividade->datainicio > $dataHoje) {
                    $situacao = 'agendada';
                } elseif ($atividade->datainicio <= $dataHoje) {
                    if ($atividade->datafinal >= $dataHoje || $atividade->datafinal == '0000-00-00') {
                        $situacao = 'em atividade';
                    } else {
                        $situacao = 'concluída';
                    }
                }


                if (!is_null($atividade->datafinal)) {
                    $dataFinal = $situacao == 'concluída'
                        ? Carbon::make($atividade->datafinal)->format('d/m/Y')
                        : '---';
                } else {
                    $dataFinal = '//';
                }

                $dataInicio = Carbon::make($atividade->datainicio)->format('d/m/Y');

                if ($tipoAtividade != $atividade->tipo_atividade->descricao) {
                    $this->SetDrawColor(220);
                    $this->SetFillColor(196, 210, 205);

                    $this->SetX(20);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', $atividade->tipo_atividade->descricao), 1, 0, 'L', true);
                    $this->Ln();

                    $this->SetFillColor(204);
                    $tipoAtividade = $atividade->tipo_atividade->descricao;

                    $this->SetX(20);
                    $this->SetFont('Arial', 'B', 6);
                    $this->Cell(100, 6, iconv('utf-8', 'iso-8859-1', 'Obra | Comunidade | Local'), 1, 0, 'L', true);
                    $this->Cell(30, 6, iconv('utf-8', 'iso-8859-1', 'Situação'), 1, 0, 'C', true);
                    $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Data Início'), 1, 0, 'C', true);
                    $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Data Final'), 1, 0, 'C', true);
                    $this->Ln();
                }


                $obraLocal = $atividade->obra->descricao;

                if (!empty($atividade->cidade->descricao)) {
                    $obraLocal .= " - {$atividade->cidade->estado->pais->descricao}, {$atividade->cidade->estado->descricao}, {$atividade->cidade->descricao}";
                }

                $this->SetX(20);
                $this->SetFont('Arial', '', 6);
                $this->Cell(100, 6, iconv('utf-8', 'iso-8859-1', $obraLocal), 1, 0, 'L', false);
                $this->Cell(30, 6, iconv('utf-8', 'iso-8859-1', $situacao), 1, 0, 'C', false);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $dataInicio), 1, 0, 'C', false);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $dataFinal), 1, 0, 'C', false);
                $this->Ln();

                $this->SetDrawColor(220);
                $this->SetFillColor(204);

                $this->SetX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Detalhes'), 1, 0, 'L', true);
                $this->Ln();

                $this->SetX(20);
                $this->SetFont('Arial', '', 8);
                $this->MultiCell(170, 5, iconv('utf-8', 'iso-8859-1', $atividade->detalhes), 1, 'J');
            }
        }
    }

    public function atividadesAntigo($codPessoa)
    {

        $atividades = Atividade::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datainicio', 'asc')
            ->orderBy('cod_tipoatividade_id')
            ->orderBy('cod_obra_id')
            ->get();


        if ($atividades->isNotEmpty()) {
            // Configuração inicial do PDF
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Atividades'), 1, 0, 'L', true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetX(20);
            $this->SetFont('Arial', 'B', 6);
            $this->Cell(70, 6, iconv('utf-8', 'iso-8859-1', 'Obra | Comunidade | Local'), 1, 0, 'L', true);
            $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', 'Atividade'), 1, 0, 'L', true);
            $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', 'Data Início'), 1, 0, 'C', true);
            $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', 'Data Final'), 1, 0, 'C', true);
            $this->Cell(45, 6, iconv('utf-8', 'iso-8859-1', 'Detalhes'), 1, 0, 'L', true);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($atividades as $atividade) {
                $situacao = '';
                $dataHoje = Carbon::today()->format('Y-m-d');

                if ($atividade->datainicio > $dataHoje) {
                    $situacao = 'agendada';
                } elseif ($atividade->datainicio <= $dataHoje) {
                    if ($atividade->datafinal >= $dataHoje || $atividade->datafinal == '0000-00-00') {
                        $situacao = 'em atividade';
                    } else {
                        $situacao = 'concluída';
                    }
                }

                if (!is_null($atividade->datafinal)) {
                    $dataFinal = $situacao == 'concluída'
                        ? Carbon::make($atividade->datafinal)->format('d/m/Y')
                        : '---';
                } else {
                    $dataFinal = '//';
                }

                $dataInicio = Carbon::make($atividade->datainicio)->format('d/m/Y');

                $this->SetX(20);
                $this->SetFont('Arial', '', 6);

                $obraLocal = $atividade->obra->descricao;

                if (!empty($atividade->cidade->descricao)) {
                    $obraLocal .= "- {$atividade->cidade->estado->pais->descricao}, {$atividade->cidade->estado->descricao}, {$atividade->cidade->descricao}";
                }

                $this->Cell(70, 6, iconv('utf-8', 'iso-8859-1', $obraLocal), 1, 0, 'L', false);
                $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', $atividade->tipo_atividade->descricao), 1, 0, 'L', false);
                $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', $dataInicio), 1, 0, 'C', false);
                $this->Cell(15, 6, iconv('utf-8', 'iso-8859-1', $dataFinal), 1, 0, 'C', false);
                $this->Cell(45, 6, iconv('utf-8', 'iso-8859-1', $atividade->detalhes), 1, 0, 'L', false);
                $this->Ln();
            }
        }
    }

    public function familiares($codPessoa)
    {

        $familiares = Familiares::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datanascimento')
            ->orderBy('nome')
            ->orderBy('cod_parentesco_id')
            ->get();


        if ($familiares->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Familiares'), 1, 0, 'L', true);
            $this->Ln();
            $this->Ln(2);

            foreach ($familiares as $familiar) {
                $this->SetFillColor(204);
                $this->SetTextColor(0);

                $this->SetX(20);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(55, 6, iconv('utf-8', 'iso-8859-1', 'Nome'), 1, 0, 'L', true);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Parentesco'), 1, 0, 'L', true);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Sexo'), 1, 0, 'L', true);
                $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', 'Telefone(1)'), 1, 0, 'C', true);
                $this->Cell(50, 6, iconv('utf-8', 'iso-8859-1', 'E-mail'), 1, 0, 'L', true);
                $this->SetTextColor(0);
                $this->Ln();

                $ativo = $familiar->sexo == 0 ? 'Ativa' : 'Ativo';
                $inativo = $familiar->sexo == 0 ? 'Falecida' : 'Falecido';
                $situacao = $familiar->situacao == 1 ? $ativo : $inativo;
                $sexo = $familiar->sexo == 0 ? 'Feminino' : 'Masculino';
                $email = $familiar->email != '' ? $familiar->email : '---';

                $this->SetX(20);
                $this->SetFont('Arial', '', 8);
                $this->Cell(55, 6, iconv('utf-8', 'iso-8859-1', $familiar->nome), 1, 0, 'L', false);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $familiar->parentesco->descricao), 1, 0, 'L', false);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $sexo), 1, 0, 'L', false);
                $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', $familiar->telefone1), 1, 0, 'C', false);
                $this->Cell(50, 6, iconv('utf-8', 'iso-8859-1', $email), 1, 0, 'L', false);
                $this->Ln();

                $this->SetFillColor(204);
                $this->SetTextColor(0);

                $this->SetX(20);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", "Endereço"), 1, 0, "L", TRUE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "CEP"), 1, 0, "C", TRUE);
                $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", "Local"), 1, 0, "L", TRUE);
                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Nascimento"), 1, 0, "C", TRUE);
                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", "Falecimento"), 1, 0, "C", TRUE);
                $this->SetTextColor(0);
                $this->Ln();

                $endereco = $familiar->endereco != '' ? $familiar->endereco : '---';
                $cep = $familiar->cep != '' ? $familiar->cep : '---';
                $cidade = $familiar->cidade->descricao != '' ? $familiar->cidade->descricao : '---';
                $estado = $familiar->cidade->estado->sigla != '' ? $familiar->cidade->estado->sigla : '---';


                if (!is_null($familiar->datanascimento)) {
                    $dataNascimento = $familiar->datanascimento != ''
                        ? Carbon::parse($familiar->datanascimento)->format('d/m/Y')
                        : '---';
                } else {
                    $dataNascimento = '//';
                }

                if (!is_null($familiar->datafalecimento)) {
                    $dataFalecimento = $familiar->datafalecimento != ''
                        ? Carbon::parse($familiar->datafalecimento)->format('d/m/Y')
                        : $situacao;
                } else {
                    $dataFalecimento = '//';
                }
                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $this->Cell(55, 6, iconv("utf-8", "iso-8859-1", $endereco), 1, 0, "L", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $cep), 1, 0, "C", FALSE);
                $this->Cell(45, 6, iconv("utf-8", "iso-8859-1", "{$cidade}, {$estado} ({$familiar["cidade"]->estado->pais->descricao})"), 1, 0, "L", FALSE);
                $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $dataNascimento), 1, 0, "C", FALSE);

                if ($familiar["situacao"] == 1) {
                    $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $situacao), 1, 0, "C", FALSE);
                } else {
                    $this->Cell(25, 6, iconv("utf-8", "iso-8859-1", $dataFalecimento), 1, 0, "C", FALSE);
                }

                $this->Ln();

                $this->SetDrawColor(220);
                $this->SetFillColor(196, 210, 205);

                $this->SetX(20);
                $this->SetFont("Arial", "B", 8);
                $this->Cell(170, 2, "", 1, 0, "L", TRUE);
                $this->Ln();
                $this->Ln(2);
            }
        }
    }

    public function familiaresAntigo($codPessoa)
    {

        $familiares = Familiares::where('cod_pessoa_id', $codPessoa)
            ->orderBy('datanascimento')
            ->orderBy('nome')
            ->orderBy('cod_parentesco_id')
            ->get();

        if ($familiares->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(170, 6, iconv('utf-8', 'iso-8859-1', 'Familiares'), 1, 0, 'L', true);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetX(20);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(65, 6, iconv('utf-8', 'iso-8859-1', 'Nome'), 1, 0, 'L', true);
            $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', 'Parentesco'), 1, 0, 'L', true);
            $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', 'Telefone(1)'), 1, 0, 'C', true);
            $this->Cell(35, 6, iconv('utf-8', 'iso-8859-1', 'Data Nascimento'), 1, 0, 'C', true);
            $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', 'Falecimento'), 1, 0, 'C', true);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($familiares as $familiar) {
                $ativo = $familiar->sexo == 0 ? 'Ativa' : 'Ativo';
                $inativo = $familiar->sexo == 0 ? 'Falecida' : 'Falecido';
                $situacao = $familiar->situacao == 1 ? $ativo : $inativo;
                $sexo = $familiar->sexo == 0 ? 'Feminino' : 'Masculino';
                $email = $familiar->email != '' ? $familiar->email : '---';

                $this->SetX(20);
                $this->SetFont('Arial', '', 8);
                $this->Cell(65, 6, iconv('utf-8', 'iso-8859-1', $familiar->nome), 1, 0, 'L', false);
                $this->Cell(20, 6, iconv('utf-8', 'iso-8859-1', $familiar->parentesco), 1, 0, 'L', false);
                $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', $familiar->telefone1), 1, 0, 'C', false);

                if (!is_null($familiar->datanascimento)) {
                    $dataNascimento = $familiar->datanascimento != ''
                        ? Carbon::parse($familiar->datanascimento)->format('d/m/Y')
                        : '---';
                } else {
                    $dataNascimento = '//';
                }

                if (!is_null($familiar->datafalecimento)) {
                    $dataFalecimento = $familiar->datafalecimento != ''
                        ? Carbon::parse($familiar->datafalecimento)->format('d/m/Y')
                        : $situacao;
                } else {
                    $dataFalecimento = '//';
                }

                $this->Cell(35, 6, iconv('utf-8', 'iso-8859-1', $dataNascimento), 1, 0, 'C', false);

                if ($familiar->situacaofamiliar == 1) {
                    $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', $situacao), 1, 0, 'C', false);
                } else {
                    $this->Cell(25, 6, iconv('utf-8', 'iso-8859-1', $dataFalecimento), 1, 0, 'C', false);
                }

                $this->Ln();
            }
        }
    }

    public function historicos($codPessoa)
    {

        $historicos = Historico::where('cod_pessoa_id', $codPessoa)
            ->get();

        if ($historicos->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Histórico"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetTextColor(0);
            $this->SetDrawColor(220);
            $this->SetFillColor(204);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Descrição"), 1, 0, "L", TRUE);
            $this->Ln();

            foreach ($historicos as $historico) {
                $this->SetFillColor(204);
                $this->SetTextColor(0);

                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $descricao = str_replace("–", "-", $historico["detalhes"]);
                if (iconv("utf-8", "iso-8859-1", $descricao) == "") {
                    $this->MultiCell(170, 4, iconv("utf-8", "windows-1252", $descricao), 1, "J", FALSE);
                } else {
                    $this->MultiCell(170, 4, iconv("utf-8", "iso-8859-1", $descricao), 1, "J", FALSE);
                }
                $this->Ln(1);
            }

            $this->SetDrawColor(220);
            $this->SetFillColor(196, 210, 205);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(170, 2, "", 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);
        }
    }

    public function licencas($codPessoa)
    {

        $licencas = OcorrenciaMedica::where('cod_pessoa_id', $codPessoa)
        ->orderBy('datainicio')
        ->orderBy('datafinal')
        ->orderBy('cod_doenca_id')
        ->get();

        if ($licencas->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Saúde/Ocorrências Médicas"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            #$this->Cell(20, 6, iconv("utf-8","iso-8859-1", "Situação"), 1, 0, "C", TRUE);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Final"), 1, 0, "C", TRUE);
            $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", "Data Início"), 1, 0, "C", TRUE);
            $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", "Doença"), 1, 0, "L", TRUE);
            $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", "Tratamento"), 1, 0, "L", TRUE);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($licencas as $licenca) {
                $situacao = ($licenca["situacao"] == "0" ? "expirada" : "ativa");
                $dataFinal =
                    substr($licenca["datafinal"], 8, 2) . "/"
                    . substr($licenca["datafinal"], 5, 2) . "/"
                    . substr($licenca["datafinal"], 0, 4);
                $dataInicio =
                    substr($licenca["datainicio"], 8, 2) . "/"
                    . substr($licenca["datainicio"], 5, 2) . "/"
                    . substr($licenca["datainicio"], 0, 4);

                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                #$this->Cell(20, 6, iconv("utf-8","iso-8859-1", $situacao), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataFinal), 1, 0, "C", FALSE);
                $this->Cell(20, 6, iconv("utf-8", "iso-8859-1", $dataInicio), 1, 0, "C", FALSE);
                $this->Cell(70, 6, iconv("utf-8", "iso-8859-1", $licenca["doenca"]->descricao), 1, 0, "L", FALSE);

                $tratamento = ($licenca["ocorrencia"]->descricao != "" ?
                    "{$licenca["tratamento"]->descricao} ({$licenca["ocorrencia"]->descricao})" :
                    $licenca["tratamento"]->descricao);

                $this->Cell(60, 6, iconv("utf-8", "iso-8859-1", $tratamento), 1, 0, "L", FALSE);
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
    }

    public function habilidades($codPessoa){

        $habilidades = Habilidade::where('cod_pessoa_id', $codPessoa)
        ->orderBy('cod_tipo_habilidade_id')
        ->get();

        if ($habilidades->isNotEmpty()) {
            $this->SetDrawColor(220);
            $this->SetFillColor(255, 140, 0);
            $this->SetTextColor(255, 255, 255);

            $this->Ln();
            $this->SetX(20);
            $this->SetFont("Arial", "B", 10);
            $this->Cell(170, 6, iconv("utf-8", "iso-8859-1", "Habilidades"), 1, 0, "L", TRUE);
            $this->Ln();
            $this->Ln(2);

            $this->SetFillColor(204);
            $this->SetTextColor(0);

            $this->SetX(20);
            $this->SetFont("Arial", "B", 8);
            $this->Cell(160, 6, iconv("utf-8", "iso-8859-1", "Tipo de Habilidade"), 1, 0, "L", TRUE);
            $this->Cell(10, 6, iconv("utf-8", "iso-8859-1", "Grau"), 1, 0, "C", TRUE);
            $this->SetTextColor(0);
            $this->Ln();

            foreach ($habilidades as $habilidade) {
                $this->SetX(20);
                $this->SetFont("Arial", "", 8);
                $this->Cell(160, 6, iconv("utf-8", "iso-8859-1", $habilidade["tipo_habilidade"]->descricao), 1, 0, "L", FALSE);
                $grau = ($habilidade["grau"] != "-1" ? $habilidade["grau"] : "---");
                $this->Cell(10, 6, iconv("utf-8", "iso-8859-1", $grau), 1, 0, "C", FALSE);
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
    }
}
