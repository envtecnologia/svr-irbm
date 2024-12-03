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
        $dados = Itinerario::orderBy('chegada', 'desc')->withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

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

    public function create($pessoa_id)
    {
        $pessoa = Pessoa::find($pessoa_id);

        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.itinerarios.newItinerario', compact(
            'pessoa',
            'pessoa_id',
            'comunidades'
        ));

        // Retorna a view para criar um novo post
    }

    public function store(Request $request, $pessoa_id)
    {

        $dados = new Itinerario();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_comunidade_atual_id = $request->cod_comunidade_atual_id;
        $dados->cod_comunidade_anterior_id = $request->cod_comunidade_anterior_id;
        $dados->cod_comunidade_destino_id = $request->cod_comunidade_destino_id;
        $dados->chegada = $request->chegada;
        if(!empty($request->saida)){
            $dados->saida = $request->saida;
        }
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.itinerarios.index', ['pessoa_id' => $pessoa_id])->with('success', 'Itinerário cadastrado com sucesso!');
    }

    public function show($id) {}

    public function edit($pessoa_id, $itinerarioId)
    {
        $dados = Itinerario::find($itinerarioId);

        $pessoa = Pessoa::find($pessoa_id);
        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.itinerarios.newItinerario', compact(
            'dados',
            'pessoa_id',
            'comunidades'
        ));
    }

    public function update(Request $request, $pessoa_id, $itinerarioId) {

        $dados = Itinerario::find($itinerarioId);
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_comunidade_atual_id = $request->cod_comunidade_atual_id;
        $dados->cod_comunidade_anterior_id = $request->cod_comunidade_anterior_id;
        $dados->cod_comunidade_destino_id = $request->cod_comunidade_destino_id;
        $dados->chegada = $request->chegada;
        if(!empty($request->saida)){
            $dados->saida = $request->saida;
        }
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.itinerarios.index', ['pessoa_id' => $pessoa_id])->with('success', 'Itinerário editado com sucesso!');

    }

    public function destroy($pessoa_id, $itinerarioId)
    {

        $dados = Itinerario::find($itinerarioId);

        if (!$dados) {
            return redirect()->route('pessoas.itinerarios.index', ['pessoa_id' => $pessoa_id])->with('error', 'Itinerário não encontrado.');
        }

        $dados->delete();

        return redirect()->route('pessoas.itinerarios.index', ['pessoa_id' => $pessoa_id])->with('success', 'Itinerário excluído com sucesso.');
    }
}
