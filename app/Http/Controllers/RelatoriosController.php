<?php

namespace App\Http\Controllers;

use App\Jobs\GeneratePdfJob;
use App\Models\Cadastros\TipoInstituicao;
use App\Models\Cidade;
use App\Models\Controle\Associacao;
use App\Models\Controle\Capitulo;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Controle\Setor;
use App\Models\Pais;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
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
                    $this->associacoesPdf();
                    return redirect()->route('associacoes.imprimir')->with('pdf', 1);
                    break;
                case 'cemiterios':
                    $this->cemiteriosPdf();
                    return redirect()->route('cemiterios.imprimir')->with('pdf', 1);
                    break;
                case 'comunidades':
                    $this->comunidadesPdf();
                    return redirect()->route('comunidades.imprimir')->with('pdf', 1);
                    break;
                case 'comunidades_aniv':
                    $this->comunidades_anivPdf();
                    return redirect()->route('comunidades_aniv.imprimir')->with('pdf', 1);
                    break;
                case 'dioceses':
                    $this->diocesesPdf();
                    return redirect()->route('dioceses.imprimir')->with('pdf', 1);
                    break;
                case 'paroquias':

                    return $this->paroquiasPdf();
                    break;
                case 'provincias':

                    return $this->provinciasPdf();
                    break;

                    // RELATORIOS PESSOAS
                case 'admissoes':
                    $this->admissoesPdf();
                    return redirect()->route('admissoes.imprimir')->with('pdf', 1);
                    break;
                case 'egressos':
                    $this->egressosPdf();
                    return redirect()->route('egresso.imprimir')->with('pdf', 1);
                    break;
                case 'falecimentos':
                    $this->falecimentoPdf();
                    return redirect()->route('falecimento.imprimir')->with('pdf', 1);
                    break;
                case 'transferencia':
                    $this->transferenciaPdf();
                    return redirect()->route('transferencia.imprimir')->with('pdf', 1);
                    break;
                case 'civil':
                    $this->civilPdf();
                    return redirect()->route('civil.imprimir')->with('pdf', 1);
                    break;
                case 'mediaIdade':
                    $this->mediaIdadePdf();
                    return redirect()->route('mediaIdade.imprimir')->with('pdf', 1);
                    break;
                case 'atual':
                    $this->atualPdf();
                    return redirect()->route('atual.imprimir')->with('pdf', 1);
                    break;
                case 'atividade':
                    $this->atividadePdf();
                    return redirect()->route('atividade.imprimir')->with('pdf', 1);
                    break;
                case 'aniversariante':
                    $this->aniversariantePdf();
                    return redirect()->route('aniversariante.imprimir')->with('pdf', 1);
                    break;
                case 'pessoa':
                    $this->pessoaPdf();
                    return redirect()->route('pessoa.imprimir')->with('pdf', 1);
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


                default:
                    return redirect()->back()->with('error', 'Rota para inserção não encontrada.');
                    break;
            }
        }
    }
    // PROVINCIAS
    public function provincias()
    {

        $dados = Provincia::paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.provincias.provincias', [
            'dados' => $dados
        ]);
    }
    public function provinciasPdf()
    {

        $pdf = new FpdfController();
        return $pdf->provinciasPdf();

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
    public function paroquias()
    {

        $dados = Paroquia::paginate(10);

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
    public function paroquiasPdf()
    {

        $pdf = new FpdfController();
        return $pdf->paroquiasPdf();

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
    public function dioceses()
    {

        $dados = Diocese::paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.dioceses.dioceses', [
            'dados' => $dados
        ]);
    }
    public function diocesesPdf()
    {

        $pdf = new FpdfController();
        return $pdf->diocesesPdf();

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
    public function comunidades_aniv()
    {

        $dados = Comunidade::select('*', DB::raw('MONTH(fundacao) as mes_aniversario'), DB::raw('DAY(fundacao) as dia_aniversario'))
            ->where('situacao', 1)
            ->orderBy(DB::raw('MONTH(fundacao)'))
            ->orderBy(DB::raw('DAY(fundacao)'))
            ->paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $provincia = Cidade::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', $provincia);

            $paroquia = Cidade::find($dado->cod_paroquia_id);
            $dado->setAttribute('paroquia', $paroquia);
        }

        return view('authenticated.relatorios.rede.comunidades_aniv.comunidades_aniv', [
            'dados' => $dados
        ]);
    }
    public function comunidades_anivPdf()
    {

        $pdf = new FpdfController();
        return $pdf->comunidades_anivPdf();

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
    public function comunidades()
    {

        $dados = Comunidade::paginate(10);

        foreach ($dados as $dado) {
            // dd($dado);
            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', $provincia);

            $paroquia = Paroquia::find($dado->cod_paroquia_id);
            $dado->setAttribute('paroquia', $paroquia);
        }


        return view('authenticated.controle.comunidades.comunidades', [
            'dados' => $dados
        ]);
    }
    public function comunidadesPdf()
    {

        $pdf = new FpdfController();
        return $pdf->comunidadesPdf();

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
    public function cemiterios()
    {

        $dados = Cemiterio::paginate(10);
        $cidades = Cidade::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }

        return view('authenticated.controle.cemiterios.cemiterios', [
            'dados' => $dados,
            'cidades' => $cidades
        ]);
    }
    public function cemiteriosPdf()
    {

        $pdf = new FpdfController();
        return $pdf->cemiteriosPdf();

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
    public function associacoes()
    {

        $dados = Associacao::paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);
        }

        return view('authenticated.controle.associacoes.associacoes', [
            'dados' => $dados
        ]);
    }
    public function associacoesPdf()
    {

        $pdf = new FpdfController();
        return $pdf->associacoesPdf();

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


    public function egresso()
    {

        $dados = Egresso::with('pessoa')
            ->withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('data_saida', 'desc')
            ->paginate(10);


        return view('authenticated.pessoal.egressos.egressos', [
            'dados' => $dados
        ]);
    }
    public function egressosPdf()
    {

        $pdf = new FpdfController();
        return $pdf->egressosPdf();

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
    public function transferencia()
    {

        $dados = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'prov_origem', 'prov_des', 'pessoa.provincia'])
            ->withoutTrashed()
            ->orderBy('data_transferencia', 'desc')
            ->paginate(10);
        // dd($dados[0]);

        return view('authenticated.pessoal.transferencia.transferencia', [
            'dados' => $dados
        ]);
    }
    public function transferenciaPdf()
    {

        $pdf = new FpdfController();
        return $pdf->transferenciaPdf();

        // $dados = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'pessoa.provincia'])
        //     ->orderBy('data_transferencia', 'desc')
        //     ->withoutTrashed()->get();

        // $dados = $dados->toArray();

        // $view = 'authenticated.relatorios.pessoal.transferencia.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    public function falecimentos()
    {

        $dados = Falecimento::with('pessoa')
            ->orderBy('datafalecimento', 'desc')
            ->withoutTrashed()
            ->paginate(10);

        return view('authenticated.pessoal.falecimentos.falecimentos', [
            'dados' => $dados
        ]);
    }
    public function falecimentoPdf()
    {

        $pdf = new FpdfController();
        return $pdf->falecimentosPdf();

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


    public function admissoes()
    {

        $dados = Pessoa::withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('datacadastro', 'desc')
            ->paginate(10);

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
    public function admissoesPdf()
    {

        $pdf = new FpdfController();
        return $pdf->admissoesPdf();

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


    public function aniversariante()
    {

        $dados = Pessoa::select('*', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
            ->where('situacao', 1)
            ->orderBy(DB::raw('MONTH(datanascimento)'))
            ->orderBy(DB::raw('DAY(datanascimento)'))
            ->paginate(10);

        foreach ($dados as $dado) {

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', $comunidade);
        }

        return view('authenticated.pessoal.aniversariante.aniversariante', [
            'dados' => $dados

        ]);
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

    public function aniversariantePdf()
    {

        $pdf = new FpdfController();
        return $pdf->aniversariantesPdf();

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

    public function atividade()
    {

        $dados = Atividade::leftJoin('tipo_atividades', 'atividades.cod_tipoatividade_id', '=', 'tipo_atividades.id')
            ->leftJoin('pessoas', 'atividades.cod_pessoa_id', '=', 'pessoas.id')
            ->leftJoin('cidades', 'atividades.cod_cidade_id', '=', 'cidades.id')  // Join com cidades usando cod_cidade_id de atividades
            ->leftJoin('obras', 'atividades.cod_obra_id', '=', 'obras.id')  // Join com obras para pegar a cidade da obra se necessário
            ->leftJoin('cidades as cidade_obras', 'obras.cod_cidade_id', '=', 'cidade_obras.id')  // Join para pegar a cidade da obra
            ->selectRaw('atividades.*, COALESCE(cidades.descricao, cidade_obras.descricao) as cidade_nome')  // Usar a cidade da atividade, ou da obra se necessário
            ->orderBy('tipo_atividades.descricao')
            ->orderBy('pessoas.nome')
            ->paginate(10);

        // dd($dados);

        return view('authenticated.pessoal.atividades.atividades', [
            'dados' => $dados
        ]);
    }
    public function atividadePdf()
    {

        $pdf = new FpdfController();
        return $pdf->atividadesPdf();

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

    public function atual()
    {

        $dados = Pessoa::withoutTrashed()->where('situacao', 1)->paginate(10);

        foreach ($dados as $dado) {

            $provincia = Provincia::find($dado->cod_provincia_id);
            $dado->setAttribute('provincia', ($provincia->descricao) ?? '-');

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', ($comunidade->descricao) ?? '-');
        }

        return view('authenticated.pessoal.atual.atual', [
            'dados' => $dados
        ]);
    }

    public function atualPdf()
    {

        $pdf = new FpdfController();
        return $pdf->comunidadeAtualPdf();

        // $dados = Pessoa::with('provincia')
        //     ->with('comunidade')
        //     ->withoutTrashed()
        //     ->where('situacao', 1)
        //     ->orderBy('datacadastro', 'desc')
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
        // $view = 'authenticated.relatorios.pessoal.atual.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);



        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, $records))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }

    public function civil()
    {

        $dados = Pessoa::paginate(10);

        foreach ($dados as $dado) {

            // $cidade = Cidade::find($dado->cod_cidade_id);
            // $dado->setAttribute('cidade', $cidade);

            // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);


        }

        return view('authenticated.pessoal.civil.civil', [
            'dados' => $dados
        ]);
    }
    public function civilPdf()
    {

        $pdf = new FpdfController();
        return $pdf->relatorioCivilPdf();

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

    public function pessoa()
    {

        $dados = Pessoa::with(['falecimento', 'egresso'])
            ->withoutTrashed()
            ->orderBy('datacadastro', 'desc')
            ->paginate(10);

        foreach ($dados as $pessoa) {
            if ($pessoa->falecimento) {
                $pessoa->situacao = 3;
            } elseif ($pessoa->egresso) {
                $pessoa->situacao = 2;
            } else {
                $pessoa->situacao = 1;
            }
        }

        // dd($dados);

        return view('authenticated.pessoal.pessoa.pessoa', [
            'dados' => $dados
        ]);
    }
    public function pessoaPdf()
    {

        $pdf = new FpdfController();
        return $pdf->pessoasPdf();

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
    public function mediaIdade()
    {

        $dados = Pessoa::withoutTrashed()
            ->whereNotNull('datanascimento')
            ->where('situacao', 1)
            ->get();
        $total = count($dados);
        // dd($total);
        $vinte = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 0 && $idade <= 21) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $vinte_porcentagem = ($vinte * 100) / $total;

        $trinta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 21 && $idade <= 30) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $trinta_porcentagem = ($trinta * 100) / $total;

        $quarenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 31 && $idade <= 40) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $quarenta_porcentagem = ($quarenta * 100) / $total;

        $cinquenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 41 && $idade <= 50) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $cinquenta_porcentagem = ($cinquenta * 100) / $total;

        $sessenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 51 && $idade <= 60) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $sessenta_porcentagem = ($sessenta * 100) / $total;

        $setenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 61 && $idade <= 70) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $setenta_porcentagem = ($setenta * 100) / $total;

        $oitenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 71 && $idade <= 80) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $oitenta_porcentagem = ($oitenta * 100) / $total;

        $noventa = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            if ($idade >= 81 && $idade <= 90) {
                $soma += $idade;
                $totalIdades++;
                return true;
            }
            return false;
        })->count();
        $noventa_porcentagem = ($noventa * 100) / $total;


        $acima_noventa = $dados->filter(function ($dados) {
            $idade = Carbon::parse($dados->datanascimento)->age;
            return $idade > 90;
        })->count();
        // dd($acima_noventa);
        $acima_porcentagem = ($acima_noventa * 100) / $total;

        $mediaIdades = $totalIdades > 0 ? $soma / $totalIdades : 0;




        return view('authenticated.pessoal.mediaIdade.mediaIdade', [
            'dados' => $dados,
            'vinte' => $vinte,
            'trinta' => $trinta,
            'quarenta' => $quarenta,
            'cinquenta' => $cinquenta,
            'sessenta' => $sessenta,
            'setenta' => $setenta,
            'oitenta' => $oitenta,
            'noventa' => $noventa,
            'vinte_porcentagem' => $vinte_porcentagem,
            'trinta_porcentagem' => $trinta_porcentagem,
            'quarenta_porcentagem' => $quarenta_porcentagem,
            'cinquenta_porcentagem' => $cinquenta_porcentagem,
            'sessenta_porcentagem' => $sessenta_porcentagem,
            'setenta_porcentagem' => $setenta_porcentagem,
            'oitenta_porcentagem' => $oitenta_porcentagem,
            'noventa_porcentagem' => $noventa_porcentagem,
            'acima_noventa'       => $acima_noventa,
            'mediaIdades'   => $mediaIdades,
            'acima_porcentagem'   => $acima_porcentagem,
            'total'               => $total
        ]);
    }

    public function mediaIdadePdf()
    {

        $pdf = new FpdfController();
        return $pdf->mediaIdadePdf();


        // $dados = Pessoa::withoutTrashed()
        //     ->whereNotNull('datanascimento')
        //     ->where('situacao', 1)
        //     ->get();
        // $total = count($dados);
        // // dd($total);
        // $vinte = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 0 && $idade <= 21) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $vinte_porcentagem = ($vinte * 100) / $total;

        // $trinta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 21 && $idade <= 30) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $trinta_porcentagem = ($trinta * 100) / $total;

        // $quarenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 31 && $idade <= 40) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $quarenta_porcentagem = ($quarenta * 100) / $total;

        // $cinquenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 41 && $idade <= 50) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $cinquenta_porcentagem = ($cinquenta * 100) / $total;

        // $sessenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 51 && $idade <= 60) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $sessenta_porcentagem = ($sessenta * 100) / $total;

        // $setenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 61 && $idade <= 70) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $setenta_porcentagem = ($setenta * 100) / $total;

        // $oitenta = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 71 && $idade <= 80) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $oitenta_porcentagem = ($oitenta * 100) / $total;

        // $noventa = $dados->filter(function ($dados) use (&$soma, &$totalIdades) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     if ($idade >= 81 && $idade <= 90) {
        //         $soma += $idade;
        //         $totalIdades++;
        //         return true;
        //     }
        //     return false;
        // })->count();
        // $noventa_porcentagem = ($noventa * 100) / $total;


        // $acima_noventa = $dados->filter(function ($dados) {
        //     $idade = Carbon::parse($dados->datanascimento)->age;
        //     return $idade > 90;
        // })->count();
        // // dd($acima_noventa);
        // $acima_porcentagem = ($acima_noventa * 100) / $total;

        // $mediaIdades = $totalIdades > 0 ? $soma / $totalIdades : 0;

        // $dados = [
        //     'vinte' => $vinte,
        //     'trinta' => $trinta,
        //     'quarenta' => $quarenta,
        //     'cinquenta' => $cinquenta,
        //     'sessenta' => $sessenta,
        //     'setenta' => $setenta,
        //     'oitenta' => $oitenta,
        //     'noventa' => $noventa,
        //     'vinte_porcentagem' => $vinte_porcentagem,
        //     'trinta_porcentagem' => $trinta_porcentagem,
        //     'quarenta_porcentagem' => $quarenta_porcentagem,
        //     'cinquenta_porcentagem' => $cinquenta_porcentagem,
        //     'sessenta_porcentagem' => $sessenta_porcentagem,
        //     'setenta_porcentagem' => $setenta_porcentagem,
        //     'oitenta_porcentagem' => $oitenta_porcentagem,
        //     'noventa_porcentagem' => $noventa_porcentagem,
        //     'acima_noventa' => $acima_noventa,
        //     'mediaIdades' => $mediaIdades,
        //     'acima_porcentagem' => $acima_porcentagem,
        //     'total' => $total,
        // ];


        // $view = 'authenticated.relatorios.pessoal.mediaIdade.pdf';
        // $filename = uniqid() . '_' . time();
        // $outputPath = 'public/pdfs/' . $filename . '.pdf';

        // $data = json_encode($dados);
        // $tempPath = 'temp/' . uniqid() . '.json';
        // Storage::put($tempPath, $data);


        // $job = (new GeneratePdfJob($tempPath, $view, $outputPath, $filename, false, 0, 'portrait'))->onQueue('pdfs');
        // $jobId = Queue::push($job);

        // return response()->json(['jobId' => $jobId]);
    }


    public function capitulos()
    {

        $dados = Pessoa::paginate(10);

        foreach ($dados as $dado) {

            // $cidade = Cidade::find($dado->cod_cidade_id);
            // $dado->setAttribute('cidade', $cidade);

            // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);


        }

        return view('authenticated.relatorios.pessoal.capitulos.capitulos', [
            'dados' => $dados
        ]);
    }
    public function capitulosPdf()
    {

        $dados = Pessoa::all();

        foreach ($dados as $dado) {

            // $cidade = Cidade::find($dado->cod_cidade_id);
            // $dado->setAttribute('cidade', $cidade);

            // $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
            // $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

        }

        $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
    }
}
