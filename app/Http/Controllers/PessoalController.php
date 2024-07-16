<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\Parentesco;
use App\Models\Cadastros\TipoArquivo;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cadastros\TipoFormReligiosa;
use App\Models\Cadastros\TipoFuncao;
use App\Models\Cadastros\TipoHabilidade;
use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Pessoal\Arquivo;
use App\Models\Pessoal\Atividade;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Formacao;
use App\Models\Pessoal\Funcao;
use App\Models\Pessoal\Habilidade;
use App\Models\Pessoal\Historico;
use App\Models\Pessoal\Itinerario;
use App\Models\Pessoal\Parente;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
use Illuminate\Http\Request;

class PessoalController extends Controller
{
    public function egressos()
    {

        $dados = Egresso::with('pessoa')
                        ->withoutTrashed()
                        ->where('situacao', 1)
                        ->orderBy('data_saida', 'desc')
                        ->paginate(10);

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
        $dados->cod_pessoa = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/egressos')->with('success', 'Egressos cadastrado com sucesso!');
    }

    public function editEgressos($id)
    {
        // Find the first record by ID
        $dados = Egresso::find($id);

        return view('authenticated.pessoal.egressos.newEgressos', [
            'dados' => $dados
        ]);
    }


    public function updateEgressos(Request $request)
    {
        $dados = Egresso::find($request->id);
        $dados->cod_pessoa  = $request->cod_pessoa_id;
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

        $dados = Pessoa::all();

        // dd($dados);

        return view('authenticated.pessoal.egressos.newEgressos', [
            'dados' => $dados

        ]);
    }


//-------FALECIMENTOS-------//
    public function falecimentos()
    {

        $dados = Falecimento::withoutTrashed()->paginate(10);

        foreach ($dados as $dado) {

            $cod_pessoa = Pessoa::find($dado->cod_pessoa);
            $dado->setAttribute('pessoa', $cod_pessoa);

            $cod_cemiterio = Pessoa::find($dado->cod_cemiterio);
            $dado->setAttribute('cemiterio', $cod_cemiterio);

        }

        return view('authenticated.pessoal.falecimentos.falecimentos', [
            'dados' => $dados
        ]);
    }

