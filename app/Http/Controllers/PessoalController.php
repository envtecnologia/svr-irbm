<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Provincia;
use Illuminate\Http\Request;

class PessoalController extends Controller
{
       // PROVINCIAS ------------------------------------------------------------------------------------------------------------------

       public function pessoas()
       {

           $dados = Provincia::withoutTrashed()->paginate(10);

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

       public function searchProvincia(Request $request)
       {
           $searchCriteria = [
               'descricao' => $request->input('descricao'),
               'situacao' => $request->input('situacao')
           ];

           $dados = Provincia::search($searchCriteria)->paginate(10);

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

       public function createProvincia(Request $request)
       {

           $dados = new Provincia();
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

           return view('authenticated.pessoal.pessoas.newProvincia', [
               'paises' => $paises,
               'estados' => $estados,
               'cidades' => $cidades,
               'dioceses' => $dioceses

           ]);
       }

       public function editProvincia($id)
       {

           $dados = Provincia::find($id);
           $dioceses = Diocese::all();

           $cidades = Cidade::all();
           $paises = Pais::all();
           $estados = Estado::all();

           return view('authenticated.pessoal.pessoas.newProvincia', [
               'dados' => $dados,
               'paises' => $paises,
               'estados' => $estados,
               'cidades' => $cidades,
               'dioceses' => $dioceses
           ]);
       }

       public function updateProvincia(Request $request)
       {
           $dados = Provincia::find($request->id);
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

       public function deleteProvincia($id)
       {
           $dados = Provincia::find($id);

           if (!$dados) {
               return redirect('/pessoal/pessoas')->with('error', 'Paróquia não encontrada.');
           }

           $dados->delete();

           return redirect('/pessoal/pessoas')->with('success', 'Paróquia excluída com sucesso.');
       }


    //    FUNNCTIONS DAS FUNÇÕES DA SEÇÃO PESSOAS
    public function pessoasArquivos()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.arquivos.arquivos', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

    public function pessoasAtividades()
    {

        $dados = Provincia::withoutTrashed()->paginate(10);
        $provincias = Provincia::all();

        foreach ($dados as $dado) {

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

            $diocese = Diocese::find($dado->cod_diocese_id);
            $dado->setAttribute('diocese', $diocese);

        }

        return view('authenticated.pessoal.pessoas.atividades.atividades', [
            'dados' => $dados,
            'provincias' => $provincias
        ]);
    }

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
