<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
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


}
