<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Parentesco;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Familiares;
use App\Models\Pais;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class ParenteController extends Controller
{
    public function index($pessoa_id)
    {
        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Familiares::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        foreach ($dados as $dado) {

            $parentesco = Parentesco::find($dado->cod_parentesco_id);
            $dado->setAttribute('parentesco', $parentesco);

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.parentes.parentes', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {
        $parentes = Familiares::withoutTrashed()->get();
        $parentescos = Parentesco::all();
        $cidades = Cidade::all();
        $paises = Pais::all();
        $estados = Estado::all();

        // Retorna a view para criar um novo post
        return view('authenticated.pessoal.pessoas.parentes.newParente', compact(
            'pessoa_id',
            'parentes',
            'parentescos',
            'cidades',
            'paises',
            'estados'

        ));
    }

    public function store(Request $request, $pessoa_id)
    {
        $dados = new Familiares();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_parentesco_id = $request->cod_parentesco_id;
        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->endereco = $request->endereco;
        $dados->nome = $request->nome;

        $dados->cep = $request->cep;
        $dados->sexo = $request->sexo;
        $dados->datanascimento = $request->datanascimento;
        $dados->datafalecimento = $request->datafalecimento;
        $dados->telefone1 = $request->telefone1;
        $dados->telefone2 = $request->telefone2;
        $dados->telefone3 = $request->telefone3;
        $dados->email = $request->email;
        $dados->detalhes = $request->detalhes;
        $dados->situacao = $request->situacao;


        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->save();

        return redirect()->route('pessoas.formacoes.index', ['pessoa_id' => $pessoa_id])->with('success', 'Parente cadastrada com sucesso!');


        // Armazena um novo post no banco de dados
    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($pessoa_id, $parente)
    {
        $dados = Familiares::find($parente);

              $parentescos = Parentesco::orderBy('descricao')->get();
        $cidades = Cidade::orderBy('descricao')->get();
        $paises = Pais::orderBy('descricao')->get();
        $estados = Estado::orderBy('descricao')->get();

        // Retorna a view para criar um novo post
        return view('authenticated.pessoal.pessoas.parentes.newParente', compact(
            'pessoa_id',
            'parente',
            'cidades',
            'paises',
            'estados',
            'dados',
            'parentescos'

        ));
        // Retorna a view para editar um post existente
    }

    public function update($pessoaId, $parenteId, Request $request)
    {
        $dados = Familiares::find($parenteId);
        // $dados->cod_pessoa_id = $pessoaId;
        $dados->cod_parentesco_id = $request->cod_parentesco_id;
        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->endereco = $request->endereco;
        $dados->nome = $request->nome;

        $dados->cep = $request->cep;
        $dados->sexo = $request->sexo;
        $dados->datanascimento = $request->datanascimento;
        $dados->datafalecimento = $request->datafalecimento;
        $dados->telefone1 = $request->telefone1;
        $dados->telefone2 = $request->telefone2;
        $dados->telefone3 = $request->telefone3;
        $dados->email = $request->email;
        $dados->detalhes = $request->detalhes;
        if(!empty($dados->datafalecimento)){
            $dados->situacao = 0;
        }else{
            $dados->situacao = 1;
        }


        $dados->cod_cidade_id = $request->cod_cidade_id;
        $dados->save();

        return redirect()->route('pessoas.parentes.index', ['pessoa_id' => $pessoaId])->with('success', 'Parente editado com sucesso!');

    }

    public function destroy($pessoaId, $parenteId)
    {

        $dados = Familiares::find($parenteId);

        if (!$dados) {
            return redirect()->route('pessoas.parentes.index', ['pessoa_id' => $pessoaId])->with('error', 'Parente não encontrado.');
        }

        $dados->delete();

        return redirect()->route('pessoas.parentes.index', ['pessoa_id' => $pessoaId])->with('success', 'Parente excluído com sucesso.');
    }
}
