<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\TipoInstituicao;
use App\Models\Cidade;
use App\Models\Controle\Associacao;
use App\Models\Controle\Capitulo;
use App\Models\Controle\Cemiterio;
use App\Models\Controle\Diocese;
use App\Models\Controle\Paroquia;
use App\Models\Controle\Setor;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Provincia;
use Illuminate\Http\Request;

class ControleController extends Controller
{

        // ASSOCIACOES ------------------------------------------------------------------------------------------------------------------

        public function associacoes()
        {

            $dados = Associacao::withoutTrashed()->paginate(10);

            foreach ($dados as $dado) {
                $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
                $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

                // $banco = Banco::find($dado->cod_banco_id);
                // $dado->setAttribute('bnco', $banco);
            }



            return view('authenticated.controle.associacoes.associacoes', [
                'dados' => $dados
            ]);
        }

        public function searchAssociacao(Request $request)
        {
            $searchCriteria = [
                'descricao' => $request->input('descricao'),
                'situacao' => $request->input('situacao')
            ];

            $dados = Associacao::search($searchCriteria)->paginate(10);

            foreach ($dados as $dado) {
                $tipoAssociacoes = TipoInstituicao::find($dado->tipo_instituicoes_id);
                $dado->setAttribute('tipo_associacoes', $tipoAssociacoes);

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

                // $banco = Banco::find($dado->cod_banco_id);
                // $dado->setAttribute('bnco', $banco);
            }

            return view('authenticated.controle.associacoes.associacoes', [
                'dados' => $dados
            ]);
        }

        public function createAssociacao(Request $request)
        {

            $dados = new Associacao();
            $dados->tipo_instituicoes_id = $request->tipo_instituicoes;
            $dados->cnpj = $request->cnpj;
            $dados->descricao = $request->descricao;
            $dados->site = $request->site;
            $dados->caixapostal = $request->caixapostal;
            $dados->email = $request->email;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->descricao = $request->descricao;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->telefone3 = $request->telefone3;
            $dados->responsavel = $request->responsavel;
            $dados->save();

            return redirect('/controle/associacoes')->with('success', 'Associação cadastrada com sucesso!');
        }

        public function associacoesNew(){

            $tipo_instituicoes = TipoInstituicao::all();
            $cidades = Cidade::all();

            return view('authenticated.controle.associacoes.newAssociacao', [
                'tipo_instituicoes' => $tipo_instituicoes,
                'cidades' => $cidades

            ]);
        }

        public function editAssociacao($id)
        {

            $dados = Associacao::find($id);
            $tipo_instituicoes = TipoInstituicao::all();
            $cidades = Cidade::all();

            return view('authenticated.controle.associacoes.newAssociacao', [
                'dados' => $dados,
                'tipo_instituicoes' => $tipo_instituicoes,
                'cidades' => $cidades
            ]);
        }

        public function updateAssociacao(Request $request)
        {
            $dados = Associacao::find($request->id);
            $dados->tipo_instituicoes_id = $request->tipo_instituicoes;
            $dados->cnpj = $request->cnpj;
            $dados->descricao = $request->descricao;
            $dados->site = $request->site;
            $dados->caixapostal = $request->caixapostal;
            $dados->email = $request->email;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->descricao = $request->descricao;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->telefone3 = $request->telefone3;
            $dados->responsavel = $request->responsavel;
            $dados->save();

            return redirect('/controle/associacoes')->with('success', 'Associação editada com sucesso!');
        }

        public function deleteAssociacao($id)
        {
            $dados = Associacao::find($id);

            if (!$dados) {
                return redirect('/controle/associacoes')->with('error', 'Associação não encontrada.');
            }

            $dados->delete();

            return redirect('/controle/associacoes')->with('success', 'Associação excluída com sucesso.');
        }

        // CAPITULOS ----------------------------------------------------------------------------------------------------------------------

