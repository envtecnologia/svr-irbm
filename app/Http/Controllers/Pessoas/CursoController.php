<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoCurso;
use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Curso;
use App\Models\Provincia;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index($pessoa_id)
    {

        $dados = Curso::with('tipo_curso')->where('cod_pessoa_id', $pessoa_id)->withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.cursos.cursos', [
            'dados' => $dados,
            'provincias' => $provincias,
            'pessoa_id' => $pessoa_id
        ]);
    }

    public function create($pessoa_id)
    {

        $tipo_cursos = TipoCurso::withoutTrashed()->get();

        return view('authenticated.pessoal.pessoas.cursos.newCurso', compact(
            'tipo_cursos'
        ));
    }

    public function store(Request $request, $pessoa_id)
    {

        $dados = new Curso();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipocurso_id = $request->cod_tipocurso_id;
        $dados->datainicio = $request->datainicio;
        if(!empty($request->datafinal)){
            $dados->datafinal = $request->datafinal;
        }
        if(!empty($request->datacancelamento)){
            $dados->datacancelamento = $request->datacancelamento;
        }
        $dados->local = $request->local;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.atividades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Atividade cadastrada com sucesso!');
    }

    public function show($id) {}

    public function edit($pessoa_id, $atividade)
    {
        $dados = Atividade::find($atividade);
        $tipos_atividades = TipoAtividade::withoutTrashed()->get();
        $obras = Obra::withoutTrashed()->get();
        $comunidades = Comunidade::withoutTrashed()->get();
        // dd($dados);

        return view('authenticated.pessoal.pessoas.atividades.newAtividade', compact(
            'dados',
            'tipos_atividades',
            'obras',
            'comunidades',
            'pessoa_id'
        ));
    }

    public function update(Request $request, $pessoa_id, $atividade) {

        $dados = Atividade::where('id', $atividade)->first();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipoatividade_id = $request->cod_tipoatividade_id;
        $dados->cod_obra_id = $request->cod_obra_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        // $dados->endereco = $request->endereco;
        // $dados->cep = $request->cep;
        $dados->datainicio = $request->datainicio;
        $dados->datafinal = $request->datafinal;
        $dados->responsavel = $request->responsavel;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.atividades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Atividade editada com sucesso!');

    }

    public function destroy($pessoa_id, $atividade)
    {

        $dados = Atividade::find($atividade);

        if (!$dados) {
            return redirect()->route('pessoas.atividades.index', ['pessoa_id' => $pessoa_id])->with('error', 'Atividade não encontrada.');
        }

        $dados->delete();

        return redirect()->route('pessoas.atividades.index', ['pessoa_id' => $pessoa_id])->with('success', 'Atividade excluída com sucesso.');
    }
}
