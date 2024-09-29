<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\Origem;
use App\Models\Cadastros\TipoPessoa;
use App\Models\Cidade;
use App\Models\Controle\Capitulo;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Estado;
use App\Models\Pais;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Egresso;
use App\Models\Pessoal\Falecimento;
use App\Models\Pessoal\Transferencia;
use App\Models\Provincia;
use App\Models\Raca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $pessoas = Pessoa::withoutTrashed()->get();

        return view(
            'authenticated.pessoal.egressos.newEgressos',
            compact('dados', 'pessoas')
        );
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

    public function egressosNew()
    {

        $pessoas = Pessoa::withoutTrashed()->get();

        // dd($dados);

        return view(
            'authenticated.pessoal.egressos.newEgressos',
            compact('pessoas')

        );
    }


    //-------FALECIMENTOS-------//
    public function falecimentos()
    {

        $dados = Falecimento::with('pessoa')->withoutTrashed()->paginate(10);

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
        $pessoas = Pessoa::withoutTrashed()->get();

        return view(
            'authenticated.pessoal.falecimentos.newFalecimentos',
            compact(
                'dados',
                'pessoas'
            )
        );
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

    public function falecimentosNew()
    {

        $pessoas = Pessoa::withoutTrashed()->get();

        return view(
            'authenticated.pessoal.falecimentos.newFalecimentos',
            compact('pessoas')

        );
    }
    //-- Transferencia
    public function transferencia()
    {

        $dados = Transferencia::with(['pessoa', 'com_origem', 'com_des', 'prov_origem', 'prov_des', 'pessoa.provincia'])
            ->withoutTrashed()
            ->orderBy('data_transferencia', 'desc')
            ->paginate(10);

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
        $dados->cod_pessoa = $request->cod_pessoa_id;
        $dados->cod_provinciaori = $request->cod_provinciaori;
        $dados->cod_comunidadeori = $request->cod_comunidadeori;
        $dados->cod_provinciades = $request->cod_provinciades;
        $dados->cod_comunidadedes = $request->cod_comunidadedes;
        $dados->data_transferencia = $request->data_transferencia;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia cadastrada com sucesso!');
    }

    public function editTransferencia($id)
    {

        $dados = Transferencia::with('pessoa')->find($id);
        $pessoas = Pessoa::withoutTrashed()->get();
        $provincias = Provincia::withoutTrashed()->get();
        $comunidades = Comunidade::withoutTrashed()->get();

        return view(
            'authenticated.pessoal.transferencia.newTransferencia',
            compact('dados', 'pessoas', 'provincias', 'comunidades')
        );
    }

    public function updateTransferencia(Request $request)
    {
        $dados = Transferencia::find($request->id);
        $dados->cod_pessoa = $request->cod_pessoa_id;
        $dados->cod_provinciaori = $request->cod_provinciaori;
        $dados->cod_comunidadeori = $request->cod_comunidadeori;
        $dados->cod_provinciades = $request->cod_provinciades;
        $dados->cod_comunidadedes = $request->cod_comunidadedes;
        $dados->data_transferencia = $request->data_transferencia;
        $dados->save();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia editada com sucesso!');
    }

    public function deleteTransferencia($id)
    {
        $dados = Transferencia::find($id);

        if (!$dados) {
            return redirect('/pessoal/transferencia')->with('error', 'Transferencia não encontrada.');
        }

        $dados->delete();

        return redirect('/pessoal/transferencia')->with('success', 'Transferencia excluída com sucesso.');
    }

    public function transferenciaNew()
    {

        $pessoas = Pessoa::orderBy('nome')->withoutTrashed()->get();
        $provincias = Provincia::orderBy('descricao')->withoutTrashed()->get();
        $comunidades = Comunidade::orderBy('descricao')->withoutTrashed()->get();

        return view(
            'authenticated.pessoal.transferencia.newTransferencia',
            compact('pessoas', 'provincias', 'comunidades')
        );
    }

    // PESSOAS ------------------------------------------------------------------------------------------------------------------

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

    public function storePessoa(Request $request)
    {

        $dados = new Pessoa();
        $dados->cod_provincia_id = $request->input('cod_provincia_id');
        $dados->cod_tipopessoa_id = $request->input('cod_tipopessoa_id');
        $dados->cod_comunidade_id = $request->input('cod_comunidade_id');
        $dados->nome = $request->input('nome');
        $dados->sobrenome = $request->input('sobrenome');
        $dados->opcao = $request->input('opcao');
        $dados->religiosa = $request->input('religiosa');
        $dados->endereco = $request->input('endereco');
        // $dados->pais = $request->input('pais');
        // $dados->estado = $request->input('estado');
        $dados->cod_local_id = $request->input('cod_local_id');
        $dados->cod_nacionalidade_id = $request->input('cod_nacionalidade_id');
        $dados->cod_raca_id = $request->input('cod_raca_id');
        $dados->cod_origem_id = $request->input('cod_origem_id');
        $dados->gruposanguineo = $request->input('gruposanguineo');
        $dados->rh = $request->input('rh');

        $dados->rg = $request->input('rg');
        $dados->rgorgao = $request->input('rgorgao');
        $dados->rgdata = $request->input('rgdata');
        $dados->cpf = $request->input('cpf');

        $dados->titulo = $request->input('titulo');
        $dados->titulozona = $request->input('titulozona');
        $dados->titulosecao = $request->input('titulosecao');
        $dados->habilitacaonumero = $request->input('habilitacaonumero');
        $dados->habilitacaolocal = $request->input('habilitacaolocal');
        $dados->habilitacaocategoria = $request->input('habilitacaocategoria');
        $dados->habilitacaodata = $request->input('habilitacaodata');
        $dados->inss = $request->input('inss');
        $dados->aposentadoriaorgao = $request->input('aposentadoriaorgao');
        $dados->aposentadoriadata = $request->input('aposentadoriadata');

        $dados->endereco = $request->input('endereco');
        $dados->cep = $request->input('cep');
        $dados->email = $request->input('email');
        $dados->datanascimento = $request->input('datanascimento');
        $dados->aniversario = $request->input('aniversario');
        $dados->telefone1 = $request->input('telefone1');
        $dados->telefone2 = $request->input('telefone2');
        $dados->telefone3 = $request->input('telefone3');

        $dados->datacadastro = Carbon::now()->format('Y-m-d');
        $dados->horacadastro = Carbon::now()->format('H:i');

        if ($request->file('foto')) {
            $file = $request->file('foto');
            $path = $file->store('uploads/pessoas/fotos', 'public');
            $dados->foto = $path;
        }

        $dados->save();

        return redirect('/pessoal/pessoas')->with('success', 'Pessoa cadastrada com sucesso!');
    }

    public function pessoasNew()
    {

        $provincias = Provincia::orderBy('descricao')->get();
        $categorias = TipoPessoa::orderBy('descricao')->get();
        $comunidades = Comunidade::orderBy('descricao')->get();

        $cidades = Cidade::all();
        $paises = Pais::all();
        $estados = Estado::all();

        $racas = Raca::all();
        $origens = Origem::all();

        return view('authenticated.pessoal.pessoas.newPessoa', [
            'paises' => $paises,
            'estados' => $estados,
            'cidades' => $cidades,
            'provincias' => $provincias,
            'categorias' => $categorias,
            'comunidades' => $comunidades,
            'racas' => $racas,
            'origens' => $origens

        ]);
    }

    public function editPessoa($id)
    {

        $dados = Pessoa::where('id', $id)->first();

        $provincias = Provincia::orderBy('descricao')->get();
        $categorias = TipoPessoa::orderBy('descricao')->get();
        $comunidades = Comunidade::orderBy('descricao')->get();

        $paises = Pais::all();
        $estados = Estado::all();
        $cidades = Cidade::all();

        $racas = Raca::all();
        $origens = Origem::all();


        return view('authenticated.pessoal.pessoas.newPessoa', [
            'dados' => $dados,
            'paises' => $paises,
            'estados' => $estados,
            'cidades' => $cidades,
            'provincias' => $provincias,
            'categorias' => $categorias,
            'comunidades' => $comunidades,
            'racas' => $racas,
            'origens' => $origens
        ]);
    }

    public function updatePessoa(Request $request)
    {
        $dados = Pessoa::find($request->id);
        $dados->cod_provincia_id = $request->input('cod_provincia_id');
        $dados->cod_tipopessoa_id = $request->input('cod_tipopessoa_id');
        $dados->cod_comunidade_id = $request->input('cod_comunidade_id');
        $dados->nome = $request->input('nome');
        $dados->sobrenome = $request->input('sobrenome');
        $dados->opcao = $request->input('opcao');
        $dados->religiosa = $request->input('religiosa');
        $dados->endereco = $request->input('endereco');
        // $dados->pais = $request->input('pais');
        // $dados->estado = $request->input('estado');
        $dados->cod_local_id = $request->input('cod_local_id');
        $dados->cod_nacionalidade_id = $request->input('cod_nacionalidade_id');
        $dados->cod_raca_id = $request->input('cod_raca_id');
        $dados->cod_origem_id = $request->input('cod_origem_id');
        $dados->gruposanguineo = $request->input('gruposanguineo');
        $dados->rh = $request->input('rh');

        $dados->rg = $request->input('rg');
        $dados->rgorgao = $request->input('rgorgao');
        $dados->rgdata = $request->input('rgdata');
        $dados->cpf = $request->input('cpf');

        $dados->titulo = $request->input('titulo');
        $dados->titulozona = $request->input('titulozona');
        $dados->titulosecao = $request->input('titulosecao');
        $dados->habilitacaonumero = $request->input('habilitacaonumero');
        $dados->habilitacaolocal = $request->input('habilitacaolocal');
        $dados->habilitacaocategoria = $request->input('habilitacaocategoria');
        $dados->habilitacaodata = $request->input('habilitacaodata');
        $dados->inss = $request->input('inss');
        $dados->aposentadoriaorgao = $request->input('aposentadoriaorgao');
        $dados->aposentadoriadata = $request->input('aposentadoriadata');

        $dados->endereco = $request->input('endereco');
        $dados->cep = $request->input('cep');
        $dados->email = $request->input('email');
        $dados->datanascimento = $request->input('datanascimento');
        $dados->aniversario = $request->input('aniversario');
        $dados->telefone1 = $request->input('telefone1');
        $dados->telefone2 = $request->input('telefone2');
        $dados->telefone3 = $request->input('telefone3');

        $dados->datacadastro = Carbon::now()->format('Y-m-d');
        $dados->horacadastro = Carbon::now()->format('H:i');

        if ($request->hasFile('foto')) {
            // Apaga a imagem anterior, se necessário
            if ($dados->foto) {
                Storage::delete($dados->foto);
            }
            $file = $request->file('foto');
            $path = $file->store('uploads/pessoas/fotos', 'public');
            $path = str_replace('uploads/pessoas/', '', $path);
            $dados->foto = $path;
        }else{
            $dados->foto = $request->input('foto_atual');
        }

        $dados->save();

        return redirect('/pessoal/pessoas')->with('success', 'Pessoa editada com sucesso!');
    }

    public function deletePessoa($id)
    {
        $dados = Pessoa::find($id);

        if (!$dados) {
            return redirect('/pessoal/pessoas')->with('error', 'Pessoa não encontrada.');
        }

        $dados->delete();

        return redirect('/pessoal/pessoas')->with('success', 'Pessoa excluída com sucesso.');
    }


    //    FUNNCTIONS DAS FUNÇÕES DA SEÇÃO PESSOAS

    public function pessoasImprimir($pessoa_id)
    {

        $dados = Pessoa::with(['provincia', 'comunidade'])->where('id', $pessoa_id)->first();

        return view('authenticated.pessoal.pessoas.imprimir', [
            'dados' => $dados,
            'pessoa_id' => $dados->id
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
    /////------ Captulos
    public function Capitulos()
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

    public function searchCapitulos(Request $request)
    {

        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];


        $dados = Egresso::search($searchCriteria)->paginate(10);

        return view('authenticated.pessoal.egressos.egressos', [
            'dados' => $dados
        ]);
    }

    public function createCapitulos(Request $request)
    {

        $dados = new Capitulo();
        $dados->cod_pessoa = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/egressos')->with('success', 'Egressos cadastrado com sucesso!');
    }

    public function editCapitulos($id)
    {
        // Find the first record by ID
        $dados = Capitulo::find($id);
        $pessoas = Pessoa::withoutTrashed()->get();

        return view(
            'authenticated.pessoal.egressos.newEgressos',
            compact('dados', 'pessoas')
        );
    }


    public function updateCapitulos(Request $request)
    {
        $dados = Capitulo::find($request->id);
        $dados->cod_pessoa  = $request->cod_pessoa_id;
        $dados->data_saida = $request->data_saida;
        $dados->data_readmissao = $request->data_readmissao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/pessoal/egressos')->with('success', 'Egressos editado com sucesso!');
    }

    public function deleteCapitulos($id)
    {
        $dados = Egresso::find($id);

        if (!$dados) {
            return redirect('/pessoal/egressos')->with('error', 'Egressos não encontrado.');
        }

        $dados->delete();

        return redirect('/pessoal/egressos')->with('success', 'Egressos excluído com sucesso.');
    }

    public function capitulosNew()
    {

        $pessoas = Pessoa::withoutTrashed()->get();

        // dd($dados);

        return view(
            'authenticated.pessoal.egressos.newEgressos',
            compact('pessoas')

        );
    }
}
