<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoArquivo;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cadastros\TipoObra;
use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Obra;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class AtividadeController extends Controller
{
    public function index(Request $request, $pessoa_id)
    {

        $pessoa = Pessoa::find($pessoa_id);
        $dados = Atividade::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->orderBy('datainicio', 'desc')->paginate(15);

        foreach ($dados as $dado) {

            $obra = Obra::find($dado->cod_obra_id);
            $dado->setAttribute('obra', $obra);

            $comunidade = Comunidade::where('id', $dado->cod_comunidade_id)->first();
            $dado->setAttribute('comunidade', $comunidade);

            $localidade = Cidade::find($comunidade->cod_cidade_id);
            $dado->setAttribute('localidade', $localidade);

            $tipo_atividade = TipoAtividade::find($dado->cod_tipoatividade_id);
            $dado->setAttribute('tipo_atividade', $tipo_atividade);
        }
        $id = $pessoa_id;
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.atividades.atividades', [
            'dados' => $dados,
            'pessoa_id' => $id,
            'pessoa' => $pessoa
        ]);
    }

    public function create($pessoa_id)
    {

        $tipos_atividades = TipoAtividade::withoutTrashed()->get();
        $obras = Obra::withoutTrashed()->get();
        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();

        return view('authenticated.pessoal.pessoas.atividades.newAtividade', compact(
            'tipos_atividades',
            'obras',
            'comunidades',
            'pessoa_id'
        ));
    }

    public function store(Request $request, $pessoa_id)
    {

        $dados = new Atividade();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_tipoatividade_id = $request->cod_tipoatividade_id;
        $dados->cod_obra_id = $request->cod_obra_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        // $dados->endereco = $request->endereco;
        // $dados->cep = $request->cep;
        $dados->datainicio = $request->datainicio;
        if(!empty($request->datafinal)){
            $dados->datafinal = $request->datafinal;
        }
        $dados->responsavel = $request->responsavel;
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
        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();
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