        public function capitulos()
        {

            $dados = Capitulo::withoutTrashed()->paginate(10);
            $provincias = Provincia::all();

            foreach ($dados as $dado) {

                $provincia = Provincia::find($dado->cod_provincia_id);
                $dado->setAttribute('provincia', $provincia);

            }



            return view('authenticated.controle.capitulos.capitulos', [
                'dados' => $dados,
                'provincias' => $provincias
            ]);
        }

        public function searchCapitulo(Request $request)
        {
            $searchCriteria = $request->all();

            $dados = Capitulo::search($searchCriteria)->paginate(10);
            $provincias = Provincia::all();

            foreach ($dados as $dado) {

                $provincia = Provincia::find($dado->cod_provincia_id);
                $dado->setAttribute('provincia', $provincia);

            }

            return view('authenticated.controle.capitulos.capitulos', [
                'dados' => $dados,
                'searchCriteria' => $searchCriteria,
                'provincias' => $provincias
            ]);
        }

        public function createCapitulo(Request $request)
        {

            $dados = new Capitulo();
            $dados->cod_provincia_id = $request->cod_provincia_id;
            $dados->numero = $request->numero;
            $dados->data = $request->data;
            $dados->detalhes = $request->detalhes;

            if($request->cod_provincia_id == ''){
                $dados->tipo = '0'; // Geral
            }else{
                $dados->tipo = '1'; // Pronvíncia
            }

            $dados->save();

            return redirect('/controle/capitulos')->with('success', 'Capítulo cadastrado com sucesso!');
        }

        public function capitulosNew(){

            $provincias = Provincia::all();

            return view('authenticated.controle.capitulos.newCapitulo', [
                'provincias' => $provincias

            ]);
        }

        public function editCapitulo($id)
        {

            $dados = Capitulo::find($id);
            $provincias = Provincia::all();

            return view('authenticated.controle.capitulos.newCapitulo', [
                'dados' => $dados,
                'provincias' => $provincias
            ]);
        }

        public function updateCapitulo(Request $request)
        {
            $dados = Capitulo::find($request->id);
            $dados->cod_provincia_id = $request->cod_provincia_id;
            $dados->numero = $request->numero;
            $dados->data = $request->data;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/controle/capitulos')->with('success', 'Capítulo editado com sucesso!');
        }

        public function deleteCapitulo($id)
        {
            $dados = Capitulo::find($id);

            if (!$dados) {
                return redirect('/controle/capitulos')->with('error', 'Capítulo não encontrado.');
            }

            $dados->delete();

            return redirect('/controle/capitulos')->with('success', 'Capítulo excluído com sucesso.');
        }

        // CEMITERIOS ----------------------------------------------------------------------------------------------------------------------

        public function cemiterios()
        {

            $dados = Cemiterio::withoutTrashed()->paginate(10);
            $cidades = Cidade::all();

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

            }



