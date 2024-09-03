<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Controle\Comunidade;
use App\Models\Pessoal\Itinerario;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class ItinerarioController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Itinerario::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        foreach ($dados as $dado) {

            $comunidade_atual = Comunidade::find($dado->cod_comunidade_atual_id);
            $dado->setAttribute('comunidade_atual', $comunidade_atual);

            $comunidade_anterior = Comunidade::find($dado->cod_comunidade_anterior_id);
            $dado->setAttribute('comunidade_anterior', $comunidade_anterior);

            $comunidade_destino = Comunidade::find($dado->cod_comunidade_destino_id);
            $dado->setAttribute('comunidade_destino', $comunidade_destino);

        }

        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.itinerarios.itinerarios', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create()
    {
        // Retorna a view para criar um novo post
    }

    public function store(Request $request)
    {
        // Armazena um novo post no banco de dados
    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($id)
    {
        // Retorna a view para editar um post existente
    }

    public function update(Request $request, $id)
    {
        // Atualiza um post existente no banco de dados
    }

    public function destroy($id)
    {
        // Remove um post do banco de dados
    }
}
