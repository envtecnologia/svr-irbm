<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\TipoInstituicao;
use App\Models\Cidade;
use App\Models\Controle\Associacao;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Controle\Setor;
use App\Models\Pais;
use App\Models\Provincia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
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
    public function provinciasPdf() {

        $dados = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

        }

        $pdf = Pdf::loadView('authenticated.relatorios.rede.provincias.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
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
    public function paroquiasPdf() {

        $dados = Paroquia::all();

        foreach ($dados as $dado) {
            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);


        }

        $pdf = Pdf::loadView('authenticated.relatorios.rede.paroquias.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
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
    public function obrasPdf() {

        $dados = Paroquia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

        }

        $pdf = Pdf::loadView('authenticated.relatorios.rede.obras.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
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
public function funcoesPdf() {

    $dados = Paroquia::all();

    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

    }

    $pdf = Pdf::loadView('authenticated.relatorios.rede.funcoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);
    return $pdf->stream();
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
public function diocesesPdf() {

    $dados = Diocese::all();

    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

    }

    $pdf = Pdf::loadView('authenticated.relatorios.rede.dioceses.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);
    return $pdf->stream();
}

// COMUNIDADES_ANIV
public function comunidades_aniv()
{

    $dados = Comunidade::paginate(10);

    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

    }

    return view('authenticated.relatorios.rede.comunidades_aniv.comunidades_aniv', [
        'dados' => $dados
    ]);
}
public function comunidades_anivPdf() {

    $dados = Comunidade::all();

    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

        $provincia = Provincia::find($dado->cod_provincia_id);
        $dado->setAttribute('provincia', $provincia);

        $paroquia = Paroquia::find($dado->cod_paroquia_id);
        $dado->setAttribute('paroquia', $paroquia);

    }

    $pdf = Pdf::loadView('authenticated.relatorios.rede.comunidades_aniv.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);
    return $pdf->stream();
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
public function comunidadesPdf() {

    $dados = Comunidade::all();

    // dd($dados);
    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

        $provincia = Provincia::find($dado->cod_provincia_id);
        $dado->setAttribute('provincia', $provincia);

        $paroquia = Paroquia::find($dado->cod_paroquia_id);
        $dado->setAttribute('paroquia', $paroquia);

    }

    $pdf = Pdf::loadView('authenticated.relatorios.rede.comunidades.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);
    return $pdf->stream();
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
    public function cemiteriosPdf() {

        $dados = Cemiterio::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

        }

        $pdf = Pdf::loadView('authenticated.relatorios.rede.cemiterios.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
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
public function associacoesPdf() {

    $dados = Associacao::all();

    foreach ($dados as $dado) {

        $cidade = Cidade::find($dado->cod_cidade_id);
        $dado->setAttribute('cidade', $cidade);

        $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
        $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

    }

    $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);
    return $pdf->stream();
}


}
