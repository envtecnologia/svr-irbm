<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoFuncao;
use App\Models\Controle\Comunidade;
use App\Models\Pessoal\Funcao;
use App\Models\Pessoal\Pessoa;
use App\Models\Provincia;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Funcao::with('comunidade')->orderBy('datainicio', 'desc')->withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        foreach ($dados as $dado) {

            $funcao = TipoFuncao::find($dado->cod_tipo_funcao_id);
            $dado->setAttribute('funcao', $funcao);

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', $comunidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.funcoes.funcoes', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {

        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();
        $funcao = TipoFuncao::all()->withoutTrashed()->get();
        $provincias = Provincia::all()->withoutTrashed()->get();

        return view('authenticated.pessoal.pessoas.funcoes.newFuncao', compact(

            'pessoa_id',
            'comunidades',
            'provincias',
            'funcao'
        ));
        // Retorna a view para criar um novo post
    }

    public function store(Request $request, $pessoa_id)
    {
        $dados = new Funcao();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_funcao_id = $request->cod_tipo_funcao_id;
        $dados->cod_provincia_id = $request->cod_provincia_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        $dados->datainicio = $request->datainicio;
        $dados->datafinal = $request->datafinal;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.funcoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Funções cadastrada com sucesso!');
    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($pessoa_id, $funco)
    {
        $dados = Funcao::find($funco);
        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();
        $funcao = TipoFuncao::orderBy('descricao')->withoutTrashed()->get();
        $provincias = Provincia::orderBy('descricao')->withoutTrashed()->get();

        return view('authenticated.pessoal.pessoas.funcoes.newFuncao', compact(
            'dados',
            'pessoa_id',
            'comunidades',
            'provincias',
            'funcao',
            'funco'

        ));
    }

    public function update(Request $request, $pessoa_id, $funco)
    {
        $dados = Funcao::find($funco);
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_funcao_id = $request->cod_tipo_funcao_id;
        $dados->cod_provincia_id = $request->cod_provincia_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        $dados->datainicio = $request->datainicio;
        $dados->datafinal = $request->datafinal;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.funcoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Função editada com sucesso!');
    }

    public function destroy($pessoa_id, $funco)
    {
        // Remove um post do banco de dados
        Funcao::find($funco)->delete();
        return redirect()->route('pessoas.funcoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Função deletada com sucesso!');

    }
}
