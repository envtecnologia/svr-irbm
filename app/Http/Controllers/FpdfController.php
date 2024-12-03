<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Controle\Associacao;
use App\Models\Controle\Capitulo;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Formacao;
use App\Models\Pessoal\Itinerario;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
use App\Services\PDF\Gerenciamento\Comunidade as GerenciamentoComunidade;
use App\Services\PDF\Pessoas\Admissoes;
use App\Services\PDF\Pessoas\Aniversariantes;
use App\Services\PDF\Pessoas\Atividades;
use App\Services\PDF\Pessoas\Atual;
use App\Services\PDF\Pessoas\Capitulos;
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
use Carbon\Carbon;
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

    public function provinciasPdf($request)
    {

        $query = Provincia::with('cidade')
            ->orderBy('descricao');

        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->get();

        // dd($provincias);
        $pdf = new Provincias();
        $pdf->provinciasPdf($dados);
        $pdfContent = $pdf->Output('S');

        // Retorna a resposta com o PDF e os cabeçalhos apropriados
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="provincias.pdf"');
    }

    public function paroquiasPdf($request)
    {

        $query = Paroquia::with('cidade')
            ->orderBy('descricao');


        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->get();

        // dd($provincias);
        $pdf = new Paroquias();
        $pdf->paroquiasPdf($dados);
        $pdfContent = $pdf->Output('S');

        // Retorna a resposta com o PDF e os cabeçalhos apropriados
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="provincias.pdf"');
    }

    public function diocesesPdf($request)
    {

        $query = Diocese::with('cidade')
            ->orderBy('descricao');


        // Filtro por Descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }


        $dados = $query->get();

        // dd($provincias);
        $pdf = new Dioceses();
        return $pdf->diocesesPdf($dados);
    }

    public function comunidades_anivPdf($request)
    {

        $query = Comunidade::join('provincias', 'comunidades.cod_provincia_id', '=', 'provincias.id')
            ->where('comunidades.situacao', 1)
            ->select('comunidades.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(comunidades.fundacao) as mes_aniversario'), DB::raw('DAY(comunidades.fundacao) as dia_aniversario'))
            ->orderBy('mes_aniversario')
            ->orderBy('dia_aniversario')
            ->orderBy('provincia_nome');

        if ($request->filled('descricao')) {
            $query->where('comunidades.descricao', 'like', '%' . $request->input('descricao') . '%'); // Adicione o prefixo 'comunidades.'
        }
        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            // Usar createFromFormat para especificar o formato da data
            $dataInicio = Carbon::createFromFormat('d/m', $request->input('data_inicio'));
            $diaInicio = $dataInicio->format('d');
            $mesInicio = $dataInicio->format('m');

            $query->where(DB::raw('MONTH(comunidades.fundacao)'), '>=', $mesInicio)
                ->where(DB::raw('DAY(comunidades.fundacao)'), '>=', $diaInicio);
        }

        if ($request->filled('data_fim')) {
            // Usar createFromFormat para especificar o formato da data
            $dataFim = Carbon::createFromFormat('d/m', $request->input('data_fim'));
            $diaFim = $dataFim->format('d');
            $mesFim = $dataFim->format('m');

            $query->where(DB::raw('MONTH(comunidades.fundacao)'), '<=', $mesFim)
                ->where(DB::raw('DAY(comunidades.fundacao)'), '<=', $diaFim);
        }

        // FIltro por provincia
        if ($request->filled('cod_provincia_id')) {
            $query->where('cod_provincia_id', $request->input('cod_provincia_id'));
        }

        $dados = $query->get();
        // dd($comunidades[1]);
        // dd($provincias);
        $pdf = new Comunidades();
        return $pdf->comunidades_anivPdf($dados);
    }

    public function comunidadePdf($comunidade_id)
    {

        $comunidade = Comunidade::with(['provincia', 'cidade', 'paroquia.diocese', 'enderecos'])->where('id', $comunidade_id)->first();

        // dd($provincias);
        $pdf = new GerenciamentoComunidade();
        return $pdf->comunidadePdf($comunidade);
    }


    public function comunidadesPdf($request)
    {

        $query = Comunidade::with(['provincia', 'diocese', 'setor', 'cidade'])
            ->orderBy('descricao');

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

        $dados = $query->get();

        // dd($provincias);
        $pdf = new Comunidades();
        return $pdf->comunidadesPdf($dados);
    }

    public function cemiteriosPdf($request)
    {

        $query = Cemiterio::with(['cidade'])->orderBy('descricao')->withoutTrashed();

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }
        if ($request->filled('cod_cidade_id')) {
            $query->where('cod_cidade_id', $request->input('cod_cidade_id'));
        }
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }



        $dados = $query->get();
        // dd($provincias);
        $pdf = new Cemiterios();
        return $pdf->cemiteriosPdf($dados);
    }

    public function associacoesPdf($request)
    {

        $query = Associacao::with(['cidade'])->withoutTrashed();

        // Filtro por descricao (parcial)
        if ($request->has('descricao')) {
            $query->where('descricao', 'like', '%' . $request->input('descricao') . '%');
        }

        // Filtro por situação
        if ($request->filled('situacao')) {
            $query->where('situacao', $request->input('situacao'));
        }

        $dados = $query->get();

        // dd($provincias);
        $pdf = new Associacoes();
        return $pdf->associacoesPdf($dados);
    }





    // RELATORIO PESSOAS

    public function transferenciaPdf($request)
    {

        $query = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'pessoa.provincia'])
            ->orderBy('data_transferencia', 'desc')
            ->withoutTrashed();

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

        $dados = $query->get();

        $pdf = new Transferencias();
        return $pdf->transferenciaPdf($dados);
    }

    public function relatorioCivilPdf($request)
    {

        $query = Pessoa::with(['cidade', 'provincia', 'falecimento'])
            ->orderBy('cod_provincia_id')
            ->orderBy('nome')
            ->orderBy('sobrenome');


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
            $search = '%' . $request->input('nome') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', $search)
                    ->orWhere('opcao', 'like', $search)
                    ->orWhere('religiosa', 'like', $search);
            });
        }

        $dados = $query->get();

        // dd($provincias);
        $pdf = new RelatorioCivil();
        return $pdf->relatorioCivilPdf($dados);
    }

    public function pessoasPdf($request)
    {

        $request = $request->request->all();
        // dd($request);
        // dd($request);

        $query = Pessoa::with(['falecimento', 'comunidade', 'escolaridade', 'egresso', 'cidade', 'diocese', 'provincia', 'formacoes'])
        ->selectRaw('pessoas.*, TIMESTAMPDIFF(YEAR, datanascimento, CURDATE()) AS idade') // Adiciona o cálculo da idade
        ->withoutTrashed();


        if (!empty($request['cod_provincia_id'])) {
            $query->where('cod_provincia_id', $request['cod_provincia_id']);
        }

        // Filtro por Categoria
        if (!empty($request['cod_tipopessoa_id'])) {
            $query->where('cod_tipopessoa_id', $request['cod_tipopessoa_id']);
        }
        // Filtro por Comunidade
        if (!empty($request['cod_comunidade_id'])) {
            $query->where('cod_comunidade_id', $request['cod_comunidade_id']);
        }
        // Filtro por nome (parcial)
        if (!empty($request['nome'])) {
            $search = '%' . $request->input('nome') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', $search)
                    ->orWhere('opcao', 'like', $search)
                    ->orWhere('religiosa', 'like', $search);
            });
        }
        // Filtro por situação (egresso ou falecimento)
        if (!empty($request['situacao'])) {
            if ($request['situacao'] == 1) {
                $query->where('situacao', $request['situacao'])
                    ->where(function ($query) {
                        $query->whereDoesntHave('egresso')
                            ->orWhereHas('egresso', function ($q) {
                                $q->whereNotNull('data_readmissao');
                            });
                    })
                    ->whereDoesntHave('falecimento');
            } elseif ($request['situacao'] == 2) {
                $query->where(function ($query) {
                    $query->whereHas('egresso', function ($q) {
                            $q->whereNull('data_readmissao');
                        });
                });
            } elseif ($request['situacao'] == 3) {
                $query->whereHas('falecimento');
            } elseif ($request['situacao'] == 4) {
                $query->where('situacao', '<>', 1)
                    ->whereDoesntHave('egresso')
                    ->whereDoesntHave('falecimento');
            }
        }
        // Filtro por Origem
        if (!empty($request['cod_origem_id'])) {
            $query->where('cod_origem_id', $request['cod_origem_id']);
        }
        // Filtro por Raça
        if (!empty($request['cod_raca_id'])) {
            $query->where('cod_raca_id', $request['cod_raca_id']);
        }


        if(!empty($request['tipoRelatorio'])){
            if ($request['tipoRelatorio'] == 'faixa_etaria') {

                $de = $request['txtDe'];
                $ate = $request['txtAte'];

                $query->when(!empty($de) && !empty($ate), function ($query) use ($de, $ate) {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, datanascimento, CURDATE()) BETWEEN ? AND ?', [$de, $ate]);
                });

                $dados = $query->get();

                $dados = $dados->sortBy([
                    ['provincia.descricao', 'asc'],
                    ['sobrenome', 'asc'],
                    ['nome', 'asc']
                ]);

                $pdf = new Pessoas();
                return $pdf->faixasetarias($dados);

            } else if ($request['tipoRelatorio'] == 'formacao') {

                $tipoFormacao = $request['selTiposFormacoes'];
                $comunidadeFormacao = $request['selComunidadesFormacoes'];
                $tipoFormacao = $request['selTiposFormacoes'];
                $de = $request['txtDeFormacao'];
                $ate = $request['txtAteFormacao'];


                $query = Formacao::with(['pessoa', 'tipo_formacao', 'comunidade']) // Altere o foco para Formações
                ->when(!empty($request['selTiposFormacoes']), function ($query) use ($request) {
                    $query->where('cod_tipo_formacao_id', $request['selTiposFormacoes']);
                })
                ->when(!empty($request['selComunidadesFormacoes']), function ($query) use ($request) {
                    $query->where('cod_comunidade_id', $request['selComunidadesFormacoes']);
                })
                ->when(!empty($request['txtDeFormacao']), function ($query) use ($request) {
                    $query->where('data', '>=', $request['txtDeFormacao']);
                })
                ->when(!empty($request['txtAteFormacao']), function ($query) use ($request) {
                    $query->where('data', '<=', $request['txtAteFormacao']);
                });

                $dados = $query->get();

                $dados = $dados->sortBy([
                    ['tipo_formacao.descricao', 'asc'],
                    ['pessoa.sobrenome', 'asc'],
                    ['pessoa.nome', 'asc']
                ]);

                $pdf = new Pessoas();

                return $pdf->formacoes($dados);

            } else if ($request['tipoRelatorio'] == 'formacao_academica') {

                $query->when(!empty($request['selEscolaridades']), function ($query) use ($request) {
                    $query->where('cod_escolaridade_id', $request['selEscolaridades']);
                });

                $dados = $query->get();

                $dados = $dados->sortBy([
                    ['escolaridade.descricao', 'asc'],
                    ['sobrenome', 'asc'],
                    ['nome', 'asc']
                ]);

                $pdf = new Pessoas();
                return $pdf->formacoesAcademicas($dados);

            } else if ($request['tipoRelatorio'] == 'permanencia_comunidade') {

                $query->whereHas('itinerarios', function ($q) use ($request) {
                    $q->when(!empty($request['txtDeFormacao']), function ($qq) use ($request) {
                        $qq->where('chegada', '>=', $request['txtDeFormacao']);
                    })
                    ->when(!empty($request['txtAteFormacao']), function ($qq) use ($request) {
                        $qq->where('saida', '<=', $request['txtAteFormacao']);
                    });
                });


                $dados = $query->get();

                $dados = $dados->sortBy([
                    ['sobrenome', 'asc'],
                    ['nome', 'asc']
                ]);

                $pdf = new Pessoas();
                return $pdf->porPeriodoProvincia($dados);
            } else {


                $dados = $query->get();
                $pdf = new Pessoas();
                return $pdf->pessoasPdf($dados);
            }
        }else{

            $dados = $query->get();
            $pdf = new Pessoas();
            return $pdf->pessoasPdf($dados);
        }
    }

    public function mediaIdadePdf($request)
    {

        $query = Pessoa::with(['provincia'])
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

        // dd($provincias);
        $pdf = new MediaIdade();
        return $pdf->mediaIdadePdf($dados);
    }

    public function falecimentosPdf($request)
    {

        $query = Falecimento::with(['doenca_1', 'cemiterio', 'pessoa.provincia'])
            ->where('situacao', 1)
            ->orderBy('datafalecimento', 'desc')
            ->withoutTrashed();

        // Filtro por Descrição (nome da pessoa)
        if ($request->filled('descricao')) {
            $search = '%' . $request->input('descricao') . '%';
            $query->whereHas('pessoa', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('nome', 'like', $search)
                             ->orWhere('opcao', 'like', $search)
                             ->orWhere('religiosa', 'like', $search);
                });
            });
        }
        if ($request->filled('cod_cemiterio_id')) {
            $query->where('cod_cemiterio', $request->input('cod_cemiterio_id'));
        }

        $dados = $query->get();


        // dd($provincias);
        $pdf = new Falecimentos();
        return $pdf->falecimentosPdf($dados);
    }

    public function egressosPdf($request)
    {

        $query = Egresso::with(['pessoa', 'pessoa.provincia'])
            ->where('situacao', 1)
            ->whereHas('pessoa')
            ->orderBy('data_saida', 'desc')
            ->withoutTrashed();

        // Filtro por Descrição (nome da pessoa)
        if ($request->filled('descricao')) {
            $search = '%' . $request->input('descricao') . '%';
            $query->whereHas('pessoa', function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('nome', 'like', $search)
                             ->orWhere('opcao', 'like', $search)
                             ->orWhere('religiosa', 'like', $search);
                });
            });
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('data_saida', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('data_saida', '<=', $request->input('data_fim'));
        }

        $dados = $query->get();


        // dd($provincias);
        $pdf = new Egressos();
        return $pdf->egressosPdf($dados);
    }

    public function comunidadeAtualPdf($request)
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
            ->with([
                'itinerarios' => function ($query) {
                    $query->orderByDesc('id')->take(1);  // Pega apenas o itinerário mais recente
                },
                'itinerarios.com_atual'
            ]);

        // Filtro por nome (parcial)
        if ($request->filled('nome')) {
            $search = '%' . $request->input('nome') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', $search)
                    ->orWhere('opcao', 'like', $search)
                    ->orWhere('religiosa', 'like', $search);
            });
        }

        $dados = $query->get();

        // dd($provincias);
        $pdf = new Atual();
        return $pdf->atualPdf($dados);
    }

    // public function titulosPdf(){

    //     $comunidades = Associacao::with(['cidade'])
    //     ->orderBy('descricao')
    //         ->get();

    //     // dd($provincias);
    //     $pdf = new Associacoes();
    //     return $pdf->titulosPdf($comunidades);
    // }

    public function atividadesPdf($request)
    {

        // dd($request);
        $query = Atividade::join('pessoas', 'atividades.cod_pessoa_id', '=', 'pessoas.id')
            ->with(['pessoa', 'tipo_atividade', 'obra', 'obra.cidade.estado'])
            ->orderBy('pessoas.nome');


        if ($request->filled('cod_tipoatividade_id')) {
            $query->where('cod_tipoatividade_id', $request->input('cod_tipoatividade_id'));
        }
        if ($request->filled('situacao')) {
            $query->where('atividades.situacao', $request->input('situacao'));
        }


        $dados = $query->get();
        // dd($dados);
        $pdf = new Atividades();
        return $pdf->atividadesPdf($dados);
    }


    public function capitulosPdf($request)
    {

        // dd($request);
        $query = Capitulo::with(['equipes', 'equipes.pessoa', 'provincia']);

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

        $dados = $query->get();
        // dd($dados);
        $pdf = new Capitulos();
        return $pdf->capitulosPdf($dados);
    }

    public function aniversariantesPdf($request)
    {

        $query = Pessoa::join('provincias', 'pessoas.cod_provincia_id', '=', 'provincias.id')
            ->where('pessoas.situacao', 1)
            ->select('pessoas.*', 'provincias.descricao as provincia_nome', DB::raw('MONTH(datanascimento) as mes_aniversario'), DB::raw('DAY(datanascimento) as dia_aniversario'))
            ->orderBy('cod_provincia_id')
            ->orderBy('mes_aniversario')
            ->orderBy('dia_aniversario');


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
            $search = '%' . $request->input('nome') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', $search)
                    ->orWhere('opcao', 'like', $search)
                    ->orWhere('religiosa', 'like', $search);
            });
        }

        $dados = $query->get();

        // dd($provincias);
        $pdf = new Aniversariantes();
        return $pdf->aniversariantesPdf($dados);
    }

    public function admissoesPdf($request)
    {

        $query = Pessoa::with('provincia')
            ->withoutTrashed()
            ->where('situacao', 1)
            ->orderBy('datacadastro', 'desc');

        // Filtro por descricao
        if ($request->filled('descricao')) {
            $search = '%' . $request->input('descricao') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', $search)
                    ->orWhere('opcao', 'like', $search)
                    ->orWhere('religiosa', 'like', $search);
            });
        }

        // Filtro por intervalo de datas (data_inicio e data_fim)
        if ($request->filled('data_inicio')) {
            $query->where('datacadastro', '>=', $request->input('data_inicio'));
        }

        if ($request->filled('data_fim')) {
            $query->where('datacadastro', '<=', $request->input('data_fim'));
        }

        $dados = $query->get();

        // dd($provincias);
        $pdf = new Admissoes();
        return $pdf->admissoesPdf($dados);
    }
}
