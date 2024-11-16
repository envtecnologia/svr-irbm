<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Controle\Paroquia;
use App\Models\Estado;
use Illuminate\Http\Request;

class UtilsController extends Controller
{

    public function obterPais($estado_id)
    {
        $pais = Estado::where('id', $estado_id)->first()->pais;
        return response()->json($pais);
    }
    public function obterEstado($cidade_id)
    {
        $estado = Cidade::where('id', $cidade_id)->first()->estado;
        return response()->json($estado);
    }

    public function obterCidade($cidade_id)
    {
        $cidade = Cidade::where('id', $cidade_id)->first();
        // dd($cidade);
        return response()->json($cidade);
    }



    public function obterEstados($pais_id)
    {
        $estados = Estado::where('cod_pais_id', $pais_id)->get();
        return response()->json($estados);
    }

    public function obterCidades($estado_id)
    {
        $cidades = Cidade::where('cod_estado_id', $estado_id)->get();
        return response()->json($cidades);
    }

    public function obterParoquias($diocese_id)
    {
        $paroquias = Paroquia::where('cod_diocese_id', $diocese_id)->get();
        return response()->json($paroquias);
    }


}
