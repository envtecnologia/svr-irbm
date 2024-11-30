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
            'pessoa_id',
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

        return redirect()->route('pessoas.cursos.index', ['pessoa_id' => $pessoa_id])->with('success', 'Curso cadastrado com sucesso!');
    }

    public function show($id) {}

    public function edit($pessoa_id, $curso_id)
    {
        $dados = Curso::find($curso_id);
        $tipo_cursos = TipoCurso::withoutTrashed()->get();
        // dd($dados);

        return view('authenticated.pessoal.pessoas.cursos.newCurso', compact(
            'dados',
            'pessoa_id',
            'curso_id',
            'tipo_cursos'
        ));
    }

    public function update(Request $request, $pessoa_id, $curso) {

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

        return redirect()->route('pessoas.cursos.index', ['pessoa_id' => $pessoa_id])->with('success', 'Curso editado com sucesso!');

    }

    public function destroy($pessoa_id, $curso)
    {

        $dados = Curso::find($curso);

        if (!$dados) {
            return redirect()->route('pessoas.cursos.index', ['pessoa_id' => $pessoa_id])->with('error', 'Curso não encontrado.');
        }

        $dados->delete();

        return redirect()->route('pessoas.cursos.index', ['pessoa_id' => $pessoa_id])->with('success', 'Curso excluído com sucesso.');
    }
}
