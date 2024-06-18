<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\TipoArquivo;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Pessoal\Arquivo;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Pessoa;
use App\Models\Provincia;
use Illuminate\Http\Request;

class PessoalController extends Controller
{
       // PROVINCIAS ------------------------------------------------------------------------------------------------------------------

       public function pessoas()
       {

           $dados = Pessoa::withoutTrashed()->paginate(10);

           foreach ($dados as $dado) {

               $cidade = Cidade::find($dado->cod_cidade_id);
               $dado->setAttribute('cidade', $cidade);

               $diocese = Diocese::find($dado->cod_diocese_id);
               $dado->setAttribute('diocese', $diocese);

               $provincia = Diocese::find($dado->cod_provincia_id);
               $dado->setAttribute('provincia', $provincia);

           }

           return view('authenticated.pessoal.pessoas.pessoas', [
               'dados' => $dados
           ]);
       }

       public function searchPessoa(Request $request)
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

           return view('authenticated.pessoal.pessoas.pessoas', [
               'dados' => $dados
           ]);
       }

       public function createPessoa(Request $request)
       {

           $dados = new Pessoa();
           $dados->descricao = $request->descricao;
           $dados->endereco = $request->endereco;
           $dados->cep = $request->cep;
           $dados->pais = $request->pais;
           $dados->estado = $request->estado;
           $dados->cod_diocese_id = $request->cod_diocese_id;
           $dados->cod_cidade_id = $request->cod_cidade_id;
           $dados->site = $request->site;
           $dados->caixapostal = $request->caixapostal;
           $dados->email = $request->email;
           $dados->telefone1 = $request->telefone1;
           $dados->telefone2 = $request->telefone2;
           $dados->telefone3 = $request->telefone3;
           $dados->paroco = $request->paroco;
           $dados->fundacao = $request->fundacao;
           $dados->encerramento = $request->encerramento;
           $dados->detalhes = $request->detalhes;
           $dados->save();

           return redirect('/pessoal/pessoas')->with('success', 'Paróquia cadastrada com sucesso!');
       }

       public function pessoasNew(){

           $dioceses = Diocese::all();

           $cidades = Cidade::all();
           $paises = Pais::all();
           $estados = Estado::all();

           return view('authenticated.pessoal.pessoas.newPessoa', [
               'paises' => $paises,
               'estados' => $estados,
               'cidades' => $cidades,
               'dioceses' => $dioceses

           ]);
       }

       public function editPessoa($id)
       {

           $dados = Pessoa::find($id);
           $dioceses = Diocese::all();

           $cidades = Cidade::all();
           $paises = Pais::all();
           $estados = Estado::all();

           return view('authenticated.pessoal.pessoas.newPessoa', [
               'dados' => $dados,
               'paises' => $paises,
               'estados' => $estados,
               'cidades' => $cidades,
               'dioceses' => $dioceses
           ]);
       }

       public function updatePessoa(Request $request)
       {
           $dados = Pessoa::find($request->id);
           $dados->descricao = $request->descricao;
           $dados->endereco = $request->endereco;
           $dados->cep = $request->cep;
           $dados->pais = $request->pais;
           $dados->estado = $request->estado;
           $dados->cod_diocese_id = $request->cod_diocese_id;
           $dados->cod_cidade_id = $request->cod_cidade_id;
           $dados->site = $request->site;
           $dados->caixapostal = $request->caixapostal;
           $dados->email = $request->email;
           $dados->telefone1 = $request->telefone1;
           $dados->telefone2 = $request->telefone2;
           $dados->telefone3 = $request->telefone3;
           $dados->paroco = $request->paroco;
           $dados->fundacao = $request->fundacao;
           $dados->encerramento = $request->encerramento;
           $dados->detalhes = $request->detalhes;
           $dados->save();

           return redirect('/pessoal/pessoas')->with('success', 'Paróquia editada com sucesso!');
       }

       public function deletePessoa($id)
       {
           $dados = Pessoa::find($id);

           if (!$dados) {
               return redirect('/pessoal/pessoas')->with('error', 'Paróquia não encontrada.');
           }

           $dados->delete();

           return redirect('/pessoal/pessoas')->with('success', 'Paróquia excluída com sucesso.');
       }


    //    FUNNCTIONS DAS FUNÇÕES DA SEÇÃO PESSOAS
    // ARQUIVOS
    public function pessoasArquivos(Request $request)
    {

        $pessoa = Pessoa::find($request->id);
        $dados = Arquivo::withoutTrashed()->where('cod_pessoa_id', $pessoa->id)->paginate(10);
        $cod_tipoarquivo_id = TipoArquivo::all();

        foreach ($dados as $dado) {

            $cod_tipoarquivo_id = TipoArquivo::find($dado->cod_tipoarquivo_id);
            $dado->setAttribute('cod_tipoarquivo_id', $cod_tipoarquivo_id);

        }

        return view('authenticated.pessoal.pessoas.arquivos.arquivos', [
            'dados' => $dados,
            'cod_tipoarquivo_id' => $cod_tipoarquivo_id,
            'pessoa' => $pessoa
        ]);
    }

    public function newArquivo($pessoa_id){

        $tiposArquivos = TipoArquivo::all();

        return view('authenticated.pessoal.pessoas.arquivos.newArquivos', [
            'tipos_arquivos' => $tiposArquivos,
            'pessoa_id' => $pessoa_id,

        ]);
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

    public function createArquivo(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            // Salva o caminho do arquivo no banco de dados
            $arquivo = new Arquivo();
            $arquivo->cod_pessoa_id = $request->cod_pessoa_id;
            $arquivo->cod_tipoarquivo_id = $request->cod_tipoarquivo_id;
            $arquivo->descricao = $request->descricao;
            $arquivo->caminho = $path;
            $arquivo->save();

            return back()->with('success', 'Arquivo enviado com sucesso!');
        }

        return back()->withErrors('Erro ao enviar o arquivo.');
    }

    public function deleteArquivo($id)
    {
        $dados = Arquivo::find($id);

        if (!$dados) {
            return redirect('/pessoal/pessoas')->with('error', 'Arquivo não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/pessoas')->with('success', 'Arquivo excluído com sucesso.');
    }

    // ARQUIVOS --------------------------------------------------------
    public function pessoasAtividades(Request $request)
    {

        $pessoa = Pessoa::find($request->id);
        $dados = Atividade::withoutTrashed()->where('cod_pessoa_id', $pessoa->id)->paginate(10);
        $cod_tipoatividade_id = TipoArquivo::all();

        foreach ($dados as $dado) {

            $cod_tipoatividade_id = TipoAtividade::find($dado->cod_tipoatividade_id);
            $dado->setAttribute('cod_tipoatividade_id', $cod_tipoatividade_id);

        }

        return view('authenticated.pessoal.pessoas.atividades.atividades', [
            'dados' => $dados,
            'cod_tipoatividade_id' => $cod_tipoatividade_id,
            'pessoa' => $pessoa
        ]);
    }

    public function newAtividade($pessoa_id){

        $tiposAtividades = TipoAtividade::all();

        return view('authenticated.pessoal.pessoas.atividades.newAtividade', [
            'tipos_atividades' => $tiposAtividades,
            'pessoa_id' => $pessoa_id,

        ]);
    }

    // public function searchAtividade(Request $request)
    // {
    //     $searchCriteria = [
    //         'descricao' => $request->input('descricao'),
    //         'situacao' => $request->input('situacao')
    //     ];

    //     $dados = Pessoa::search($searchCriteria)->paginate(10);

    //     return view('authenticated.pessoal.pessoas.atividades.atividades', [
    //         'dados' => $dados
    //     ]);
    // }

    public function createAtividade(Request $request)
    {

        $dados = new Atividade();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->cod_tipoatividade_id = $request->cod_tipoatividade_id;
        $dados->cod_obra_id = $request->cod_obra_id;
        $dados->cod_comunidade_id = $request->cod_comunidade_id;
        $dados->endereco = $request->endereco;
        $dados->cep = $request->cep;
        $dados->datainicio = $request->datainicio;
        $dados->datafinal = $request->datafinal;
        $dados->responsavel = $request->responsavel;
        $dados->detalhes = $request->detalhes;
        $dados->situacao = $request->situacao;
        $dados->save();

        return redirect('/pessoal/pessoas/atividades')->with('success', 'Atividade cadastrada com sucesso!');
    }

    public function deleteAtividade($id)
    {
        $dados = Atividade::find($id);

        if (!$dados) {
            return redirect('/pessoal/pessoas')->with('error', 'Atividade não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/pessoas')->with('success', 'Atividade excluído com sucesso.');
    }


    // -------------------------------------------------------------------------


    public function pessoasCursos()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.cursos.cursos', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasParentes()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.parentes.parentes', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasFormacoes()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.formacoes.formacoes', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasFuncoes()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.funcoes.funcoes', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasHabilidades()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.habilidades.habilidades', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasHistorico()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.historico.historico', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasItinerarios()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.itinerarios.itinerarios', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasOcorrenciasMedicas()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.ocorrenciasMedicas.ocorrenciasMedicas', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasImprimir()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.imprimir.imprimir', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }



}
