<?php

namespace App\Http\Controllers;

use App\Models\Controle\Associacao;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Itinerario;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
use App\Services\PDF\Gerenciamento\Comunidade as GerenciamentoComunidade;
use App\Services\PDF\Pessoas\Admissoes;
use App\Services\PDF\Pessoas\Aniversariantes;
use App\Services\PDF\Pessoas\Atividades;
use App\Services\PDF\Pessoas\Atual;
use App\Services\PDF\Pessoas\Comunidade as PessoasComunidade;
use App\Services\PDF\Pessoas\Egressos;
use App\Services\PDF\Pessoas\Falecimentos;
use App\Services\PDF\Pessoas\Ficha;
use App\Services\PDF\Pessoas\MediaIdade;
use App\Services\PDF\Pessoas\Pessoas;
use App\Services\PDF\Pessoas\RelatorioCivil;
use App\Services\PDF\Pessoas\Transferencias;
use App\Services\PDF\Rede\Associacoes;
use App\Services\PDF\Rede\Cemiterios;
use App\Services\PDF\Rede\Comunidades;
use App\Services\PDF\Rede\Dioceses;
use App\Services\PDF\Rede\Paroquias;
use App\Services\PDF\Rede\Provincias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FpdfController extends Controller
{
    public function relatorioPessoa(Request $request)
    {

        $formacaoReligiosa  = $request->chkFormacoes;
        $cursos             = $request->chkCursos;
        $itinerarios        = $request->chkItinerarios;
        $funcoes            = $request->chkFuncoes;
        $atividades         = $request->chkAtividades;
        $familiar           = $request->chkFamiliares;
        $historico          = $request->chkHistoricos;
        $licencas           = $request->chkLicencas;
        $habilidades        = $request->chkHabilidades;

        $pessoa_id = $request->pessoa_id;

        try {
            $pessoa = Pessoa::find($pessoa_id);

            $pdf = new Ficha();
            $pdf->generateReport($pessoa_id);

            if ($formacaoReligiosa)
                $pdf->formacaoReligiosaAntigo($pessoa_id);
            if ($cursos)
                $pdf->cursos($pessoa_id);
            if ($itinerarios)
                $pdf->itinerarios($pessoa_id);
            if ($funcoes)
                $pdf->funcoesAntigo($pessoa_id);
            if ($atividades)
                $pdf->atividadesAntigo($pessoa_id);
            if ($familiar)
                $pdf->familiaresAntigo($pessoa_id);
            if ($historico)
                $pdf->historicos($pessoa_id);
            if ($licencas)
                $pdf->licencas($pessoa_id);
            if ($habilidades)
                $pdf->habilidades($pessoa_id);


            $pdfContent = $pdf->Output('S'); // 'S' retorna o PDF como string

            // Retorna a resposta com o PDF e os cabeçalhos apropriados
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="Ficha - ' . $pessoa->nome . '.pdf"');
        } catch (Exception $e) {
            return response()->make($e->getMessage(), 500);
        }
    }

    public function provinciasPdf()
    {

        $provincias = Provincia::with('cidade')
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Provincias();
        $pdf->provinciasPdf($provincias);
        $pdfContent = $pdf->Output('S');

        // Retorna a resposta com o PDF e os cabeçalhos apropriados
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="provincias.pdf"');
    }

    public function paroquiasPdf()
    {

        $paroquias = Paroquia::with('cidade')
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Paroquias();
        $pdf->paroquiasPdf($paroquias);
        $pdfContent = $pdf->Output('S');

        // Retorna a resposta com o PDF e os cabeçalhos apropriados
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="provincias.pdf"');
    }

    public function diocesesPdf()
    {

        $paroquias = Diocese::with('cidade')
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Dioceses();
        return $pdf->diocesesPdf($paroquias);
    }

    public function comunidades_anivPdf()
    {

        $comunidades = Comunidade::join('provincias', 'comunidades.cod_provincia_id', '=', 'provincias.id')
            ->where('comunidades.situacao', 1)
            ->select('comunidades.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(comunidades.fundacao) as mes_aniversario'), DB::raw('DAY(comunidades.fundacao) as dia_aniversario'))
            ->orderBy('mes_aniversario')
            ->orderBy('dia_aniversario')
            ->orderBy('provincia_nome')
            ->get();
        // dd($comunidades[1]);
        // dd($provincias);
        $pdf = new Comunidades();
        return $pdf->comunidades_anivPdf($comunidades);
    }

    public function comunidadePdf($comunidade_id)
    {

        $comunidade = Comunidade::with(['provincia', 'cidade', 'paroquia.diocese', 'enderecos'])->where('id', $comunidade_id)->first();

        // dd($provincias);
        $pdf = new GerenciamentoComunidade();
        return $pdf->comunidadePdf($comunidade);
    }


    public function comunidadesPdf()
    {

        $comunidades = Comunidade::with(['provincia', 'diocese', 'comunidade.setor', 'cidade'])
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Comunidades();
        return $pdf->comunidadesPdf($comunidades);
    }

    public function cemiteriosPdf()
    {

        $comunidades = Cemiterio::with(['cidade'])
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Cemiterios();
        return $pdf->cemiteriosPdf($comunidades);
    }

    public function associacoesPdf()
    {

        $comunidades = Associacao::with(['cidade'])
            ->orderBy('descricao')
            ->get();

        // dd($provincias);
        $pdf = new Associacoes();
        return $pdf->associacoesPdf($comunidades);
    }





    // RELATORIO PESSOAS

    public function transferenciaPdf()
    {

        $tranferencias = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'pessoa.provincia'])
            ->orderBy('data_transferencia', 'desc')
            ->withoutTrashed()->get();

        $pdf = new Transferencias();
        return $pdf->transferenciaPdf($tranferencias);
    }

    public function relatorioCivilPdf()
    {

        $pessoas = Pessoa::with(['cidade', 'provincia', 'falecimento'])
            ->orderBy('cod_provincia_id')
            ->orderBy('nome')
            ->orderBy('sobrenome')
            ->get();

        // dd($provincias);
        $pdf = new RelatorioCivil();
        return $pdf->relatorioCivilPdf($pessoas);
    }

    public function pessoasPdf()
    {

        $pessoas = Pessoa::join('provincias', 'pessoas.cod_provincia_id', '=', 'provincias.id')
            ->where('pessoas.situacao', 1)
            ->select('pessoas.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
            ->orderBy('mes_aniversario')
            ->orderBy('dia_aniversario')
            ->get();

        // dd($provincias);
        $pdf = new Pessoas();
        return $pdf->pessoasPdf($pessoas);
    }

    public function mediaIdadePdf()
    {

        $pessoas = Pessoa::with(['provincia'])
            ->whereNotNull('datanascimento')
            ->where('situacao', 1)
            ->get();

        // dd($provincias);
        $pdf = new MediaIdade();
        return $pdf->mediaIdadePdf($pessoas);
    }

    public function falecimentosPdf()
    {

        $falecimentos = Falecimento::with(['doenca_1', 'cemiterio', 'pessoa.provincia'])
            ->where('situacao', 1)
            ->orderBy('datafalecimento', 'desc')
            ->withoutTrashed()
            ->get();


        // dd($provincias);
        $pdf = new Falecimentos();
        return $pdf->falecimentosPdf($falecimentos);
    }

    public function egressosPdf()
    {

        $egresso = Egresso::with(['pessoa', 'pessoa.provincia'])
            ->where('situacao', 1)
            ->orderBy('data_saida', 'desc')
            ->withoutTrashed()
            ->get();

        // dd($provincias);
        $pdf = new Egressos();
        return $pdf->egressosPdf($egresso);
    }

    public function comunidadeAtualPdf()
    {

        $pessoas = Itinerario::with(['com_atual.provincia', 'pessoa', 'cid_atual'])
            ->withoutTrashed()
            ->where('situacao', 1)
            ->get();

        // dd($provincias);
        $pdf = new Atual();
        return $pdf->atualPdf($pessoas);
    }

    // public function titulosPdf(){

    //     $comunidades = Associacao::with(['cidade'])
    //     ->orderBy('descricao')
    //         ->get();

    //     // dd($provincias);
    //     $pdf = new Associacoes();
    //     return $pdf->titulosPdf($comunidades);
    // }

    public function atividadesPdf()
    {

        $atividades = Atividade::with(['pessoa', 'obra.cidade.estado'])
            ->get();

        // dd($provincias);
        $pdf = new Atividades();
        return $pdf->atividadesPdf($atividades);
    }

    public function aniversariantesPdf()
    {

        $aniversariantes = Pessoa::join('provincias', 'pessoas.cod_provincia_id', '=', 'provincias.id')
            ->where('pessoas.situacao', 1)
            ->select('pessoas.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
            ->orderBy('mes_aniversario')
            ->orderBy('dia_aniversario')
            ->get();

        // dd($provincias);
        $pdf = new Aniversariantes();
        return $pdf->aniversariantesPdf($aniversariantes);
    }

    public function admissoesPdf()
    {

        $admissoes = Pessoa::with('provincia')
            ->withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('datacadastro', 'desc')
            ->get();

        // dd($provincias);
        $pdf = new Admissoes();
        return $pdf->admissoesPdf($admissoes);
    }
}
