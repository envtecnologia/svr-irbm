<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Controle\Setor;
use App\Models\Pais;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function testePdf() {

        $dados = Pais::all();

        $pdf = Pdf::loadView('authenticated.relatorios.rede.associacoes.pdf', ['dados' => $dados])->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        return $pdf->stream();
    }
}
