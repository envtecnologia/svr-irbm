<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\Area;
use App\Models\Cadastros\Doenca;
use App\Models\Cadastros\Origem;
use App\Models\Cadastros\Parentesco;
use App\Models\Cadastros\Profissao;
use App\Models\Cadastros\Situacao;
use App\Models\Cadastros\TipoArquivo;
use App\Models\Cadastros\TipoAtividade;
use App\Models\Cadastros\TipoCurso;
use App\Models\Cadastros\TipoFormReligiosa;
use App\Models\Cadastros\TipoFuncao;
use App\Models\Cadastros\TipoHabilidade;
use App\Models\Cadastros\TipoInstituicao;
use App\Models\Cadastros\TipoObra;
use App\Models\Cadastros\TipoPessoa;
use App\Models\Cadastros\TipoTitulo;
use App\Models\Cadastros\TipoTratamento;
use Illuminate\Http\Request;

class CadastrosController extends Controller
{
    // AREAS ---------------------------------------------------------------------------------------------------
    public function areas()
    {

        $dados = Area::withoutTrashed()->paginate(10);

        return view('authenticated.cadastros.areas.areas', [
            'dados' => $dados
        ]);
    }

    public function searchAreas(Request $request)
    {
        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];
        $dados = Area::search($searchCriteria)->paginate(10);