            return view('authenticated.controle.cemiterios.cemiterios', [
                'dados' => $dados,
                'cidades' => $cidades
            ]);
        }

        public function searchCemiterio(Request $request)
        {
            $searchCriteria = $request->all();

            $dados = Cemiterio::search($searchCriteria)->paginate(10);
            $cidades = Cidade::all();

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

            }

            return view('authenticated.controle.cemiterios.cemiterios', [
                'dados' => $dados,
                'searchCriteria' => $searchCriteria,
                'cidades' => $cidades
            ]);
        }

        public function createCemiterio(Request $request)
        {

            $dados = new Cemiterio();
            $dados->descricao = $request->descricao;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->contato = $request->contato;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/controle/cemiterios')->with('success', 'Cemitério cadastrado com sucesso!');
        }

        public function cemiteriosNew(){

            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.cemiterios.newCemiterio', [
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades

            ]);
        }

        public function editCemiterio($id)
        {

            $dados = Cemiterio::find($id);
            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.cemiterios.newCemiterio', [
                'dados' => $dados,
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades
            ]);
        }

        public function updateCemiterio(Request $request)
        {
            $dados = Cemiterio::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->contato = $request->contato;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/controle/cemiterios')->with('success', 'Cemitério editado com sucesso!');
        }

        public function deleteCemiterio($id)
        {
            $dados = Cemiterio::find($id);

            if (!$dados) {
                return redirect('/controle/cemiterios')->with('error', 'Cemitério não encontrado.');
            }

            $dados->delete();

            return redirect('/controle/cemiterios')->with('success', 'Cemitério excluído com sucesso.');
        }

        // DIOCESES ------------------------------------------------------------------------------------------------------------------

        public function dioceses()
        {

            $dados = Diocese::withoutTrashed()->paginate(10);
            $cidades = Cidade::all();

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

            }



            return view('authenticated.controle.dioceses.dioceses', [
                'dados' => $dados,
                'cidades' => $cidades
            ]);
        }

        public function searchDiocese(Request $request)
        {
            $searchCriteria = [
                'descricao' => $request->input('descricao'),
                'situacao' => $request->input('situacao')
            ];

            $dados = Diocese::search($searchCriteria)->paginate(10);

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

            }

            return view('authenticated.controle.dioceses.dioceses', [
                'dados' => $dados
            ]);
        }

        public function createDiocese(Request $request)
        {

            $dados = new Diocese();
            $dados->descricao = $request->descricao;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->site = $request->site;
            $dados->caixapostal = $request->caixapostal;
            $dados->email = $request->email;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->telefone3 = $request->telefone3;
            $dados->bispo = $request->bispo;
            $dados->fundacao = $request->fundacao;
            $dados->encerramento = $request->encerramento;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/controle/dioceses')->with('success', 'Diocese cadastrada com sucesso!');
        }

        public function diocesesNew(){

            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.dioceses.newDiocese', [
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades

            ]);
        }

        public function editDiocese($id)
        {

            $dados = Diocese::find($id);
            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.dioceses.newDiocese', [
                'dados' => $dados,
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades
            ]);
        }

        public function updateDiocese(Request $request)
        {
            $dados = Diocese::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->endereco = $request->endereco;
            $dados->cep = $request->cep;
            $dados->pais = $request->pais;
            $dados->estado = $request->estado;
            $dados->cod_cidade_id = $request->cod_cidade_id;
            $dados->site = $request->site;
            $dados->caixapostal = $request->caixapostal;
            $dados->email = $request->email;
            $dados->telefone1 = $request->telefone1;
            $dados->telefone2 = $request->telefone2;
            $dados->telefone3 = $request->telefone3;
            $dados->bispo = $request->bispo;
            $dados->fundacao = $request->fundacao;
            $dados->encerramento = $request->encerramento;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/controle/dioceses')->with('success', 'Diocese editada com sucesso!');
        }

        public function deleteDiocese($id)
        {
            $dados = Diocese::find($id);

            if (!$dados) {
                return redirect('/controle/dioceses')->with('error', 'Diocese não encontrada.');
            }

            $dados->delete();

            return redirect('/controle/dioceses')->with('success', 'Diocese excluída com sucesso.');
        }

        // PAROQUIAS ------------------------------------------------------------------------------------------------------------------

        public function paroquias()
        {

            $dados = Paroquia::withoutTrashed()->paginate(10);

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

                $diocese = Diocese::find($dado->cod_diocese_id);
                $dado->setAttribute('diocese', $diocese);

            }



            return view('authenticated.controle.paroquias.paroquias', [
                'dados' => $dados
            ]);
        }

        public function searchParoquia(Request $request)
        {
            $searchCriteria = [
                'descricao' => $request->input('descricao'),
                'situacao' => $request->input('situacao')
            ];

            $dados = Paroquia::search($searchCriteria)->paginate(10);

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

                $diocese = Diocese::find($dado->cod_diocese_id);
                $dado->setAttribute('diocese', $diocese);

            }

            return view('authenticated.controle.paroquias.paroquias', [
                'dados' => $dados
            ]);
        }

        public function createParoquia(Request $request)
        {

            $dados = new Paroquia();
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

            return redirect('/controle/paroquias')->with('success', 'Província cadastrada com sucesso!');
        }

        public function paroquiasNew(){

            $dioceses = Diocese::all();

            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.paroquias.newParoquia', [
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades,
                'dioceses' => $dioceses

            ]);
        }

        public function editParoquia($id)
        {

            $dados = Paroquia::find($id);
            $dioceses = Diocese::all();

            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.paroquias.newParoquia', [
                'dados' => $dados,
                'paises' => $paises,
                'estados' => $estados,
                'cidades' => $cidades,
                'dioceses' => $dioceses
            ]);
        }

        public function updateParoquia(Request $request)
        {
            $dados = Paroquia::find($request->id);
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

            return redirect('/controle/paroquias')->with('success', 'Província editada com sucesso!');
        }

        public function deleteParoquia($id)
        {
            $dados = Paroquia::find($id);

            if (!$dados) {
                return redirect('/controle/paroquias')->with('error', 'Província não encontrada.');
            }

            $dados->delete();

            return redirect('/controle/paroquias')->with('success', 'Província excluída com sucesso.');
        }

        // PROVINCIAS ------------------------------------------------------------------------------------------------------------------

        public function provincias()
        {

            $dados = Provincia::withoutTrashed()->paginate(10);

            foreach ($dados as $dado) {

                $cidade = Cidade::find($dado->cod_cidade_id);
                $dado->setAttribute('cidade', $cidade);

                $diocese = Diocese::find($dado->cod_diocese_id);
                $dado->setAttribute('diocese', $diocese);

            }



            return view('authenticated.controle.provincias.provincias', [
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

            return view('authenticated.controle.provincias.provincias', [
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

            return redirect('/controle/provincias')->with('success', 'Paróquia cadastrada com sucesso!');
        }

        public function provinciasNew(){

            $dioceses = Diocese::all();

            $cidades = Cidade::all();
            $paises = Pais::all();
            $estados = Estado::all();

            return view('authenticated.controle.provincias.newProvincia', [
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

            return view('authenticated.controle.provincias.newProvincia', [
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

            return redirect('/controle/provincias')->with('success', 'Paróquia editada com sucesso!');
        }

        public function deleteProvincia($id)
        {
            $dados = Provincia::find($id);

            if (!$dados) {
                return redirect('/controle/provincias')->with('error', 'Paróquia não encontrada.');
            }

            $dados->delete();

            return redirect('/controle/provincias')->with('success', 'Paróquia excluída com sucesso.');
        }

    // SETORES ---------------------------------------------------------------------------------------------------
    public function setores()
    {

        $dados = Setor::withoutTrashed()->paginate(10);

        return view('authenticated.controle.setores.setores', [
            'dados' => $dados
        ]);
    }

    public function searchSetor(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Setor::search($searchCriteria)->paginate(10);

        return view('authenticated.controle.setores.setores', [
            'dados' => $dados
        ]);
    }

    public function createSetor(Request $request)
    {

        $area = new Setor();
        $area->descricao = $request->descricao;
        $area->detalhes = $request->detalhes;
        $area->save();

        return redirect('/controle/setores')->with('success', 'Setor cadastrado com sucesso!');
    }

    public function editSetor($id)
    {

        $area = Setor::find($id);

        return view('authenticated.controle.setores.newSetor', [
            'area' => $area
        ]);
    }

    public function updateSetor(Request $request)
    {
        $area = Setor::find($request->id);
        $area->descricao = $request->descricao;
        $area->detalhes = $request->detalhes;
        $area->save();

        return redirect('/controle/setores')->with('success', 'Setor editado com sucesso!');
    }

    public function deleteSetor($id)
    {
        $area = Setor::find($id);

        if (!$area) {
            return redirect('/controle/setores')->with('error', 'Setor não encontrado.');
        }

        $area->delete();

        return redirect('/controle/setores')->with('success', 'Setor excluído com sucesso.');
    }
}
