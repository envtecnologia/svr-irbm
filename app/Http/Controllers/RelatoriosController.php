<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePdfJob;
use App\Models\Cadastros\Origem;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cadastros\TipoFormReligiosa;
use App\Models\Cadastros\TipoInstituicao;
use App\Models\Cadastros\TipoPessoa;
use App\Models\Cidade;
use App\Models\Controle\Associacao;
use App\Models\Controle\Capitulo;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Controle\Setor;
use App\Models\Escolaridade;
use App\Models\Pais;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
use App\Models\Raca;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class RelatoriosController extends Controller
{

    public function actionButton(Request $request)
    {
        if ($request->action == "pdf") {
            switch ($request->modulo) {
                    // RELATORIOS REDE
                case 'associacoes':
                    $this->associacoesPdf($request);
                    return redirect()->route('associacoes.imprimir')->with('pdf', 1);
                    break;
                case 'cemiterios':
                    $this->cemiteriosPdf($request);
                    return redirect()->route('cemiterios.imprimir')->with('pdf', 1);
                    break;
                case 'comunidades':
                    $this->comunidadesPdf($request);
                    return redirect()->route('comunidades.imprimir')->with('pdf', 1);
                    break;
                case 'comunidades_aniv':
                    $this->comunidades_anivPdf($request);
                    return redirect()->route('comunidades_aniv.imprimir')->with('pdf', 1);
                    break;
                case 'dioceses':
                    $this->diocesesPdf($request);
                    return redirect()->route('dioceses.imprimir')->with('pdf', 1);
                    break;
                case 'paroquias':

                    return $this->paroquiasPdf($request);
                    break;
                case 'provincias':

                    return $this->provinciasPdf($request);
                    break;

                    // RELATORIOS PESSOAS
                case 'admissoes':
                    $this->admissoesPdf($request);
                    return redirect()->route('admissoes.imprimir')->with('pdf', 1);
                    break;
                case 'egressos':
                    $this->egressosPdf($request);
                    return redirect()->route('egresso.imprimir')->with('pdf', 1);
                    break;
                case 'falecimentos':
                    $this->falecimentoPdf($request);
                    return redirect()->route('falecimento.imprimir')->with('pdf', 1);
                    break;
                case 'origens':
                    $this->origensPdf($request);
                    return redirect()->route('origens.imprimir')->with('pdf', 1);
                    break;
                case 'transferencia':
                    $this->transferenciaPdf($request);
                    return redirect()->route('transferencia.imprimir')->with('pdf', 1);
                    break;
                case 'civil':
                    $this->civilPdf($request);
                    return redirect()->route('civil.imprimir')->with('pdf', 1);
                    break;
                case 'mediaIdade':
                    $this->mediaIdadePdf($request);
                    return redirect()->route('mediaIdade.imprimir')->with('pdf', 1);
                    break;
                case 'atual':
                    $this->atualPdf($request);
                    return redirect()->route('atual.imprimir')->with('pdf', 1);
                    break;
                case 'atividade':
                    $this->atividadePdf($request);
                    // return redirect()->route('atividade.imprimir')->with('pdf', 1);
                    break;
                case 'aniversariante':
                    $this->aniversariantePdf($request);
                    return redirect()->route('aniversariante.imprimir')->with('pdf', 1);
                    break;
                case 'pessoa':
                    $this->pessoaPdf($request);
                    return redirect()->route('pessoa.imprimir')->with('pdf', 1);
                    break;
                case 'capitulos':
                    $this->capitulosPdf($request);
                    // return redirect()->route('capitulos.imprimir')->with('pdf', 1);
                    break;

                default:
                    return redirect()->back()->with('error', 'Módulo para geração deste tipo de PDF não encontrado.');
                    break;
            }
        } else {
            // Redirect
            switch ($request->modulo) {
                    // CADASTRO REDE
                case 'associacoes':
                    return redirect()->route('associacoes.new');
                    break;
                case 'cemiterios':
                    return redirect()->route('cemiterios.new');
                    break;
                case 'comunidades':
                    return redirect()->route('comunidades.new');
                    break;
                case 'comunidades_aniv':
                    return redirect()->route('comunidades_aniv.new');
                    break;
                case 'dioceses':
                    return redirect()->route('dioceses.new');
                    break;
                case 'paroquias':
                    return redirect()->route('paroquias.new');
                    break;
                case 'provincias':
                    return redirect()->route('provincias.new');
                    break;
                case 'obras':
                    return redirect()->route('obras.new');
                    break;

                    // CADASTRO PESSOAS
                case 'egressos':
                    return redirect()->route('egressos.new');
                    break;
                case 'falecimentos':
                    return redirect()->route('falecimentos.new');
                    break;
                case 'transferencia':
                    return redirect()->route('transferencia.new');
                    break;
                case 'capitulos':
                    return redirect()->route('capitulos.new');
                    break;

                default:
                    return redirect()->back()->with('error', 'Rota para inserção não encontrada.');
                    break;
            }
        }
    }
    // PROVINCIAS
    public function provincias(Request $request)
    {

        $query = Provincia::withoutTrashed();

        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.provincias.provincias', [
            'dados' => $dados
        ]);
    }
    public function provinciasPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->provinciasPdf($request);

        // $dados = Provincia::all();

        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.provincias.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    // PAROQUIAS
    public function paroquias(Request $request)
    {

        $query = Paroquia::withoutTrashed();

        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);
        }

        return view('authenticated.controle.paroquias.paroquias', [
            'dados' => $dados
        ]);
    }
    public function paroquiasPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->paroquiasPdf($request);

        // $dados = Paroquia::all();

        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);

        //     $diocese = Diocese::find($dado->cod_diocese_id);
        //     $dado->setAttribute('diocese', $diocese);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.paroquias.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }
    // OBRAS
    public function obras()
    {

        $dados = Provincia::paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.obras.obras', [
            'dados' => $dados
        ]);
    }
    public function obrasPdf()
    {

        $dados = Paroquia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        $dados = $dados->toArray();

        $view = 'authenticated.relatorios.rede.obras.pdf';
        $filename = uniqid() . '_' . time();
        $outputPath = 'public/pdfs/' . $filename . '.pdf';

        $data = json_encode($dados);
        $tempPath = 'temp/' . uniqid() . '.json';
        Storage::put($tempPath, $data);


        $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        $jobId = Queue::push($job);

        return response()->json(['jobId' => $jobId]);
    }

    // FUNCOES
    public function funcoes()
    {

        $dados = Provincia::paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.funcoes.funcoes', [
            'dados' => $dados
        ]);
    }
    public function funcoesPdf()
    {

        $dados = Paroquia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        $dados = $dados->toArray();

        $view = 'authenticated.relatorios.rede.funcoes.pdf';
        $filename = uniqid() . '_' . time();
        $outputPath = 'public/pdfs/' . $filename . '.pdf';

        $data = json_encode($dados);
        $tempPath = 'temp/' . uniqid() . '.json';
        Storage::put($tempPath, $data);


        $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        $jobId = Queue::push($job);

        return response()->json(['jobId' => $jobId]);
    }

    // DIOCESES
    public function dioceses(Request $request)
    {

        $query = Diocese::withoutTrashed();

        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.dioceses.dioceses', [
            'dados' => $dados
        ]);
    }
    public function diocesesPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->diocesesPdf($request);

        // $dados = Diocese::all();

        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.dioceses.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    // COMUNIDADES_ANIV
    public function comunidades_aniv(Request $request)
    {

        $query = Comunidade::select('*', DB::raw('MONTH(fundacao) as mes_aniversario'), DB::raw('DAY(fundacao) as dia_aniversario'))
            ->where('situacao', 1)
            ->orderBy(DB::raw('MONTH(fundacao)'))
            ->orderBy(DB::raw('DAY(fundacao)'));

        $provincias = Provincia::whereHas('comunidades')->distinct()->orderBy('descricao')->get();

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            // Usar createFromFormat para especificar o formato da data
            $dataInicio = Carbon::createFromFormat('d/m', $request->input('data_inicio'));
            $diaInicio = $dataInicio->format('d');
            $mesInicio = $dataInicio->format('m');

            $query->where(DB::raw('MONTH(fundacao)'), '>=', $mesInicio)
                ->where(DB::raw('DAY(fundacao)'), '>=', $diaInicio);
        }

        if ($request->filled('data_fim')) {
            // Usar createFromFormat para especificar o formato da data
            $dataFim = Carbon::createFromFormat('d/m', $request->input('data_fim'));
            $diaFim = $dataFim->format('d');
            $mesFim = $dataFim->format('m');

            $query->where(DB::raw('MONTH(fundacao)'), '<=', $mesFim)
                ->where(DB::raw('DAY(fundacao)'), '<=', $diaFim);
        }

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', $provincia);

            $paroquia = Paroquia::find($dado->cod_paroquia_id);
            $dado->setAttribute('paroquia', $paroquia);
        }

        return view('authenticated.relatorios.rede.comunidades_aniv.comunidades_aniv', compact(
            'dados',
            'provincias'
        ));
    }
    public function comunidades_anivPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->comunidades_anivPdf($request);

        // $dados = Comunidade::join('provincias', 'comunidades.cod_provincia_id', '=', 'provincias.id')
        //     ->where('comunidades.situacao', 1)
        //     ->select('comunidades.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(comunidades.fundacao) as mes_aniversario'), DB::raw('DAY(comunidades.fundacao) as dia_aniversario'))
        //     ->orderBy('mes_aniversario')
        //     ->orderBy('dia_aniversario')
        //     ->get();

        // $records = $dados->count();

        // $dados = $dados->groupBy([
        //     'provincia_nome',
        //     function ($item) {
        //         return $this->getMesNome($item->mes_aniversario);
        //     }
        // ]);

        // foreach ($dados as $provincia => $meses) {
        //     $dados[$provincia] = $meses->sortBy(function ($comunidades, $mes) {
        //         return $this->getMesNumero($mes);
        //     });
        // }
        // // $dados = $dados->toArray();

        // // CHUNK DE GRUPOS
        // foreach ($dados as $provincia => $meses) {
        //     foreach ($meses as $mes => $comunidades) {


        //         foreach ($comunidades as $dado) {

        //             $cidade = Cidade::find($dado->cod_cidade_id);
        //             $dado->setAttribute('cidade', ($cidade->descricao ?? '-'));
        //         }

        //         $chunks = array_chunk($comunidades->toArray(), 100);
        //         foreach ($chunks as $chunk) {
        //             $chunkedData[$provincia][$mes][] = $chunk;
        //         }
        //     }
        // }


        // $view = 'authenticated.relatorios.rede.comunidades_aniv.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    // COMUNIDADES
    public function comunidades(Request $request)
    {

        $query = Comunidade::orderBy('descricao')->withoutTrashed();
        $provincias = Provincia::whereHas('comunidades')->distinct()->orderBy('descricao')->get();
        $cidades = Cidade::whereHas('comunidades')->distinct()->orderBy('descricao')->get();


        // Filtro por codigo
        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        } else {
            // Filtro por provincia
            if ($request->filled('cod_provincia_id')) {
                $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
            }
            // Filtro por cidade
            if ($request->filled('cod_cidade_id')) {
                $query->where('cod_cidade_id', $request->input('cod_cidade_id'));
            }
            // Filtro por descricao (parcial)
            if ($request->filled('descricao')) {
                $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
            }

            // Filtro por situação
            if ($request->filled('situacao')) {
                $query->where('situacao', $request->input('situacao'));
            }
        }

        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {
            // dd($dado);
            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', $provincia);

            $paroquia = Paroquia::find($dado->cod_paroquia_id);
            $dado->setAttribute('paroquia', $paroquia);
        }


        return view('authenticated.controle.comunidades.comunidades', compact(
            'dados',
            'provincias',
            'cidades'
        ));
    }
    public function comunidadesPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->comunidadesPdf($request);

        // $dados = Comunidade::all();

        // // dd($dados);
        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);

        //     $provincia = Provincia::find($dado->cod_provincia_id);
        //     $dado->setAttribute('provincia', $provincia);

        //     $paroquia = Paroquia::find($dado->cod_paroquia_id);
        //     $dado->setAttribute('paroquia', $paroquia);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.comunidades.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    // COMUNIDADES
    public function cemiterios(Request $request)
    {

        $query = Cemiterio::withoutTrashed();
        $cidades = Cidade::whereHas('cemiterios')->distinct()->orderBy('descricao')->get();

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('cod_cidade_id')) {
            $query->where('cod_cidade_id', $request->input('cod_cidade_id'));
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }



        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.cemiterios.cemiterios', [
            'dados' => $dados,
            'cidades' => $cidades
        ]);
    }
    public function cemiteriosPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->cemiteriosPdf($request);

        // $dados = Cemiterio::all();

        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.cemiterios.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    // ASSOCIACOES
    public function associacoes(Request $request)
    {

        $query = Associacao::withoutTrashed();

        // Filtro por descricao (parcial)
        if ($request->has('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }

        // Filtro por situação
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {
            $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            // $banco = Banco::find($dado->cod_banco_id);
            // $dado->setAttribute('bnco', $banco);
        }

        return view('authenticated.controle.associacoes.associacoes', [
            'dados' => $dados
        ]);
    }
    public function associacoesPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->associacoesPdf($request);

        // $dados = Associacao::all();

        // foreach ($dados as $dado) {

        //     $cidade = Cidade::find($dado->cod_cidade_id);
        //     $dado->setAttribute('cidade', $cidade);

        //     $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        //     $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);
        // }

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.rede.associacoes.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }


    // Pessoal Relatorios


    public function egresso(Request $request)
    {

        $query = Egresso::with('pessoa')
            ->withoutTrashed()
            ->where('situacao', 1)
            ->whereHas('pessoa')
            ->orderBy('data_saida', 'desc');

        // Filtro por Descrição (nome da pessoa)
        if ($request->filled('descricao')) {
            $query->whereHas('pessoa', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->input('descricao') . '%');
            });
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('data_saida', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('data_saida', '<=', $request->input('data_fim'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        return view('authenticated.pessoal.egressos.egressos', [
            'dados' => $dados
        ]);
    }
    public function egressosPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->egressosPdf($request);

        // $dados = Pessoa::with(['egresso', 'provincia'])
        //     ->join('egressos', 'pessoas.id', '=', 'egressos.cod_pessoa')
        //     ->where('egressos.situacao', 1)
        //     ->orderBy('egressos.data_saida', 'desc')
        //     ->withoutTrashed()
        //     ->get();

        // $records = $dados->count();

        // $dados = $dados->groupBy(function ($item) {
        //     return $item->provincia->descricao;
        // });

        // // CHUNK DE GRUPOS
        // foreach ($dados as $provincia => $pessoas) {

        //     $chunks = array_chunk($pessoas->toArray(), 100);
        //     foreach ($chunks as $chunk) {
        //         $chunkedData[$provincia][] = $chunk;
        //     }
        // }

        // // Log::info($dados);
        // $view = 'authenticated.relatorios.pessoal.egresso.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }
    public function transferencia(Request $request)
    {
        $provincias_origem = Provincia::whereHas('provincias_origem')->distinct()->orderBy('descricao')->get();
        $provincias_destino = Provincia::whereHas('provincias_destino')->distinct()->orderBy('descricao')->get();

        $query = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'prov_origem', 'prov_des', 'pessoa.provincia'])
            ->withoutTrashed()
            ->orderBy('data_transferencia', 'desc');


        if ($request->filled('cod_provinciaori')) {
            $query->where('cod_provinciaori', $request->input('cod_provinciaori'));
        }
        if ($request->filled('cod_provinciades')) {
            $query->where('cod_provinciades', $request->input('cod_provinciades'));
        }
        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('data_transferencia', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('data_transferencia', '<=', $request->input('data_fim'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        return view('authenticated.pessoal.transferencia.transferencia', compact(
            'dados',
            'provincias_origem',
            'provincias_destino'
        ));
    }
    public function transferenciaPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->transferenciaPdf($request);
    }

    public function origens(Request $request)
    {

        $query = Pessoa::with(['origem'])
            ->withoutTrashed()
            ->orderBy('sobrenome')->orderBy('nome');


        if ($request->filled('cod_provinciaori')) {
            $query->where('cod_provinciaori', $request->input('cod_provinciaori'));
        }
        if ($request->filled('cod_provinciades')) {
            $query->where('cod_provinciades', $request->input('cod_provinciades'));
        }
        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('data_transferencia', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('data_transferencia', '<=', $request->input('data_fim'));
        }

        $dados = $query->paginate(10);

        return view('authenticated.pessoal.origens.origens', compact(
            'dados'
        ));
    }

    public function origensPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->origensPdf($request);
    }

    public function falecimentos(Request $request)
    {

        $cemiterios = Cemiterio::whereHas('falecimentos')->distinct()->orderBy('descricao')->get();
        $query = Falecimento::with('pessoa')
            ->orderBy('datafalecimento', 'desc')
            ->withoutTrashed();

        // Filtro por Descrição (nome da pessoa)
        if ($request->filled('descricao')) {
            $query->whereHas('pessoa', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->input('descricao') . '%');
            });
        }
        if ($request->filled('cod_cemiterio_id')) {
            $query->where('cod_cemiterio', $request->input('cod_cemiterio_id'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        return view('authenticated.pessoal.falecimentos.falecimentos', compact(
            'dados',
            'cemiterios'
        ));
    }
    public function falecimentoPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->falecimentosPdf($request);

        // $dados = Pessoa::with(['falecimento.doenca', 'falecimento.cemiterio', 'provincia'])
        //     ->join('falecimentos', 'pessoas.id', '=', 'falecimentos.cod_pessoa')
        //     ->where('falecimentos.situacao', 1)
        //     ->orderBy('falecimentos.datafalecimento', 'desc')
        //     ->withoutTrashed()
        //     ->get();

        // $records = $dados->count();

        // $dados = $dados->groupBy(function ($item) {
        //     return $item->provincia->descricao;
        // });

        // // CHUNK DE GRUPOS
        // foreach ($dados as $provincia => $pessoas) {

        //     $chunks = array_chunk($pessoas->toArray(), 100);
        //     foreach ($chunks as $chunk) {
        //         $chunkedData[$provincia][] = $chunk;
        //     }
        // }

        // // Log::info($dados);
        // $view = 'authenticated.relatorios.pessoal.falecimento.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }


    public function admissoes(Request $request)
    {

        $query = Pessoa::withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('datacadastro', 'desc');


        // Filtro por descricao
        if ($request->filled('descricao')) {
            $query->where('nome', 'like', '%' . $request->input('descricao') . '%');
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('datacadastro', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('datacadastro', '<=', $request->input('data_fim'));
        }

        $dados = $query->paginate(10)->appends($request->all());


        foreach ($dados as $dado) {

            // $cidade = Cidade::find($dado->cod_cidade_id);
            // $dado->setAttribute('cidade', $cidade);

            // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);


        }

        return view('authenticated.pessoal.admissoes.admissoes', [
            'dados' => $dados
        ]);
    }
    public function admissoesPdf(Request $request)
    {

        $pdf = new FpdfController();
        return $pdf->admissoesPdf($request);

        // $dados = Pessoa::with('provincia')
        //     ->withoutTrashed()
        //     ->where('situacao', 1)
        //     ->orderBy('datacadastro', 'desc')
        //     ->get();

        // // join('provincias', 'pessoas.cod_provincia_id', '=', 'provincias.id')
        // //                 ->where('pessoas.situacao', 1)
        // //                 ->select('pessoas.*', 'provincias.descricao as provincia_nome')
        // //                 ->orderBy('provincia_nome');

        // $records = $dados->count();



        // $dados = $dados->groupBy(function ($item) {
        //     return $item->provincia->descricao;
        // });

        // // CHUNK DE GRUPOS
        // foreach ($dados as $provincia => $pessoas) {

        //     $chunks = array_chunk($pessoas->toArray(), 100);
        //     foreach ($chunks as $chunk) {
        //         $chunkedData[$provincia][] = $chunk;
        //     }
        // }

        // // Log::info($dados);
        // $view = 'authenticated.relatorios.pessoal.admissoes.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }


    public function aniversariante(Request $request)
    {


        $provincias = Provincia::withoutTrashed()->get();
        $categorias = TipoPessoa::withoutTrashed()->get();

        $query = Pessoa::select('*', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
            ->where('situacao', 1)
            ->orderBy(DB::raw('MONTH(datanascimento)'))
            ->orderBy(DB::raw('DAY(datanascimento)'));

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }

        // FIltro por Categoria
        if ($request->filled('cod_tipopessoa_id')) {
            $query->where('cod_tipopessoa_id', $request->input('cod_tipopessoa_id'));
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            // Usar createFromFormat para especificar o formato da data
            $dataInicio = Carbon::createFromFormat('d/m', $request->input('data_inicio'));
            $diaInicio = $dataInicio->format('d');
            $mesInicio = $dataInicio->format('m');

            $query->where(DB::raw('MONTH(datanascimento)'), '>=', $mesInicio)
                ->where(DB::raw('DAY(datanascimento)'), '>=', $diaInicio);
        }

        if ($request->filled('data_fim')) {
            // Usar createFromFormat para especificar o formato da data
            $dataFim = Carbon::createFromFormat('d/m', $request->input('data_fim'));
            $diaFim = $dataFim->format('d');
            $mesFim = $dataFim->format('m');

            $query->where(DB::raw('MONTH(datanascimento)'), '<=', $mesFim)
                ->where(DB::raw('DAY(datanascimento)'), '<=', $diaFim);
        }

        // Filtro por nome (parcial)
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        $dados = $query->paginate(10)->appends($request->all());


        foreach ($dados as $dado) {

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', $comunidade);
        }

        return view('authenticated.pessoal.aniversariante.aniversariante', compact(
            'dados',
            'provincias',
            'categorias'
        ));
    }

    public function getMesNome($mes)
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];
        return $meses[$mes] ?? 'Desconhecido';
    }

    public function getMesNumero($mesNome)
    {
        $meses = [
            'Janeiro' => 1,
            'Fevereiro' => 2,
            'Março' => 3,
            'Abril' => 4,
            'Maio' => 5,
            'Junho' => 6,
            'Julho' => 7,
            'Agosto' => 8,
            'Setembro' => 9,
            'Outubro' => 10,
            'Novembro' => 11,
            'Dezembro' => 12,
        ];
        return $meses[$mesNome] ?? 0;
    }

    public function aniversariantePdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->aniversariantesPdf($request);

        // $dados = Pessoa::join('provincias', 'pessoas.cod_provincia_id', '=', 'provincias.id')
        //     ->where('pessoas.situacao', 1)
        //     ->select('pessoas.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
        //     ->orderBy('mes_aniversario')
        //     ->orderBy('dia_aniversario')
        //     ->get();

        // $records = $dados->count();

        // $dados = $dados->groupBy([
        //     'provincia_nome',
        //     function ($item) {
        //         return $this->getMesNome($item->mes_aniversario);
        //     }
        // ]);

        // Log::info('RECORDS');
        // Log::info($records);
        // // Ordena os meses em ordem cronológica dentro de cada província
        // foreach ($dados as $provincia => $meses) {
        //     $dados[$provincia] = $meses->sortBy(function ($pessoas, $mes) {
        //         return $this->getMesNumero($mes);
        //     });
        // }
        // // $dados = $dados->toArray();

        // // CHUNK DE GRUPOS
        // foreach ($dados as $provincia => $meses) {
        //     foreach ($meses as $mes => $pessoas) {


        //         foreach ($pessoas as $dado) {

        //             $comunidade = Comunidade::find($dado->cod_comunidade_id);
        //             $dado->setAttribute('comunidade', ($comunidade->descricao ?? '-'));
        //         }

        //         $chunks = array_chunk($pessoas->toArray(), 100);
        //         foreach ($chunks as $chunk) {
        //             $chunkedData[$provincia][$mes][] = $chunk;
        //         }
        //     }
        // }

        // // Log::info($dados);
        // // foreach ($dados as $grupo) {
        // //     foreach ($grupo as $dado) {

        // //         $comunidade = Comunidade::find($dado->cod_comunidade_id);
        // //         $dado->setAttribute('comunidade', $comunidade);

        // //         // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        // //         // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

        // //     }
        // // }



        // $view = 'authenticated.relatorios.pessoal.aniversariante.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    public function atividade(Request $request)
    {

        $tipo_atividades = TipoAtividade::withoutTrashed()->whereHas('comunidades')->distinct()->orderBy('descricao')->get();

        $query = Atividade::leftJoin('tipo_atividades', 'atividades.cod_tipoatividade_id', '=', 'tipo_atividades.id')
            ->leftJoin('pessoas', 'atividades.cod_pessoa_id', '=', 'pessoas.id')
            ->leftJoin('cidades', 'atividades.cod_cidade_id', '=', 'cidades.id')  // Join com cidades usando cod_cidade_id de atividades
            ->leftJoin('obras', 'atividades.cod_obra_id', '=', 'obras.id')  // Join com obras para pegar a cidade da obra se necessário
            ->leftJoin('cidades as cidade_obras', 'obras.cod_cidade_id', '=', 'cidade_obras.id')  // Join para pegar a cidade da obra
            ->selectRaw('atividades.*, COALESCE(cidades.descricao, cidade_obras.descricao) as cidade_nome')  // Usar a cidade da atividade, ou da obra se necessário
            ->orderBy('tipo_atividades.descricao')
            ->orderBy('pessoas.nome');

        if ($request->filled('cod_tipoatividade_id')) {
            $query->where('cod_tipoatividade_id', $request->input('cod_tipoatividade_id'));
        }
        if ($request->filled('situacao')) {
            $query->where('atividades.situacao', $request->input('situacao'));
        }



        $dados = $query->paginate(10)->appends($request->all());

        // dd($dados);

        return view('authenticated.pessoal.atividades.atividades', compact(
            'dados',
            'tipo_atividades'
        ));
    }
    public function atividadePdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->atividadesPdf($request);

        // $dados = Pessoa::all();

        // foreach ($dados as $dado) {

        //     // $cidade = Cidade::find($dado->cod_cidade_id);
        //     // $dado->setAttribute('cidade', $cidade);

        //     // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        //     // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

        // }

        // $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        // $pdf->setOption('isHtml5ParserEnabled', true);
        // $pdf->setOption('isPhpEnabled', true);
        // return $pdf->stream();
    }

    public function titulos()
    {

        $dados = Capitulo::withoutTrashed()->where('situacao', 1)->orderBy('comunidade')->paginate(10);

        foreach ($dados as $dado) {

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', ($provincia->descricao) ?? '-');
        }

        return view('authenticated.pessoal.atual.atual', [
            'dados' => $dados
        ]);
    }

    public function titulosPdf()
    {

        $dados = Capitulo::with('provincia')
            ->with('comunidade')
            ->withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('datacadastro', 'desc')
            ->get();

        $records = $dados->count();



        $dados = $dados->groupBy(function ($item) {
            return $item->provincia->descricao;
        });

        // CHUNK DE GRUPOS
        foreach ($dados as $provincia => $pessoas) {

            $chunks = array_chunk($pessoas->toArray(), 100);
            foreach ($chunks as $chunk) {
                $chunkedData[$provincia][] = $chunk;
            }
        }

        // Log::info($dados);
        $view = 'authenticated.relatorios.pessoal.atual.pdf';
        $filename = uniqid() . '_' . time();
        $outputPath = 'public/pdfs/' . $filename . '.pdf';

        $data = json_encode($dados);
        $tempPath = 'temp/' . uniqid() . '.json';
        Storage::put($tempPath, $data);



        $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        $jobId = Queue::push($job);

        return response()->json(['jobId' => $jobId]);
    }

    public function atual(Request $request)
    {

        $query = Pessoa::withoutTrashed()
            ->where('situacao', 1)
            ->whereHas('itinerarios', function ($query) use ($request) {

                // // Filtro por comunidade
                // if ($request->filled('cod_comunidade_id')) {
                //     $query->where('cod_comunidade_atual_id', $request->input('cod_comunidade_id'));
                // }

                if ($request->filled('cod_provincia_id')) {
                    $query->whereHas('com_atual', function ($subQuery) use ($request) {
                        $subQuery->where('cod_provincia_id', $request->input('cod_provincia_id'));
                    });
                }

                $query->orderByDesc('id');  // Ordena os itinerários por ID (ou por outra coluna, se preferir)
            })
            ->with(['itinerarios' => function ($query) {
                $query->orderByDesc('id')->take(1);  // Pega apenas o itinerário mais recente
            }, 'itinerarios.com_atual']);


        $provincias = Provincia::withoutTrashed()->orderBy('descricao')->get();
        // $comunidades = Comunidade::withoutTrashed()->where('situacao', 1)->orderBy('descricao')->get();

        // Filtro por nome (parcial)
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', ($provincia->descricao) ?? '-');

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', ($comunidade->descricao) ?? '-');
        }

        return view('authenticated.pessoal.atual.atual', compact(
            'dados',
            'provincias'
        ));
    }

    public function atualPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->comunidadeAtualPdf($request);
    }

    public function civil(Request $request)
    {

        $provincias = Provincia::withoutTrashed()->orderBy('descricao')->get();
        $comunidades = Comunidade::withoutTrashed()->orderBy('descricao')->get();
        $categorias = TipoPessoa::withoutTrashed()->orderBy('descricao')->get();

        $query = Pessoa::with(['comunidade', 'provincia'])->withoutTrashed();

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }
        // FIltro por Comunidade
        if ($request->filled('cod_comunidade_id')) {
            $query->where('cod_comunidade_id', $request->input('cod_comunidade_id'));
        }

        // FIltro por Categoria
        if ($request->filled('cod_tipopessoa_id')) {
            $query->where('cod_tipopessoa_id', $request->input('cod_tipopessoa_id'));
        }

        // Filtro por situação (egresso ou falecimento)
        if ($request->filled('situacao')) {
            if ($request->input('situacao') == 1) {
                $query->where('situacao', $request->input('situacao'))
                    ->whereDoesntHave('egresso')
                    ->whereDoesntHave('falecimento');
            } elseif ($request->input('situacao') == 2) {
                $query->whereHas('egresso');
            } elseif ($request->input('situacao') == 3) {
                $query->whereHas('falecimento');
            }
        }

        // Filtro por nome (parcial)
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->input('nome') . '%');
        }

        $dados = $query->paginate(10)->appends($request->all());


        return view('authenticated.pessoal.civil.civil', compact(
            'dados',
            'provincias',
            'comunidades',
            'categorias'
        ));
    }
    public function civilPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->relatorioCivilPdf($request);

        // $dados = Pessoa::all();

        // foreach ($dados as $dado) {

        //     // $cidade = Cidade::find($dado->cod_cidade_id);
        //     // $dado->setAttribute('cidade', $cidade);

        //     // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        //     // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

        // }

        // $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        // $pdf->setOption('isHtml5ParserEnabled', true);
        // $pdf->setOption('isPhpEnabled', true);
        // return $pdf->stream();
    }

    public function pessoa(Request $request)
    {
        // Carregar os dados de filtros
        $provincias = Provincia::withoutTrashed()->orderBy('descricao')->get();
        $comunidades = Comunidade::withoutTrashed()->orderBy('descricao')->get();
        $categorias = TipoPessoa::withoutTrashed()->orderBy('descricao')->get();
        $escolaridades = Escolaridade::withoutTrashed()->orderBy('descricao')->get();
        $origens = Origem::withoutTrashed()->orderBy('descricao')->get();
        $racas = Raca::withoutTrashed()->orderBy('descricao')->get();
        $tipos_formacao = TipoFormReligiosa::withoutTrashed()->orderBy('descricao')->get();

        // Construção da consulta com filtros
        $query = Pessoa::with(['falecimento', 'egresso'])
            ->withoutTrashed()
            ->orderBy('sobrenome', 'asc')
            ->orderBy('nome', 'asc');

        // Adicionar filtros dinamicamente
        $filters = [
            'cod_provincia_id' => 'cod_provincia_id',
            'cod_tipopessoa_id' => 'cod_tipopessoa_id',
            'cod_comunidade_id' => 'cod_comunidade_id',
            'nome' => 'nome',
            'cod_origem_id' => 'cod_origem_id',
            'cod_raca_id' => 'cod_raca_id',
        ];

        foreach ($filters as $input => $column) {
            if ($request->filled($input)) {
                if ($input === 'nome') {
                    $query->where($column, 'like', '%' . $request->input($input) . '%');
                } else {
                    $query->where($column, $request->input($input));
                }
            }
        }

        // Filtro por situação
        if ($request->filled('situacao')) {
            $situacao = $request->input('situacao');
            if ($situacao == 1) {
                $query->where('situacao', $situacao)
                      ->whereDoesntHave('egresso')
                      ->whereDoesntHave('falecimento');
            } elseif ($situacao == 2) {
                $query->whereHas('egresso');
            } elseif ($situacao == 3) {
                $query->whereHas('falecimento');
            }
        }

        // Paginação com preservação dos filtros
        $dados = $query->paginate(10)->appends($request->all());

        // Ajustando a situação de cada pessoa
        foreach ($dados as $pessoa) {
            if ($pessoa->falecimento) {
                $pessoa->situacao = 3;
            } elseif ($pessoa->egresso) {
                $pessoa->situacao = 2;
            } else {
                $pessoa->situacao = 1;
            }
        }

        // Retornar a view com os dados e filtros
        return view('authenticated.pessoal.pessoa.pessoa', compact(
            'dados',
            'provincias',
            'comunidades',
            'origens',
            'racas',
            'categorias',
            'escolaridades',
            'tipos_formacao'
        ));
    }

    public function pessoaPdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->pessoasPdf($request);

        // $dados = Pessoa::all();

        // foreach ($dados as $dado) {

        //     // $cidade = Cidade::find($dado->cod_cidade_id);
        //     // $dado->setAttribute('cidade', $cidade);

        //     // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        //     // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

        // }

        // $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        // $pdf->setOption('isHtml5ParserEnabled', true);
        // $pdf->setOption('isPhpEnabled', true);
        // return $pdf->stream();
    }
    public function mediaIdade(Request $request)
    {

        $provincias = Provincia::withoutTrashed()->get();
        $categorias = TipoPessoa::withoutTrashed()->get();

        $query = Pessoa::withoutTrashed()
            ->whereNotNull('datanascimento')
            ->where('situacao', 1);

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }

        // FIltro por Categoria
        if ($request->filled('cod_tipopessoa_id')) {
            $query->where('cod_tipopessoa_id', $request->input('cod_tipopessoa_id'));
        }

        $dados = $query->get();

        $total = count($dados);

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

        if ($total > 0) {
            // dd($total);
            foreach ($dados as $pessoa) {
                $idade = Carbon::parse($pessoa->datanascimento)->age;

                if ($idade <= 20) {
                    $quantidade20++;
                }
                if ($idade > 20 and $idade <= 30) {
                    $quantidade30++;
                }
                if ($idade > 30 and $idade <= 40) {
                    $quantidade40++;
                }
                if ($idade > 40 and $idade <= 50) {
                    $quantidade50++;
                }
                if ($idade > 50 and $idade <= 60) {
                    $quantidade60++;
                }
                if ($idade > 60 and $idade <= 70) {
                    $quantidade70++;
                }
                if ($idade > 70 and $idade <= 80) {
                    $quantidade80++;
                }
                if ($idade > 80 and $idade <= 90) {
                    $quantidade90++;
                }
                if ($idade > 90) {
                    $quantidadeMaior90++;
                }

                $somaIdade += $idade;
            }

            $mediaIdades = number_format($somaIdade / $total, 2, ",", ".");
        }




        return view('authenticated.pessoal.mediaIdade.mediaIdade', [
            'dados' => $dados,
            'provincias' => $provincias,
            'categorias' => $categorias,
            'vinte' => $quantidade20 ?? 0,
            'trinta' => $quantidade30 ?? 0,
            'quarenta' => $quantidade40 ?? 0,
            'cinquenta' => $quantidade50 ?? 0,
            'sessenta' => $quantidade60 ?? 0,
            'setenta' => $quantidade70 ?? 0,
            'oitenta' => $quantidade80 ?? 0,
            'noventa' => $quantidade90 ?? 0,
            'vinte_porcentagem' => ($quantidade20 == 0 ? 0 : ($quantidade20 * 100) / $total),
            'trinta_porcentagem' => ($quantidade30 == 0 ? 0 : ($quantidade30 * 100) / $total),
            'quarenta_porcentagem' => ($quantidade40 == 0 ? 0 : ($quantidade40 * 100) / $total),
            'cinquenta_porcentagem' => ($quantidade50 == 0 ? 0 : ($quantidade50 * 100) / $total),
            'sessenta_porcentagem' => ($quantidade60 == 0 ? 0 : ($quantidade60 * 100) / $total),
            'setenta_porcentagem' => ($quantidade70 == 0 ? 0 : ($quantidade70 * 100) / $total),
            'oitenta_porcentagem' => ($quantidade80 == 0 ? 0 : ($quantidade80 * 100) / $total),
            'noventa_porcentagem' => ($quantidade90 == 0 ? 0 : ($quantidade90 * 100) / $total),
            'acima_noventa' => ($quantidadeMaior90 ?? 0),
            'mediaIdades' => $mediaIdades ?? 0,
            'acima_porcentagem' => ($quantidadeMaior90 == 0 ? 0 : ($quantidadeMaior90 * 100) / $total),
            'total' => $total ?? 0,
        ]);
    }

    public function mediaIdadePdf($request)
    {

        $pdf = new FpdfController();
        return $pdf->mediaIdadePdf($request);
    }


    public function capitulos(Request $request)
    {

        $query = Capitulo::withoutTrashed();
        $provincias = Provincia::all();

        // Filtro por numero
        if ($request->filled('numero')) {
            $query->where('numero', $request->input('numero'));
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('data', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('data', '<=', $request->input('data_fim'));
        }

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }

        $dados = $query->paginate(10)->appends($request->all());

        foreach ($dados as $dado) {

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', $provincia);
        }

        return view('authenticated.controle.capitulos.capitulos', compact(
            'dados',
            'provincias'
        ));
    }
    public function capitulosPdf(Request $request)
    {

        $pdf = new FpdfController();
        return $pdf->capitulosPdf($request);
    }
}
