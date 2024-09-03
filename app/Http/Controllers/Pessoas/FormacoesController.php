<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cadastros\TipoFormReligiosa;
use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Obra;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Pessoal\Formacao;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class FormacoesController extends Controller
{
    public function index($pessoa_id)
    {
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Formacao::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->orderBy('created_at', 'desc')->paginate(10);

        foreach ($dados as $dado) {

            $tipo_formacao = TipoFormReligiosa::find($dado->cod_tipo_formacao_id);
            $dado->setAttribute('tipo_formacao', $tipo_formacao);

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', $comunidade);

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);
        }
        $id = $pessoa_id;
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.formacoes.formacoes', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {
        $tipos_formacoes = TipoFormReligiosa::withoutTrashed()->get();
        $comunidades = Comunidade::withoutTrashed()->get();

        $cidades = Cidade::all();
        $paises = Pais::all();
        $estados = Estado::all();


        return view('authenticated.pessoal.pessoas.formacoes.newFormacao', compact(
            'tipos_formacoes',
            'comunidades',
            'cidades',
            'paises',
            'estados',
            'pessoa_id'
        ));
    }

    public function store(Request $request, $pessoa_id)
    {
        dd($request);
        $dados = new Formacao();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_formacao_id = $request->cod_tipo_formacao_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        $dados->data = $request->data;
        $dados->prazo = $request->prazo;
        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.formacoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação cadastrada com sucesso!');

    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($pessoa_id, $formaco)
    {
        $dados = Formacao::find($formaco);
        $tipos_formacoes = TipoFormReligiosa::withoutTrashed()->get();
        $comunidades = Comunidade::withoutTrashed()->get();

        $cidades = Cidade::all();
        $paises = Pais::all();
        $estados = Estado::all();

        return view('authenticated.pessoal.pessoas.formacoes.newFormacao', compact(
            'dados',
            'tipos_formacoes',
            'comunidades',
            'cidades',
            'paises',
            'estados',
            'pessoa_id',
            'formaco'

        ));
    }

    public function update(Request $request, $pessoa_id, $formacao)
    {
        $dados = Formacao::find($formacao);
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipo_formacao_id = $request->cod_tipo_formacao_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        $dados->data = $request->data;
        $dados->prazo = $request->prazo;
        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.formacoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação editada com sucesso!');
    }

    public function destroy($pessoa_id, $formaco)
    {
        // Remove um post do banco de dados
        Formacao::find($formaco)->delete();
        return redirect()->route('pessoas.formacoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Formação deletada com sucesso!');

    }
}
