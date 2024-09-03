<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Pessoal\Historico;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Historico::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.historico.historico', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {
        $tipos_historicos = Historico::withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.historico.newHistorico', compact(

            'pessoa_id'
        ));
        // Retorna a view para criar um novo post
    }

    public function store(Request $request, $pessoa_id)
    {
        $dados = new Historico();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.historico.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação cadastrada com sucesso!');
    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($pessoa_id, $historico)
    {
        $dados = Historico::find($historico);


        return view('authenticated.pessoal.pessoas.historico.newHistorico', compact(
            'dados',
            'pessoa_id'
        ));
        // Retorna a view para editar um post existente
    }

    public function update(Request $request, $pessoa_id, $historico)
    {
        $dados = Historico::find($historico);
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.historico.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação editada com sucesso!');
        // Atualiza um post existente no banco de dados
    }

    public function destroy($pessoa_id,$historico)
    {
           // Remove um post do banco de dados
           Historico::find($historico)->delete();
           return redirect()->route('pessoas.formacoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação deletada com sucesso!');
        // Remove um post do banco de dados
    }
}