        return view('authenticated.cadastros.areas.areas', [
            'dados' => $dados
        ]);
    }

    public function createArea(Request $request)
    {

        $area = new Area();
        $area->descricao = $request->descricao;
        $area->detalhes = $request->detalhes;
        $area->save();

        return redirect('/cadastros/areas')->with('success', 'Area cadastrada com sucesso!');
    }

    public function editArea($id)
    {

        $area = Area::find($id);

        return view('authenticated.cadastros.areas.newArea', [
            'area' => $area
        ]);
    }

    public function updateArea(Request $request)
    {
        $area = Area::find($request->id);
        $area->descricao = $request->descricao;
        $area->detalhes = $request->detalhes;
        $area->save();

        return redirect('/cadastros/areas')->with('success', 'Area editada com sucesso!');
    }

    public function deleteArea($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return redirect('/cadastros/areas')->with('error', 'Área não encontrada.');
        }

        $area->delete();

        return redirect('/cadastros/areas')->with('success', 'Área excluída com sucesso.');
    }

    // DOENCAS ---------------------------------------------------------------------------------------------------

    public function doencas()
    {

        $dados = Doenca::withoutTrashed()->paginate(10);

        return view('authenticated.cadastros.doencas.doencas', [
            'dados' => $dados
        ]);
    }

    public function searchDoencas(Request $request)
    {
        $searchTerm = $request->input('search');
        $dados = Doenca::search($searchTerm)->get();

        return view('authenticated.cadastros.doencas.doencas', [
            'dados' => $dados
        ]);
    }

    public function createDoenca(Request $request)
    {

        $dados = new Doenca();
        $dados->descricao = $request->descricao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/cadastros/doencas')->with('success', 'Doença cadastrada com sucesso!');
    }

    public function editDoenca($id)
    {

        $dados = Doenca::find($id);

        return view('authenticated.cadastros.doencas.newDoenca', [
            'dados' => $dados
        ]);
    }

    public function updateDoenca(Request $request)
    {
        $dados = Doenca::find($request->id);
        $dados->descricao = $request->descricao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/cadastros/doencas')->with('success', 'Doença editada com sucesso!');
    }

    public function deleteDoenca($id)
    {
        $dados = Doenca::find($id);

        if (!$dados) {
            return redirect('/cadastros/doencas')->with('error', 'Doença não encontrada.');
        }

        $dados->delete();

        return redirect('/cadastros/doencas')->with('success', 'Doença excluída com sucesso.');
    }

   // ORIGENS ---------------------------------------------------------------------------------------------------

   public function origens()
   {

       $dados = Origem::withoutTrashed()->paginate(10);

       return view('authenticated.cadastros.origens.origens', [
           'dados' => $dados
       ]);
   }

   public function searchOrigens(Request $request)
   {
       $searchTerm = $request->input('search');
       $dados = Origem::search($searchTerm)->get();

       return view('authenticated.cadastros.origens.origens', [
           'dados' => $dados
       ]);
   }

   public function createOrigem(Request $request)
   {

       $dados = new Origem();
       $dados->descricao = $request->descricao;
       $dados->save();

       return redirect('/cadastros/origens')->with('success', 'Origem cadastrada com sucesso!');
   }

   public function editOrigem($id)
   {

       $dados = Origem::find($id);

       return view('authenticated.cadastros.origens.newOrigem', [
           'dados' => $dados
       ]);
   }

   public function updateOrigem(Request $request)
   {
       $dados = Origem::find($request->id);
       $dados->descricao = $request->descricao;
       $dados->save();

       return redirect('/cadastros/origens')->with('success', 'Origem editada com sucesso!');
   }

   public function deleteOrigem($id)
   {
       $dados = Origem::find($id);

       if (!$dados) {
           return redirect('/cadastros/origens')->with('error', 'Origem não encontrada.');
       }

       $dados->delete();

       return redirect('/cadastros/origens')->with('success', 'Origem excluída com sucesso.');
   }

   // PARENTESCOS ---------------------------------------------------------------------------------------------------

   public function parentescos()
   {

       $dados = Parentesco::withoutTrashed()->paginate(10);

       return view('authenticated.cadastros.parentescos.parentescos', [
           'dados' => $dados
       ]);
   }

   public function searchParentescos(Request $request)
   {
       $searchTerm = $request->input('search');
       $dados = Parentesco::search($searchTerm)->get();

       return view('authenticated.cadastros.parentescos.parentescos', [
           'dados' => $dados
       ]);
   }

   public function createParentesco(Request $request)
   {

       $dados = new Parentesco();
       $dados->descricao = $request->descricao;
       $dados->save();

       return redirect('/cadastros/parentescos')->with('success', 'Parentesco cadastrado com sucesso!');
   }

   public function editParentesco($id)
   {

       $dados = Parentesco::find($id);

       return view('authenticated.cadastros.parentescos.newParentesco', [
           'dados' => $dados
       ]);
   }

   public function updateParentesco(Request $request)
   {
       $dados = Parentesco::find($request->id);
       $dados->descricao = $request->descricao;
       $dados->save();

       return redirect('/cadastros/parentescos')->with('success', 'Parentesco editado com sucesso!');
   }

   public function deleteParentesco($id)
   {
       $dados = Parentesco::find($id);

       if (!$dados) {
           return redirect('/cadastros/parentescos')->with('error', 'Parentesco não encontrado.');
       }

       $dados->delete();

       return redirect('/cadastros/parentescos')->with('success', 'Parentesco excluído com sucesso.');
   }

    // PROFISSAO ---------------------------------------------------------------------------------------------------

    public function profissoes()
    {

        $dados = Profissao::withoutTrashed()->paginate(10);

        return view('authenticated.cadastros.profissoes.profissoes', [
            'dados' => $dados
        ]);
    }

    public function searchProfissoes(Request $request)
    {
        $searchCriteria = [
            'descricao' => $request->input('descricao')
        ];

        $dados = Profissao::search($searchCriteria)->get();

        return view('authenticated.cadastros.profissoes.profissoes', [
            'dados' => $dados
        ]);
    }

    public function createProfissao(Request $request)
    {

        $dados = new Profissao();
        $dados->descricao = $request->descricao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/cadastros/profissoes')->with('success', 'Profissão cadastrada com sucesso!');
    }

    public function editProfissao($id)
    {

        $dados = Profissao::find($id);

        return view('authenticated.cadastros.profissoes.newProfissao', [
            'dados' => $dados
        ]);
    }

    public function updateProfissao(Request $request)
    {
        $dados = Profissao::find($request->id);
        $dados->descricao = $request->descricao;
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect('/cadastros/profissoes')->with('success', 'Profissão editada com sucesso!');
    }

    public function deleteProfissao($id)
    {
        $dados = Profissao::find($id);

        if (!$dados) {
            return redirect('/cadastros/profissoes')->with('error', 'Profissão não encontrada.');
        }

        $dados->delete();

        return redirect('/cadastros/profissoes')->with('success', 'Profissão excluída com sucesso.');
    }

    // SITUACOES ---------------------------------------------------------------------------------------------------

    public function situacoes()
    {

        $dados = Situacao::withoutTrashed()->paginate(10);

        return view('authenticated.cadastros.situacoes.situacoes', [
            'dados' => $dados
        ]);
    }

    public function searchSituacoes(Request $request)
    {
        $searchTerm = $request->input('search');
        $dados = Situacao::search($searchTerm)->get();

        return view('authenticated.cadastros.situacoes.situacoes', [
            'dados' => $dados
        ]);
    }

    public function createSituacao(Request $request)
    {

        $dados = new Situacao();
        $dados->descricao = $request->descricao;
        $dados->save();

        return redirect('/cadastros/situacoes')->with('success', 'Situação cadastrada com sucesso!');
    }

    public function editSituacao($id)
    {

        $dados = Situacao::find($id);

        return view('authenticated.cadastros.situacoes.newSituacao', [
            'dados' => $dados
        ]);
    }

    public function updateSituacao(Request $request)
    {
        $dados = Situacao::find($request->id);
        $dados->descricao = $request->descricao;
        $dados->save();

        return redirect('/cadastros/situacoes')->with('success', 'Situação editada com sucesso!');
    }

    public function deleteSituacao($id)
    {
        $dados = Situacao::find($id);

        if (!$dados) {
            return redirect('/cadastros/situacoes')->with('error', 'Situação não encontrada.');
        }

        $dados->delete();

        return redirect('/cadastros/situacoes')->with('success', 'Situação excluída com sucesso.');
    }

        // TIPOS DE ARQUIVOS ---------------------------------------------------------------------------------------------------

        public function tipo_arquivos()
        {

            $dados = TipoArquivo::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_arquivos.tipo_arquivos', [
                'dados' => $dados
            ]);
        }

        public function searchTipoArquivos(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoArquivo::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_arquivos.tipo_arquivos', [
                'dados' => $dados
            ]);
        }

        public function createTipoArquivo(Request $request)
        {

            $dados = new TipoArquivo();
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_arquivos')->with('success', 'Tipo de arquivo cadastrado com sucesso!');
        }

        public function editTipoArquivo($id)
        {

            $dados = TipoArquivo::find($id);

            return view('authenticated.cadastros.tipo_arquivos.newTipoArquivo', [
                'dados' => $dados
            ]);
        }

        public function updateTipoArquivo(Request $request)
        {
            $dados = TipoArquivo::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_arquivos')->with('success', 'Tipo de arquivo editado com sucesso!');
        }

        public function deleteTipoArquivo($id)
        {
            $dados = TipoArquivo::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_arquivos')->with('error', 'Tipo de arquivo não encontrado.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_arquivos')->with('success', 'Tipo de arquivo excluído com sucesso.');
        }

        // TIPOS DE ATIVIDADES ---------------------------------------------------------------------------------------------------

        public function tipo_atividades()
        {

            $dados = TipoAtividade::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_atividades.tipo_atividades', [
                'dados' => $dados
            ]);
        }

        public function searchTipoAtividades(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoAtividade::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_atividades.tipo_atividades', [
                'dados' => $dados
            ]);
        }

        public function createTipoAtividade(Request $request)
        {

            $dados = new TipoAtividade();
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_atividades')->with('success', 'Tipo de atividade cadastrado com sucesso!');
        }

        public function editTipoAtividade($id)
        {

            $dados = TipoAtividade::find($id);

            return view('authenticated.cadastros.tipo_atividades.newTipoAtividade', [
                'dados' => $dados
            ]);
        }

        public function updateTipoAtividade(Request $request)
        {
            $dados = TipoAtividade::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_atividades')->with('success', 'Tipo de atividade editado com sucesso!');
        }

        public function deleteTipoAtividade($id)
        {
            $dados = TipoAtividade::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_atividades')->with('error', 'Tipo de atividade não encontrado.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_atividades')->with('success', 'Tipo de atividade excluído com sucesso.');
        }

        // TIPOS DE CURSOS ---------------------------------------------------------------------------------------------------

        public function tipo_cursos()
        {

            $dados = TipoCurso::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_cursos.tipo_cursos', [
                'dados' => $dados
            ]);
        }

        public function searchTipoCursos(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoCurso::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_cursos.tipo_cursos', [
                'dados' => $dados
            ]);
        }

        public function createTipoCurso(Request $request)
        {

            $dados = new TipoCurso();
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_cursos')->with('success', 'Tipo de curso cadastrado com sucesso!');
        }

        public function editTipoCurso($id)
        {

            $dados = TipoCurso::find($id);

            return view('authenticated.cadastros.tipo_cursos.newTipoCurso', [
                'dados' => $dados
            ]);
        }

        public function updateTipoCurso(Request $request)
        {
            $dados = TipoCurso::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_cursos')->with('success', 'Tipo de curso editado com sucesso!');
        }

        public function deleteTipoCurso($id)
        {
            $dados = TipoCurso::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_cursos')->with('error', 'Tipo de curso não encontrado.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_cursos')->with('success', 'Tipo de curso excluído com sucesso.');
        }

        // TIPOS DE FORM RELIGIOSA ---------------------------------------------------------------------------------------------------

        public function tipo_formReligiosa()
        {

            $dados = TipoFormReligiosa::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_formReligiosa.tipo_formReligiosa', [
                'dados' => $dados
            ]);
        }

        public function searchTipoFormReligiosa(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoFormReligiosa::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_formReligiosa.tipo_formReligiosa', [
                'dados' => $dados
            ]);
        }

        public function createTipoFormReligiosa(Request $request)
        {

            $dados = new TipoFormReligiosa();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_formReligiosa')->with('success', 'Tipo de form. religiosa cadastrada com sucesso!');
        }

        public function editTipoFormReligiosa($id)
        {

            $dados = TipoFormReligiosa::find($id);

            return view('authenticated.cadastros.tipo_formReligiosa.newTipoFormReligiosa', [
                'dados' => $dados
            ]);
        }

        public function updateTipoFormReligiosa(Request $request)
        {
            $dados = TipoFormReligiosa::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_formReligiosa')->with('success', 'Tipo de form. religiosa editada com sucesso!');
        }

        public function deleteTipoFormReligiosa($id)
        {
            $dados = TipoFormReligiosa::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_formReligiosa')->with('error', 'Tipo de form. religiosa não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_formReligiosa')->with('success', 'Tipo de form. religiosa excluída com sucesso.');
        }

        // TIPOS DE FUNCOES ---------------------------------------------------------------------------------------------------

        public function tipo_funcao()
        {

            $dados = TipoFuncao::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_funcao.tipo_funcao', [
                'dados' => $dados
            ]);
        }

        public function searchTipoFuncao(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoFuncao::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_funcao.tipo_funcao', [
                'dados' => $dados
            ]);
        }

        public function createTipoFuncao(Request $request)
        {

            $dados = new TipoFuncao();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_funcao')->with('success', 'Tipo de função cadastrada com sucesso!');
        }

        public function editTipoFuncao($id)
        {

            $dados = TipoFuncao::find($id);

            return view('authenticated.cadastros.tipo_funcao.newTipoFuncao', [
                'dados' => $dados
            ]);
        }

        public function updateTipoFuncao(Request $request)
        {
            $dados = TipoFuncao::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_funcao')->with('success', 'Tipo de função editada com sucesso!');
        }

        public function deleteTipoFuncao($id)
        {
            $dados = TipoFuncao::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_funcao')->with('error', 'Tipo de função não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_funcao')->with('success', 'Tipo de função excluída com sucesso.');
        }

        // TIPOS DE HABILIDADES ---------------------------------------------------------------------------------------------------

        public function tipo_habilidades()
        {

            $dados = TipoHabilidade::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_habilidades.tipo_habilidades', [
                'dados' => $dados
            ]);
        }

        public function searchTipoHabilidade(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoHabilidade::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_habilidades.tipo_habilidades', [
                'dados' => $dados
            ]);
        }

        public function createTipoHabilidade(Request $request)
        {

            $dados = new TipoHabilidade();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_habilidades')->with('success', 'Tipo de habilidade cadastrada com sucesso!');
        }

        public function editTipoHabilidade($id)
        {

            $dados = TipoHabilidade::find($id);

            return view('authenticated.cadastros.tipo_habilidades.newTipoHabilidade', [
                'dados' => $dados
            ]);
        }

        public function updateTipoHabilidade(Request $request)
        {
            $dados = TipoHabilidade::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_habilidades')->with('success', 'Tipo de habilidade editada com sucesso!');
        }

        public function deleteTipoHabilidade($id)
        {
            $dados = TipoHabilidade::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_habilidades')->with('error', 'Tipo de habilidade não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_habilidades')->with('success', 'Tipo de habilidade excluída com sucesso.');
        }

        // TIPOS DE INSTITUICOES ---------------------------------------------------------------------------------------------------

        public function tipo_instituicoes()
        {

            $dados = TipoInstituicao::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_instituicoes.tipo_instituicoes', [
                'dados' => $dados
            ]);
        }

        public function searchTipoInstituicao(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoInstituicao::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_instituicoes.tipo_instituicoes', [
                'dados' => $dados
            ]);
        }

        public function createTipoInstituicao(Request $request)
        {

            $dados = new TipoInstituicao();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_instituicoes')->with('success', 'Tipo de instituição cadastrada com sucesso!');
        }

        public function editTipoInstituicao($id)
        {

            $dados = TipoInstituicao::find($id);

            return view('authenticated.cadastros.tipo_instituicoes.newTipoInstituicao', [
                'dados' => $dados
            ]);
        }

        public function updateTipoInstituicao(Request $request)
        {
            $dados = TipoInstituicao::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_instituicoes')->with('success', 'Tipo de instituição editada com sucesso!');
        }

        public function deleteTipoInstituicao($id)
        {
            $dados = TipoInstituicao::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_instituicoes')->with('error', 'Tipo de instituição não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_instituicoes')->with('success', 'Tipo de instituição excluída com sucesso.');
        }

        // TIPOS DE OBRAS ---------------------------------------------------------------------------------------------------

        public function tipo_obras()
        {

            $dados = TipoObra::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_obras.tipo_obras', [
                'dados' => $dados
            ]);
        }

        public function searchTipoObra(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoObra::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_obras.tipo_obras', [
                'dados' => $dados
            ]);
        }

        public function createTipoObra(Request $request)
        {

            $dados = new TipoObra();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_obras')->with('success', 'Tipo de obra cadastrada com sucesso!');
        }

        public function editTipoObra($id)
        {

            $dados = TipoObra::find($id);

            return view('authenticated.cadastros.tipo_obras.newTipoObra', [
                'dados' => $dados
            ]);
        }

        public function updateTipoObra(Request $request)
        {
            $dados = TipoObra::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_obras')->with('success', 'Tipo de obra editada com sucesso!');
        }

        public function deleteTipoObra($id)
        {
            $dados = TipoObra::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_obras')->with('error', 'Tipo de obra não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_obras')->with('success', 'Tipo de obra excluída com sucesso.');
        }

        // TIPOS DE PESSOAS ---------------------------------------------------------------------------------------------------

        public function tipo_pessoas()
        {

            $dados = TipoPessoa::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_pessoas.tipo_pessoas', [
                'dados' => $dados
            ]);
        }

        public function searchTipoPessoa(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoPessoa::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_pessoas.tipo_pessoas', [
                'dados' => $dados
            ]);
        }

        public function createTipoPessoa(Request $request)
        {

            $dados = new TipoPessoa();
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_pessoas')->with('success', 'Tipo de pessoa cadastrada com sucesso!');
        }

        public function editTipoPessoa($id)
        {

            $dados = TipoPessoa::find($id);

            return view('authenticated.cadastros.tipo_pessoas.newTipoPessoa', [
                'dados' => $dados
            ]);
        }

        public function updateTipoPessoa(Request $request)
        {
            $dados = TipoPessoa::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->save();

            return redirect('/cadastros/tipo_pessoas')->with('success', 'Tipo de pessoa editada com sucesso!');
        }

        public function deleteTipoPessoa($id)
        {
            $dados = TipoPessoa::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_pessoas')->with('error', 'Tipo de pessoa não encontrada.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_pessoas')->with('success', 'Tipo de pessoa excluída com sucesso.');
        }

        // TIPOS DE TRATAMENTO ---------------------------------------------------------------------------------------------------

        public function tipo_tratamento()
        {

            $dados = TipoTratamento::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_tratamento.tipo_tratamento', [
                'dados' => $dados
            ]);
        }

        public function searchTipoTratamento(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoTratamento::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_tratamento.tipo_tratamento', [
                'dados' => $dados
            ]);
        }

        public function createTipoTratamento(Request $request)
        {

            $dados = new TipoTratamento();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_tratamento')->with('success', 'Tipo de tratamento cadastrado com sucesso!');
        }

        public function editTipoTratamento($id)
        {

            $dados = TipoTratamento::find($id);

            return view('authenticated.cadastros.tipo_tratamento.newTipoTratamento', [
                'dados' => $dados
            ]);
        }

        public function updateTipoTratamento(Request $request)
        {
            $dados = TipoTratamento::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_tratamento')->with('success', 'Tipo de tratamento editado com sucesso!');
        }

        public function deleteTipoTratamento($id)
        {
            $dados = TipoTratamento::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_tratamento')->with('error', 'Tipo de tratamento não encontrado.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_tratamento')->with('success', 'Tipo de tratamento excluído com sucesso.');
        }

        // TIPOS DE TITULOS ---------------------------------------------------------------------------------------------------

        public function tipo_titulo()
        {

            $dados = TipoTitulo::withoutTrashed()->paginate(10);

            return view('authenticated.cadastros.tipo_titulo.tipo_titulo', [
                'dados' => $dados
            ]);
        }

        public function searchTipoTitulo(Request $request)
        {
            $searchTerm = $request->input('search');
            $dados = TipoTitulo::search($searchTerm)->get();

            return view('authenticated.cadastros.tipo_titulo.tipo_titulo', [
                'dados' => $dados
            ]);
        }

        public function createTipoTitulo(Request $request)
        {

            $dados = new TipoTitulo();
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_titulo')->with('success', 'Tipo de título cadastrado com sucesso!');
        }

        public function editTipoTitulo($id)
        {

            $dados = TipoTitulo::find($id);

            return view('authenticated.cadastros.tipo_titulo.newTipoTitulo', [
                'dados' => $dados
            ]);
        }

        public function updateTipoTitulo(Request $request)
        {
            $dados = TipoTitulo::find($request->id);
            $dados->descricao = $request->descricao;
            $dados->detalhes = $request->detalhes;
            $dados->save();

            return redirect('/cadastros/tipo_titulo')->with('success', 'Tipo de título editado com sucesso!');
        }

        public function deleteTipoTitulo($id)
        {
            $dados = TipoTitulo::find($id);

            if (!$dados) {
                return redirect('/cadastros/tipo_titulo')->with('error', 'Tipo de título não encontrado.');
            }

            $dados->delete();

            return redirect('/cadastros/tipo_titulo')->with('success', 'Tipo de título excluído com sucesso.');
        }





}
