<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoHabilidade;
use App\Models\Pessoal\Habilidade;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class HabilidadeController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Habilidade::orderBy('descricao')->withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        foreach ($dados as $dado) {

            $tipo_habilidade = TipoHabilidade::find($dado->cod_tipo_habilidade_id);
            $dado->setAttribute('tipo_habilidade', $tipo_habilidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.habilidades.habilidades', [
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
        $tipos_habilidade = TipoHabilidade::orderBy('descricao')->withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.habilidades.newHabilidade', compact(
            'tipos_habilidade',
            'pessoa',
            'pessoa_id'
        ));
        // Retorna a view para criar um novo post
    }

    public function store(Request $request, $pessoa_id)
    {

        $dados = new Habilidade();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_habilidade_id = $request->cod_tipo_habilidade_id;
        $dados->grau = $request->grau;
        $dados->save();

        return redirect()->route('pessoas.habilidades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Habilidade cadastrada com sucesso!');
    }

    public function show($id) {}

    public function edit($pessoa_id, $habilidadeId)
    {
        $dados = Habilidade::find($habilidadeId);

        $pessoa = Pessoa::find($pessoa_id);
        $tipos_habilidade = TipoHabilidade::orderBy('descricao')->withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.habilidades.newHabilidade', compact(
            'dados',
            'pessoa_id',
            'tipos_habilidade'
        ));
    }

    public function update(Request $request, $pessoa_id, $habilidadeId) {

        $dados = Habilidade::find($habilidadeId);
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_habilidade_id = $request->cod_tipo_habilidade_id;
        $dados->grau = $request->grau;
        $dados->save();

        return redirect()->route('pessoas.habilidades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Habilidade editada com sucesso!');

    }

    public function destroy($pessoa_id, $itinerarioId)
    {

        $dados = Habilidade::find($itinerarioId);

        if (!$dados) {
            return redirect()->route('pessoas.habilidades.index', ['pessoa_id' => $pessoa_id])->with('error', 'Habilidade não encontrada.');
        }

        $dados->delete();

        return redirect()->route('pessoas.habilidades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Habilidade excluída com sucesso.');
    }
}
