<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoArquivo;
use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Pessoal\Arquivo;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class ArquivoController extends Controller
{
    public function index($pessoa_id)
    {

        $pessoa = Pessoa::find($pessoa_id);
        $dados = Arquivo::withoutTrashed()->where('cod_pessoa_id', $pessoa->id)->paginate(10);
        $cod_tipoarquivo_id = TipoArquivo::all();

        foreach ($dados as $dado) {

            $cod_tipoarquivo_id = TipoArquivo::find($dado->cod_tipoarquivo_id);
            $dado->setAttribute('cod_tipoarquivo_id', $cod_tipoarquivo_id);

        }

        return view('authenticated.pessoal.pessoas.arquivos.arquivos', [
            'dados' => $dados,
            'cod_tipoarquivo_id' => $cod_tipoarquivo_id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id
        ]);
    }

    public function create($pessoa_id)
    {

        $tiposArquivos = TipoArquivo::all();

        return view('authenticated.pessoal.pessoas.arquivos.newArquivos', [
            'tipos_arquivos' => $tiposArquivos,
            'pessoa_id' => $pessoa_id,

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/pessoas/documentos', 'public');
            $path = str_replace('uploads/pessoas/', '', $path);

            // Salva o caminho do arquivo no banco de dados
            $arquivo = new Arquivo();
            $arquivo->cod_pessoa_id = $request->cod_pessoa_id;
            $arquivo->cod_tipoarquivo_id = $request->cod_tipoarquivo_id;
            $arquivo->descricao = $request->descricao;
            $arquivo->caminho = $path;
            $arquivo->save();

            return redirect()->route('pessoas.arquivos.index', ['pessoa_id' => $request->cod_pessoa_id])->with('success', 'Arquivo enviado com sucesso!');
        }

        return back()->withErrors('Erro ao enviar o arquivo.');
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

    public function destroy($pessoa_id, $arquivo)
    {
        $dados = Arquivo::find($arquivo);

        if (!$dados) {
            return redirect()->route('pessoas.arquivos.index', ['pessoa_id' => $pessoa_id])->with('error', 'Arquivo não encontrado.');
        }

        $dados->delete();

        return redirect()->route('pessoas.arquivos.index', ['pessoa_id' => $pessoa_id])->with('success', 'Arquivo excluído com sucesso.');
    }

    public function searchArquivo(Request $request)
    {
        $searchCriteria = [
            'descricao' => $request->input('descricao'),
            'situacao' => $request->input('situacao')
        ];

        $dados = Pessoa::search($searchCriteria)->paginate(10);

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.arquivos.arquivos', [
            'dados' => $dados
        ]);
    }
}