    public function searchFalecimentos(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Falecimento::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.falecimentos.falecimentos', [
            'dados' => $dados
        ]);
    }

    public function createFalecimentos(Request $request)
    {

        $dados = new Falecimento();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos cadastrado com sucesso!');
    }

    public function editFalecimentos($id)
    {

        $dados = Falecimento::find($id);

        return view('authenticated.pessoal.falecimentos.newFalecimentos', [
            '$dados' => $dados
        ]);
    }

    public function updateFalecimentos(Request $request)
    {
        $dados = Falecimento::find($request->id);
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos editado com sucesso!');
    }

    public function deleteFalecimentos($id)
    {
        $dados = Falecimento::find($id);

        if (!$dados) {
            return redirect('/pessoal/falecimentos')->with('error', 'Falecimentos não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/falecimentos')->with('success', 'Falecimentos excluído com sucesso.');
    }

    public function falecimentosNew(){

        $dados= Falecimento::all();

        return view('authenticated.pessoal.falecimentos.newFalecimentos', [
            'dados' => $dados

        ]);
    }
    //-- Transferencia
    public function transferencia()
    {

        $dados = Transferencia::withoutTrashed()->paginate(10);

        foreach ($dados as $dado) {

            $cod_pessoa = Pessoa::find($dado->cod_pessoa);
            $dado->setAttribute('pessoa', $cod_pessoa);

            $cod_provinciaori = Provincia::find($dado->cod_provinciaori);
            $dado->setAttribute('cod_provinciaori', $cod_provinciaori);

            $cod_comunidadeori = Comunidade::find($dado->cod_comunidadeori);
            $dado->setAttribute('cod_comunidadeori', $cod_comunidadeori);

            $cod_provinciades = Provincia::find($dado->cod_provinciades);
            $dado->setAttribute('cod_provinciades', $cod_provinciades);

            $cod_comunidadedes = Comunidade::find($dado->cod_comunidadedes);
            $dado->setAttribute('cod_comunidadedes', $cod_comunidadedes);

        }

        return view('authenticated.pessoal.transferencia.transferencia', [
            'dados' => $dados
        ]);
    }

    public function searchTransferencia(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Transferencia::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.transferencia.transferencia', [
            'dados' => $dados
        ]);
    }

    public function createTransferencia(Request $request)
    {

        $dados = new Transferencia();
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia cadastrado com sucesso!');
    }

    public function editTransferencia($id)
    {

        $dados = Transferencia::find($id);

        return view('authenticated.pessoal.transferencia.newTransferencia', [
            '$dados' => $dados
        ]);
    }

    public function updateTransferencia(Request $request)
    {
        $dados = Transferencia::find($request->id);
        $dados->cod_pessoa_id = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia editado com sucesso!');
    }

    public function deleteTransferencia($id)
    {
        $dados = Transferencia::find($id);

        if (!$dados) {
            return redirect('/pessoal/transferencia')->with('error', 'Transferencia não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia excluído com sucesso.');
    }

    public function transferenciaNew(){

        $dados= Transferencia::all();

        return view('authenticated.pessoal.transferencia.newTransferencia', [
            'dados' => $dados

        ]);
    }

    // PROVINCIAS ------------------------------------------------------------------------------------------------------------------

    public function pessoas()
    {
        $dados = Pessoa::with(['falecimento', 'egresso', 'cidade', 'diocese', 'provincia'])
                        ->withoutTrashed()
                        ->orderBy('sobrenome', 'asc')
                        ->paginate(10);

        foreach ($dados as $pessoa) {

                if ($pessoa->egresso) {
                    $pessoa->situacao = 2;
                } elseif ($pessoa->falecimento) {
                    $pessoa->situacao = 3;
                }

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

    //----- Parentes ----- ///
    // public function parentes()
    // {

    //     $dados = Parente::withoutTrashed()->paginate(10);

    //     foreach ($dados as $dado) {

    //         $pessoa = Pessoa::find($dado->cod_pessoa_id);
    //         $dado->setAttribute('pessoa', $pessoa);

    //         $parentesco = Parentesco::find($dado->cod_parentesco_id);
    //         $dado->setAttribute('parentesco', $parentesco);

    //         $cidade = Cidade::find($dado->cod_cidade_id);
    //         $dado->setAttribute('cidade', $cidade);

    //     }

    //     return view('authenticated.pessoal.pessoas.parentes.parentes', [
    //         'dados' => $dados
    //     ]);
    // }

    // public function searchParentes(Request $request)
    // {

    //     $searchCriteria = [
    //         'descricao' => $request->input('descricao')
    //     ];


    //     $dados = Transferencia::search($searchCriteria)->paginate(10);

    //     return view('authenticated.pessoal.transferencia.transferencia', [
    //         'dados' => $dados
    //     ]);
    // }

    // public function createParentes(Request $request)
    // {

    //     $dados = new Transferencia();
    //     $dados->cod_pessoa_id = $request->cod_pessoa_id;
    //     $dados->data_saida = $request->data_saida;
    //     $dados->data_readmissao = $request->data_readmissao;
    //     $dados->detalhes = $request->detalhes;
    //     $dados->save();

    //     return redirect('/pessoal/transferencia')->with('success', 'Transferencia cadastrado com sucesso!');
    // }

    // public function editParentes($id)
    // {

    //     $dados = Transferencia::find($id);

    //     return view('authenticated.pessoal.transferencia.newTransferencia', [
    //         '$dados' => $dados
    //     ]);
    // }

    // public function updateParentes(Request $request)
    // {
    //     $dados = Transferencia::find($request->id);
    //     $dados->cod_pessoa_id = $request->cod_pessoa_id;
    //     $dados->data_saida = $request->data_saida;
    //     $dados->data_readmissao = $request->data_readmissao;
    //     $dados->detalhes = $request->detalhes;
    //     $dados->save();

    //     return redirect('/pessoal/transferencia')->with('success', 'Transferencia editado com sucesso!');
    // }

    // public function deleteParentes($id)
    // {
    //     $dados = Transferencia::find($id);

    //     if (!$dados) {
    //         return redirect('/pessoal/transferencia')->with('error', 'Transferencia não encontrado.');
    //     }

    //     $dados->delete();

    //     return redirect('/pessoal/transferencia')->with('success', 'Transferencia excluído com sucesso.');
    // }

    // public function parentesNew(){

    //     $dados= Transferencia::all();

    //     return view('authenticated.pessoal.transferencia.newTransferencia', [
    //         'dados' => $dados

    //     ]);
    // }
    //---------
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

    public function pessoasParentes(Request $request)
    {
        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Parente::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

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
            'provincias' => []
        ]);
    }

    public function pessoasFormacoes(Request $request)
    {

        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Formacao::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

        foreach ($dados as $dado) {

            $tipo_formacao = TipoFormReligiosa::find($dado->cod_tipo_formacao_id);
            $dado->setAttribute('tipo_formacao', $tipo_formacao);

            $comunidade = Comunidade::find($dado->cod_comunidade_id);
            $dado->setAttribute('comunidade', $comunidade);

            $cidade = Cidade::find($dado->cod_cidade_id);
            $dado->setAttribute('cidade', $cidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.formacoes.formacoes', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'provincias' => []
        ]);
    }

    public function pessoasFuncoes(Request $request)
    {

        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Funcao::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

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
            'provincias' => []
        ]);
    }

    public function pessoasHabilidades(Request $request)
    {

        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Habilidade::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

        foreach ($dados as $dado) {

            $tipo_habilidade = TipoHabilidade::find($dado->cod_tipo_habilidade_id);
            $dado->setAttribute('tipo_habilidade', $tipo_habilidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.habilidades.habilidades', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'provincias' => []
        ]);
    }

    public function pessoasHistorico(Request $request)
    {

        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Historico::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.historico.historico', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'provincias' => []
        ]);
    }

    public function pessoasItinerarios(Request $request)
    {

        $id = $request->query('id');
        $pessoa = Pessoa::find($request->id);
        $dados = Itinerario::withoutTrashed()->where('cod_pessoa_id', $request->id)->paginate(10);

        foreach ($dados as $dado) {

            $comunidade_atual = Comunidade::find($dado->cod_comunidade_atual_id);
            $dado->setAttribute('comunidade_atual', $comunidade_atual);

            $comunidade_anterior = Comunidade::find($dado->cod_comunidade_anterior_id);
            $dado->setAttribute('comunidade_anterior', $comunidade_anterior);

            $comunidade_destino = Comunidade::find($dado->cod_comunidade_destino_id);
            $dado->setAttribute('comunidade_destino', $comunidade_destino);

        }

        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.itinerarios.itinerarios', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'provincias' => []
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

    public function searchAdmissao(Request $request)
    {

        $searchAdmissao = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Pessoa::search($searchAdmissao)->paginate(10);

        return view('authenticated.pessoal.admissao.admissao', [
            'dados' => $dados
        ]);
    }


}
