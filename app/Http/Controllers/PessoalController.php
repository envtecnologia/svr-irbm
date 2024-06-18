<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Provincia;
use Illuminate\Http\Request;

class PessoalController extends Controller
{
    public function egressos()
    {

        $dados = Egresso::withoutTrashed()->paginate(10);

        return view('authenticated.pessoal.egressos.egressos', [
            'dados' => $dados
        ]);
    }

    public function searchEgressos(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Egresso::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.egressos.egressos', [
            'dados' => $dados
        ]);
    }

    public function createEgressos(Request $request)
    {

        $dados = new Egresso();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/egressos')->with('success', 'Egressos cadastrado com sucesso!');
    }

    public function editEgressos($id)
    {
        $dados = Provincia::find($id);


        $dados = Provincia::find($dados->cod_pessoa_id);
        $cod_pessoa = Provincia::find($dados->cod_pessoa_id);

        $dados->setAttribute('cod_pessoa_id', $cod_pessoa ? $cod_pessoa->id : null);
        if ($dados) {
            // Buscar cod_pessoa_id do registro encontrado
            $cod_pessoa = Provincia::find($dados->cod_pessoa_id);

            // Adicionar cod_pessoa_id ao objeto $dados se encontrado
            $dados->setAttribute('cod_pessoa_id', $cod_pessoa ? $cod_pessoa->id : null);
        } else {
            // Tratar o caso em que o registro não foi encontrado
            return redirect('/pessoal/egressos')->with('error', 'Registro não encontrado');
        }
        // dd($dados);
         // Verificar se o registro foi encontrado e é um objeto
        return view('authenticated.pessoal.egressos.newEgressos', [
            'dados' => $dados
        ]);
    }

    public function updateEgressos(Request $request)
    {
        $dados = Egresso::find($request->id);
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/egressos')->with('success', 'Egressos editado com sucesso!');
    }

    public function deleteEgressos($id)
    {
        $dados = Egresso::find($id);

        if (!$dados) {
            return redirect('/pessoal/egressos')->with('error', 'Egressos não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/egressos')->with('success', 'Egressos excluído com sucesso.');
    }

    public function egressosNew(){

        $dados= Provincia::all();

        return view('authenticated.pessoal.egressos.newEgressos', [
            'dados' => $dados

        ]);
    }


//-------FALECIMENTOS-------//
    public function falecimentos()
    {

        $dados = Egresso::withoutTrashed()->paginate(10);

        return view('authenticated.pessoal.falecimentos.falecimentos', [
            'dados' => $dados
        ]);
    }

    public function searchFalecimentos(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Egresso::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.falecimentos.falecimentos', [
            'dados' => $dados
        ]);
    }

    public function createFalecimentos(Request $request)
    {

        $dados = new Egresso();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos cadastrado com sucesso!');
    }

    public function editFalecimentos($id)
    {

        $dados = Egresso::find($id);

        return view('authenticated.pessoal.falecimentos.newFalecimentos', [
            '$dados' => $dados
        ]);
    }

    public function updateFalecimentos(Request $request)
    {
        $dados = Egresso::find($request->id);
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos editado com sucesso!');
    }

    public function deleteFalecimentos($id)
    {
        $dados = Egresso::find($id);

        if (!$dados) {
            return redirect('/pessoal/falecimentos')->with('error', 'Falecimentos não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos excluído com sucesso.');
    }

    public function falecimentosNew(){

        $dados= Egresso::all();

        return view('authenticated.pessoal.falecimentos.newFalecimentos', [
            'dados' => $dados

        ]);
    }
    //-- Transferencia
    public function transferencia()
    {

        $dados = Egresso::withoutTrashed()->paginate(10);

        return view('authenticated.pessoal.transferencia.transferencia', [
            'dados' => $dados
        ]);
    }

    public function searchTransferencia(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Egresso::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.transferencia.transferencia', [
            'dados' => $dados
        ]);
    }

    public function createTransferencia(Request $request)
    {

        $dados = new Egresso();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia cadastrado com sucesso!');
    }

    public function editTransferencia($id)
    {

        $dados = Egresso::find($id);

        return view('authenticated.pessoal.transferencia.newTransferencia', [
            '$dados' => $dados
        ]);
    }

    public function updateTransferencia(Request $request)
    {
        $dados = Egresso::find($request->id);
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia editado com sucesso!');
    }

    public function deleteTransferencia($id)
    {
        $dados = Egresso::find($id);

        if (!$dados) {
            return redirect('/pessoal/transferencia')->with('error', 'Transferencia não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia excluído com sucesso.');
    }

    public function transferenciaNew(){

        $dados= Egresso::all();

        return view('authenticated.pessoal.transferencia.newTransferencia', [
            'dados' => $dados

        ]);
    }

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

}
