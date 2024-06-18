<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastrosController;
use App\Http\Controllers\ControleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoalController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/auth', [AuthController::class, 'auth']);

// Todas as rotas dentro deste grupo só estarão disponíveis para usuários autenticados
Route::middleware('auth')->group(function () {
    // Geral
    Route::get('/obter-estados/{pais_id}', [UtilsController::class, 'obterEstados']);
    Route::get('/obter-cidades/{estado_id}', [UtilsController::class, 'obterCidades']);
    Route::get('/obter-paroquias/{diocese_id}', [UtilsController::class, 'obterParoquias']);


    // Menu UL Início
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/meus-dados', [UserController::class, 'index']);
    Route::post('/meus-dados/update', [UserController::class, 'update']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    // Menu UL Cadastro Basico
    // AREAS
    Route::get('/cadastros/areas', [CadastrosController::class, 'areas']);
        Route::get('/cadastros/areas/new', function () { return view('authenticated.cadastros.areas.newArea'); })->name('areas.new');
        Route::post('/cadastros/areas/create', [CadastrosController::class, 'createArea'])->name('areas.create');
        Route::delete('/cadastros/area/{id}', [CadastrosController::class, 'deleteArea'])->name('areas.delete');
        Route::get('/cadastros/area/edit/{id}', [CadastrosController::class, 'editArea'])->name('areas.edit');
        Route::post('/cadastros/area/update', [CadastrosController::class, 'updateArea'])->name('areas.update');
        Route::get('/search/areas', [CadastrosController::class, 'searchAreas'])->name('searchAreas');

    // DOENÇAS
    Route::get('/cadastros/doencas', [CadastrosController::class, 'doencas']);
        Route::get('/cadastros/doencas/new', function () { return view('authenticated.cadastros.doencas.newDoenca'); })->name('doencas.new');
        Route::post('/cadastros/doencas/create', [CadastrosController::class, 'createDoenca'])->name('doencas.create');
        Route::delete('/cadastros/doenca/{id}', [CadastrosController::class, 'deleteDoenca'])->name('doencas.delete');
        Route::get('/cadastros/doenca/edit/{id}', [CadastrosController::class, 'editDoenca'])->name('doencas.edit');
        Route::post('/cadastros/doenca/update', [CadastrosController::class, 'updateDoenca'])->name('doencas.update');
        Route::post('/search/doencas', [CadastrosController::class, 'searchDoencas'])->name('searchDoencas');
    // ORIGENS
    Route::get('/cadastros/origens', [CadastrosController::class, 'origens']);
        Route::get('/cadastros/origens/new', function () { return view('authenticated.cadastros.origens.newOrigem'); })->name('origens.new');
        Route::post('/cadastros/origens/create', [CadastrosController::class, 'createOrigem'])->name('origens.create');
        Route::delete('/cadastros/origem/{id}', [CadastrosController::class, 'deleteOrigem'])->name('origens.delete');
        Route::get('/cadastros/origem/edit/{id}', [CadastrosController::class, 'editOrigem'])->name('origens.edit');
        Route::post('/cadastros/origem/update', [CadastrosController::class, 'updateOrigem'])->name('origens.update');
        Route::post('/search/origens', [CadastrosController::class, 'searchOrigens'])->name('searchOrigens');
    // PARENTESCOS
    Route::get('/cadastros/parentescos', [CadastrosController::class, 'parentescos']);
        Route::get('/cadastros/parentescos/new', function () { return view('authenticated.cadastros.parentescos.newParentesco'); })->name('parentescos.new');
        Route::post('/cadastros/parentescos/create', [CadastrosController::class, 'createParentesco'])->name('parentescos.create');
        Route::delete('/cadastros/parentesco/{id}', [CadastrosController::class, 'deleteParentesco'])->name('parentescos.delete');
        Route::get('/cadastros/parentesco/edit/{id}', [CadastrosController::class, 'editParentesco'])->name('parentescos.edit');
        Route::post('/cadastros/parentesco/update', [CadastrosController::class, 'updateParentesco'])->name('parentescos.update');
        Route::post('/search/parentescos', [CadastrosController::class, 'searchParentescos'])->name('searchParentescos');
    // PROFISSOES
    Route::get('/cadastros/profissoes', [CadastrosController::class, 'profissoes']);
        Route::get('/cadastros/profissoes/new', function () { return view('authenticated.cadastros.profissoes.newProfissao'); })->name('profissoes.new');
        Route::post('/cadastros/profissoes/create', [CadastrosController::class, 'createProfissao'])->name('profissoes.create');
        Route::delete('/cadastros/profissao/{id}', [CadastrosController::class, 'deleteProfissao'])->name('profissoes.delete');
        Route::get('/cadastros/profissao/edit/{id}', [CadastrosController::class, 'editProfissao'])->name('profissoes.edit');
        Route::post('/cadastros/profissao/update', [CadastrosController::class, 'updateProfissao'])->name('profissoes.update');
        Route::post('/search/profissoes', [CadastrosController::class, 'searchProfissoes'])->name('searchProfissoes');
    // SITUACOES
    Route::get('/cadastros/situacoes', [CadastrosController::class, 'situacoes']);
        Route::get('/cadastros/situacoes/new', function () { return view('authenticated.cadastros.situacoes.newSituacao'); })->name('situacoes.new');
        Route::post('/cadastros/situacoes/create', [CadastrosController::class, 'createSituacao'])->name('situacoes.create');
        Route::delete('/cadastros/situacao/{id}', [CadastrosController::class, 'deleteSituacao'])->name('situacoes.delete');
        Route::get('/cadastros/situacao/edit/{id}', [CadastrosController::class, 'editSituacao'])->name('situacoes.edit');
        Route::post('/cadastros/situacao/update', [CadastrosController::class, 'updateSituacao'])->name('situacoes.update');
        Route::post('/search/situacoes', [CadastrosController::class, 'searchSituacoes'])->name('searchSituacoes');
    // TIPO ARQUIVOS
    Route::get('/cadastros/tipo_arquivos', [CadastrosController::class, 'tipo_arquivos']);
        Route::get('/cadastros/tipo_arquivos/new', function () { return view('authenticated.cadastros.tipo_arquivos.newTipoArquivo'); })->name('tipo_arquivos.new');
        Route::post('/cadastros/tipo_arquivos/create', [CadastrosController::class, 'createTipoArquivo'])->name('tipo_arquivos.create');
        Route::delete('/cadastros/tipo_arquivo/{id}', [CadastrosController::class, 'deleteTipoArquivo'])->name('tipo_arquivos.delete');
        Route::get('/cadastros/tipo_arquivo/edit/{id}', [CadastrosController::class, 'editTipoArquivo'])->name('tipo_arquivos.edit');
        Route::post('/cadastros/tipo_arquivo/update', [CadastrosController::class, 'updateTipoArquivo'])->name('tipo_arquivos.update');
        Route::post('/search/tipo_arquivos', [CadastrosController::class, 'searchTipoArquivos'])->name('searchTipoArquivos');
    // TIPO ATIVIDADES
    Route::get('/cadastros/tipo_atividades', [CadastrosController::class, 'tipo_atividades']);
        Route::get('/cadastros/tipo_atividades/new', function () { return view('authenticated.cadastros.tipo_atividades.newTipoAtividade'); })->name('tipo_atividades.new');
        Route::post('/cadastros/tipo_atividades/create', [CadastrosController::class, 'createTipoAtividade'])->name('tipo_atividades.create');
        Route::delete('/cadastros/tipo_atividade/{id}', [CadastrosController::class, 'deleteTipoAtividade'])->name('tipo_atividades.delete');
        Route::get('/cadastros/tipo_atividade/edit/{id}', [CadastrosController::class, 'editTipoAtividade'])->name('tipo_atividades.edit');
        Route::post('/cadastros/tipo_atividade/update', [CadastrosController::class, 'updateTipoAtividade'])->name('tipo_atividades.update');
        Route::post('/search/tipo_atividades', [CadastrosController::class, 'searchTipoAtividades'])->name('searchTipoAtividades');
    // TIPO CURSOS
    Route::get('/cadastros/tipo_cursos', [CadastrosController::class, 'tipo_cursos']);
        Route::get('/cadastros/tipo_cursos/new', function () { return view('authenticated.cadastros.tipo_cursos.newTipoCurso'); })->name('tipo_cursos.new');
        Route::post('/cadastros/tipo_cursos/create', [CadastrosController::class, 'createTipoCurso'])->name('tipo_cursos.create');
        Route::delete('/cadastros/tipo_curso/{id}', [CadastrosController::class, 'deleteTipoCurso'])->name('tipo_cursos.delete');
        Route::get('/cadastros/tipo_curso/edit/{id}', [CadastrosController::class, 'editTipoCurso'])->name('tipo_cursos.edit');
        Route::post('/cadastros/tipo_curso/update', [CadastrosController::class, 'updateTipoCurso'])->name('tipo_cursos.update');
        Route::post('/search/tipo_cursos', [CadastrosController::class, 'searchTipoCursos'])->name('searchTipoCursos');
    // TIPO FORM RELIGIOSA
    Route::get('/cadastros/tipo_formReligiosa', [CadastrosController::class, 'tipo_formReligiosa']);
        Route::get('/cadastros/tipo_formReligiosa/new', function () { return view('authenticated.cadastros.tipo_formReligiosa.newTipoFormReligiosa'); })->name('tipo_formReligiosa.new');
        Route::post('/cadastros/tipo_formReligiosa/create', [CadastrosController::class, 'createTipoFormReligiosa'])->name('tipo_formReligiosa.create');
        Route::delete('/cadastros/tipo_formReligiosa/{id}', [CadastrosController::class, 'deleteTipoFormReligiosa'])->name('tipo_formReligiosa.delete');
        Route::get('/cadastros/tipo_formReligiosa/edit/{id}', [CadastrosController::class, 'editTipoFormReligiosa'])->name('tipo_formReligiosa.edit');
        Route::post('/cadastros/tipo_formReligiosa/update', [CadastrosController::class, 'updateTipoFormReligiosa'])->name('tipo_formReligiosa.update');
        Route::post('/search/tipo_formReligiosa', [CadastrosController::class, 'searchTipoFormReligiosa'])->name('searchTipoFormReligiosa');
    // TIPO FUNCAO
    Route::get('/cadastros/tipo_funcao', [CadastrosController::class, 'tipo_funcao']);
        Route::get('/cadastros/tipo_funcao/new', function () { return view('authenticated.cadastros.tipo_funcao.newTipoFuncao'); })->name('tipo_funcao.new');
        Route::post('/cadastros/tipo_funcao/create', [CadastrosController::class, 'createTipoFuncao'])->name('tipo_funcao.create');
        Route::delete('/cadastros/tipo_funcao/{id}', [CadastrosController::class, 'deleteTipoFuncao'])->name('tipo_funcao.delete');
        Route::get('/cadastros/tipo_funcao/edit/{id}', [CadastrosController::class, 'editTipoFuncao'])->name('tipo_funcao.edit');
        Route::post('/cadastros/tipo_funcao/update', [CadastrosController::class, 'updateTipoFuncao'])->name('tipo_funcao.update');
        Route::post('/search/tipo_funcao', [CadastrosController::class, 'searchTipoFuncao'])->name('searchTipoFuncao');
    // TIPO HABILIDADE
    Route::get('/cadastros/tipo_habilidades', [CadastrosController::class, 'tipo_habilidades']);
        Route::get('/cadastros/tipo_habilidades/new', function () { return view('authenticated.cadastros.tipo_habilidades.newTipoHabilidade'); })->name('tipo_habilidades.new');
        Route::post('/cadastros/tipo_habilidades/create', [CadastrosController::class, 'createTipoHabilidade'])->name('tipo_habilidades.create');
        Route::delete('/cadastros/tipo_habilidades/{id}', [CadastrosController::class, 'deleteTipoHabilidade'])->name('tipo_habilidades.delete');
        Route::get('/cadastros/tipo_habilidades/edit/{id}', [CadastrosController::class, 'editTipoHabilidade'])->name('tipo_habilidades.edit');
        Route::post('/cadastros/tipo_habilidades/update', [CadastrosController::class, 'updateTipoHabilidade'])->name('tipo_habilidades.update');
        Route::post('/search/tipo_habilidades', [CadastrosController::class, 'searchTipoHabilidade'])->name('searchTipoHabilidade');
    // TIPO INSTITUICOES
    Route::get('/cadastros/tipo_instituicoes', [CadastrosController::class, 'tipo_instituicoes']);
        Route::get('/cadastros/tipo_instituicoes/new', function () { return view('authenticated.cadastros.tipo_instituicoes.newTipoInstituicao'); })->name('tipo_instituicoes.new');
        Route::post('/cadastros/tipo_instituicoes/create', [CadastrosController::class, 'createTipoInstituicao'])->name('tipo_instituicoes.create');
        Route::delete('/cadastros/tipo_instituicoes/{id}', [CadastrosController::class, 'deleteTipoInstituicao'])->name('tipo_instituicoes.delete');
        Route::get('/cadastros/tipo_instituicoes/edit/{id}', [CadastrosController::class, 'editTipoInstituicao'])->name('tipo_instituicoes.edit');
        Route::post('/cadastros/tipo_instituicoes/update', [CadastrosController::class, 'updateTipoInstituicao'])->name('tipo_instituicoes.update');
        Route::post('/search/tipo_instituicoes', [CadastrosController::class, 'searchTipoInstituicao'])->name('searchTipoInstituicao');
    // TIPO OBRAS
    Route::get('/cadastros/tipo_obras', [CadastrosController::class, 'tipo_obras']);
        Route::get('/cadastros/tipo_obras/new', function () { return view('authenticated.cadastros.tipo_obras.newTipoObra'); })->name('tipo_obras.new');
        Route::post('/cadastros/tipo_obras/create', [CadastrosController::class, 'createTipoObra'])->name('tipo_obras.create');
        Route::delete('/cadastros/tipo_obras/{id}', [CadastrosController::class, 'deleteTipoObra'])->name('tipo_obras.delete');
        Route::get('/cadastros/tipo_obras/edit/{id}', [CadastrosController::class, 'editTipoObra'])->name('tipo_obras.edit');
        Route::post('/cadastros/tipo_obras/update', [CadastrosController::class, 'updateTipoObra'])->name('tipo_obras.update');
        Route::post('/search/tipo_obras', [CadastrosController::class, 'searchTipoObra'])->name('searchTipoObra');
    // TIPO PESSOAS
    Route::get('/cadastros/tipo_pessoas', [CadastrosController::class, 'tipo_pessoas']);
        Route::get('/cadastros/tipo_pessoas/new', function () { return view('authenticated.cadastros.tipo_pessoas.newTipoPessoa'); })->name('tipo_pessoas.new');
        Route::post('/cadastros/tipo_pessoas/create', [CadastrosController::class, 'createTipoPessoa'])->name('tipo_pessoas.create');
        Route::delete('/cadastros/tipo_pessoas/{id}', [CadastrosController::class, 'deleteTipoPessoa'])->name('tipo_pessoas.delete');
        Route::get('/cadastros/tipo_pessoas/edit/{id}', [CadastrosController::class, 'editTipoPessoa'])->name('tipo_pessoas.edit');
        Route::post('/cadastros/tipo_pessoas/update', [CadastrosController::class, 'updateTipoPessoa'])->name('tipo_pessoas.update');
        Route::post('/search/tipo_pessoas', [CadastrosController::class, 'searchTipoPessoa'])->name('searchTipoPessoa');
    // TIPO TRATAMENTO
    Route::get('/cadastros/tipo_tratamento', [CadastrosController::class, 'tipo_tratamento']);
        Route::get('/cadastros/tipo_tratamento/new', function () { return view('authenticated.cadastros.tipo_tratamento.newTipoTratamento'); })->name('tipo_tratamento.new');
        Route::post('/cadastros/tipo_tratamento/create', [CadastrosController::class, 'createTipoTratamento'])->name('tipo_tratamento.create');
        Route::delete('/cadastros/tipo_tratamento/{id}', [CadastrosController::class, 'deleteTipoTratamento'])->name('tipo_tratamento.delete');
        Route::get('/cadastros/tipo_tratamento/edit/{id}', [CadastrosController::class, 'editTipoTratamento'])->name('tipo_tratamento.edit');
        Route::post('/cadastros/tipo_tratamento/update', [CadastrosController::class, 'updateTipoTratamento'])->name('tipo_tratamento.update');
        Route::post('/search/tipo_tratamento', [CadastrosController::class, 'searchTipoTratamento'])->name('searchTipoTratamento');
    // TIPO TITULO
    Route::get('/cadastros/tipo_titulo', [CadastrosController::class, 'tipo_titulo']);
        Route::get('/cadastros/tipo_titulo/new', function () { return view('authenticated.cadastros.tipo_titulo.newTipoTitulo'); })->name('tipo_titulo.new');
        Route::post('/cadastros/tipo_titulo/create', [CadastrosController::class, 'createTipoTitulo'])->name('tipo_titulo.create');
        Route::delete('/cadastros/tipo_titulo/{id}', [CadastrosController::class, 'deleteTipoTitulo'])->name('tipo_titulo.delete');
        Route::get('/cadastros/tipo_titulo/edit/{id}', [CadastrosController::class, 'editTipoTitulo'])->name('tipo_titulo.edit');
        Route::post('/cadastros/tipo_titulo/update', [CadastrosController::class, 'updateTipoTitulo'])->name('tipo_titulo.update');
        Route::post('/search/tipo_titulo', [CadastrosController::class, 'searchTipoTitulo'])->name('searchTipoTitulo');


// MENU UL CONTROLE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // ASSOCIACOES
    Route::get('/controle/associacoes', [ControleController::class, 'associacoes']);
        Route::get('/controle/associacoes/new', [ControleController::class, 'associacoesNew'])->name('associacoes.new');
        Route::post('/controle/associacoes/create', [ControleController::class, 'createAssociacao'])->name('associacoes.create');
        Route::delete('/controle/associacoes/{id}', [ControleController::class, 'deleteAssociacao'])->name('associacoes.delete');
        Route::get('/controle/associacoes/edit/{id}', [ControleController::class, 'editAssociacao'])->name('associacoes.edit');
        Route::post('/controle/associacoes/update', [ControleController::class, 'updateAssociacao'])->name('associacoes.update');
        Route::post('/search/associacoes', [ControleController::class, 'searchAssociacao'])->name('searchAssociacao');
    // CAPITULOS
    Route::get('/controle/capitulos', [ControleController::class, 'capitulos']);
        Route::get('/controle/capitulos/new', [ControleController::class, 'capitulosNew'])->name('capitulos.new');
        Route::post('/controle/capitulos/create', [ControleController::class, 'createCapitulo'])->name('capitulos.create');
        Route::delete('/controle/capitulos/{id}', [ControleController::class, 'deleteCapitulo'])->name('capitulos.delete');
        Route::get('/controle/capitulos/edit/{id}', [ControleController::class, 'editCapitulo'])->name('capitulos.edit');
        Route::post('/controle/capitulos/update', [ControleController::class, 'updateCapitulo'])->name('capitulos.update');
        Route::post('/search/capitulos', [ControleController::class, 'searchCapitulo'])->name('searchCapitulo');
    // CEMITERIOS
    Route::get('/controle/cemiterios', [ControleController::class, 'cemiterios']);
        Route::get('/controle/cemiterios/new', [ControleController::class, 'cemiteriosNew'])->name('cemiterios.new');
        Route::post('/controle/cemiterios/create', [ControleController::class, 'createCemiterio'])->name('cemiterios.create');
        Route::delete('/controle/cemiterios/{id}', [ControleController::class, 'deleteCemiterio'])->name('cemiterios.delete');
        Route::get('/controle/cemiterios/edit/{id}', [ControleController::class, 'editCemiterio'])->name('cemiterios.edit');
        Route::post('/controle/cemiterios/update', [ControleController::class, 'updateCemiterio'])->name('cemiterios.update');
        Route::post('/search/cemiterios', [ControleController::class, 'searchCemiterio'])->name('searchCemiterio');
    // DIOCESES
    Route::get('/controle/dioceses', [ControleController::class, 'dioceses']);
        Route::get('/controle/dioceses/new', [ControleController::class, 'diocesesNew'])->name('dioceses.new');
        Route::post('/controle/dioceses/create', [ControleController::class, 'createDiocese'])->name('dioceses.create');
        Route::delete('/controle/dioceses/{id}', [ControleController::class, 'deleteDiocese'])->name('dioceses.delete');
        Route::get('/controle/dioceses/edit/{id}', [ControleController::class, 'editDiocese'])->name('dioceses.edit');
        Route::post('/controle/dioceses/update', [ControleController::class, 'updateDiocese'])->name('dioceses.update');
        Route::post('/search/dioceses', [ControleController::class, 'searchDiocese'])->name('searchDiocese');
    // PAROQUIAS
    Route::get('/controle/paroquias', [ControleController::class, 'paroquias']);
        Route::get('/controle/paroquias/new', [ControleController::class, 'paroquiasNew'])->name('paroquias.new');
        Route::post('/controle/paroquias/create', [ControleController::class, 'createParoquia'])->name('paroquias.create');
        Route::delete('/controle/paroquias/{id}', [ControleController::class, 'deleteParoquia'])->name('paroquias.delete');
        Route::get('/controle/paroquias/edit/{id}', [ControleController::class, 'editParoquia'])->name('paroquias.edit');
        Route::post('/controle/paroquias/update', [ControleController::class, 'updateParoquia'])->name('paroquias.update');
        Route::post('/search/paroquias', [ControleController::class, 'searchParoquia'])->name('searchParoquia');
    // PROVINCIAS
    Route::get('/controle/provincias', [ControleController::class, 'provincias']);
        Route::get('/controle/provincias/new', [ControleController::class, 'provinciasNew'])->name('provincias.new');
        Route::post('/controle/provincias/create', [ControleController::class, 'createProvincia'])->name('provincias.create');
        Route::delete('/controle/provincias/{id}', [ControleController::class, 'deleteProvincia'])->name('provincias.delete');
        Route::get('/controle/provincias/edit/{id}', [ControleController::class, 'editProvincia'])->name('provincias.edit');
        Route::post('/controle/provincias/update', [ControleController::class, 'updateProvincia'])->name('provincias.update');
        Route::get('/search/provincias', [ControleController::class, 'searchProvincia'])->name('searchProvincia');
    // SETORES
    Route::get('/controle/setores', [ControleController::class, 'setores']);
        Route::get('/controle/setores/new', function () { return view('authenticated.controle.setores.newSetor'); })->name('setores.new');
        Route::post('/controle/setores/create', [ControleController::class, 'createSetor'])->name('setores.create');
        Route::delete('/controle/setores/{id}', [ControleController::class, 'deleteSetor'])->name('setores.delete');
        Route::get('/controle/setores/edit/{id}', [ControleController::class, 'editSetor'])->name('setores.edit');
        Route::post('/controle/setores/update', [ControleController::class, 'updateSetor'])->name('setores.update');
        Route::post('/search/setores', [ControleController::class, 'searchSetor'])->name('searchSetor');
    // COMUNIDADES
    Route::get('/controle/comunidades', [ControleController::class, 'comunidades']);
        Route::get('/controle/comunidades/new', [ControleController::class, 'comunidadesNew'])->name('comunidades.new');
        Route::post('/controle/comunidades/create', [ControleController::class, 'createComunidade'])->name('comunidades.create');
        Route::delete('/controle/comunidades/{id}', [ControleController::class, 'deleteComunidade'])->name('comunidades.delete');
        Route::get('/controle/comunidades/edit/{id}', [ControleController::class, 'editComunidade'])->name('comunidades.edit');
        Route::post('/controle/comunidades/update', [ControleController::class, 'updateComunidade'])->name('comunidades.update');
        Route::post('/search/comunidades', [ControleController::class, 'searchComunidade'])->name('searchComunidade');
        // ENDERECOS
        Route::get('/controle/comunidades/map/{id}', [ControleController::class, 'enderecos'])->name('comunidades.map');
            Route::get('/controle/enderecos/{id_comunidade}/new', [ControleController::class, 'enderecosNew'])->name('enderecos.new');
            Route::post('/controle/enderecos/create', [ControleController::class, 'createEndereco'])->name('enderecos.create');
            Route::delete('/controle/enderecos/{id}', [ControleController::class, 'deleteEndereco'])->name('enderecos.delete');
            Route::get('/controle/enderecos/{id_comunidade}/edit/{id}', [ControleController::class, 'editEndereco'])->name('enderecos.edit');
            Route::post('/controle/enderecos/update', [ControleController::class, 'updateEndereco'])->name('enderecos.update');
            Route::post('/search/enderecos', [ControleController::class, 'searchEndereco'])->name('searchEndereco');

    //Pessoal
    // Egressos
     Route::get('/pessoal/egressos', [PessoalController::class, 'egressos']);
     Route::get('/pessoal/egressos/new', [PessoalController::class, 'egressosNew'])->name('egressos.new');
        Route::post('/pessoal/egressos/create', [PessoalController::class, 'createEgressos'])->name('egressos.create');
        Route::delete('/pessoal/egressos/{id}', [PessoalController::class, 'deleteEgressos'])->name('egressos.delete');
        Route::get('/pessoal/egressos/edit/{id}', [PessoalController::class, 'editEgressos'])->name('egressos.edit');
        Route::post('/pessoal/egressos/update', [PessoalController::class, 'updateEgressos'])->name('egressos.update');
        Route::post('/search/egressos', [PessoalController::class, 'searchEgresso'])->name('searchEgresso');

    //transferencia
        Route::get('/pessoal/transferencia', [PessoalController::class, 'transferencia']);
        Route::get('/pessoal/transferencia/new', [PessoalController::class, 'transferenciaNew'])->name('transferencias.new');
           Route::post('/pessoal/transferencia/create', [PessoalController::class, 'createTransferencia'])->name('transferencia.create');
           Route::get('/pessoal/transferencia/edit/{id}', [PessoalController::class, 'editTransferencia'])->name('transferencia.edit');
           Route::post('/pessoal/transferencia/update', [PessoalController::class, 'updateTransferencia'])->name('transferencias.update');
           Route::post('/search/transferencia', [PessoalController::class, 'searchTransferencia'])->name('searchTransferencia');

            //falecimentos
            Route::get('/pessoal/falecimentos', [PessoalController::class, 'falecimentos']);
            Route::get('/pessoal/falecimentos/new', [PessoalController::class, 'falecimentosNew'])->name('falecimentos.new');
               Route::post('/pessoal/falecimentos/create', [PessoalController::class, 'createFalecimentos'])->name('falecimentos.create');
               Route::delete('/pessoal/falecimentos/{id}', [PessoalController::class, 'deleteFalecimentos'])->name('falecimentos.delete');
               Route::get('/pessoal/falecimentos/edit/{id}', [PessoalController::class, 'editFalecimentos'])->name('falecimentos.edit');
               Route::post('/pessoal/falecimentos/update', [PessoalController::class, 'updateFalecimentos'])->name('falecimentos.update');
               Route::post('/search/falecimentos', [PessoalController::class, 'searchFalecimentos'])->name('searchFalecimentos');


// MENU PESSOAS
        // PROVINCIAS
        Route::get('/pessoal/pessoas', [PessoalController::class, 'pessoas']);
        Route::get('/pessoal/pessoas/new', [PessoalController::class, 'pessoasNew'])->name('pessoas.new');
        Route::post('/pessoal/pessoas/create', [PessoalController::class, 'createPessoa'])->name('pessoas.create');
        Route::delete('/pessoal/pessoas/{id}', [PessoalController::class, 'deletePessoa'])->name('pessoas.delete');
        Route::get('/pessoal/pessoas/edit/{id}', [PessoalController::class, 'editPessoa'])->name('pessoas.edit');
        Route::post('/pessoal/pessoas/update', [PessoalController::class, 'updatePessoa'])->name('pessoas.update');
        Route::get('/search/pessoas', [PessoalController::class, 'searchPessoa'])->name('searchPessoa');
        // OPERACOES DO MENU PESSOAS
        // ARQUIVOS
        Route::get('/pessoal/pessoas/arquivos', [PessoalController::class, 'pessoasArquivos'])->name('pessoas.arquivos');
            Route::get('/pessoal/pessoas/arquivos/{pessoa_id}/new', [PessoalController::class, 'newArquivo'])->name('arquivos.new');
            Route::post('/pessoal/pessoas/arquivos/create', [PessoalController::class, 'createArquivo'])->name('arquivo.create');
            Route::delete('/pessoal/pessoas/arquivos/{id}', [PessoalController::class, 'deleteArquivo'])->name('arquivos.delete');
            Route::get('/search/pessoas/arquivos', [PessoalController::class, 'searchArquivo'])->name('searchArquivo');
        // ATIVIDADES
        Route::get('/pessoal/pessoas/atividades', [PessoalController::class, 'pessoasAtividades'])->name('pessoas.atividades');
            Route::get('/pessoal/pessoas/atividades/{pessoa_id}/new', [PessoalController::class, 'newAtividade'])->name('atividade.new');
            Route::post('/pessoal/pessoas/atividades/create', [PessoalController::class, 'createAtividade'])->name('atividade.create');
            Route::delete('/pessoal/pessoas/atividades/{id}', [PessoalController::class, 'deleteAtividade'])->name('atividade.delete');
            Route::get('/search/pessoas/atividades', [PessoalController::class, 'searchAtividade'])->name('searchAtividade');


        Route::get('/pessoal/pessoas/cursos', [PessoalController::class, 'pessoasCursos'])->name('pessoas.cursos');
        Route::get('/pessoal/pessoas/parentes', [PessoalController::class, 'pessoasParentes'])->name('pessoas.parentes');
        Route::get('/pessoal/pessoas/formacoes', [PessoalController::class, 'pessoasFormacoes'])->name('pessoas.formacoes');
        Route::get('/pessoal/pessoas/funcoes', [PessoalController::class, 'pessoasFuncoes'])->name('pessoas.funcoes');
        Route::get('/pessoal/pessoas/habilidades', [PessoalController::class, 'pessoasHabilidades'])->name('pessoas.habilidades');
        Route::get('/pessoal/pessoas/historico', [PessoalController::class, 'pessoasHistorico'])->name('pessoas.historico');
        Route::get('/pessoal/pessoas/itinerarios', [PessoalController::class, 'pessoasItinerarios'])->name('pessoas.itinerarios');
        Route::get('/pessoal/pessoas/ocorrenciasMedicas', [PessoalController::class, 'pessoasOcorrenciasMedicas'])->name('pessoas.ocorrenciasMedicas');
        Route::get('/pessoal/pessoas/imprimir', [PessoalController::class, 'pessoasImprimir'])->name('pessoas.imprimir');
        Route::get('/pessoal/pessoas/edit', [PessoalController::class, 'pessoasEdit'])->name('pessoas.edit');
        // IMPRIMIR
        Route::get('/relatorio/rede/provincias', [RelatoriosController::class, 'provincias'])->name('provincias.imprimir');
        Route::get('/relatorio/rede/provincias/pdf', [RelatoriosController::class, 'provinciasPdf'])->name('provincias.pdf');




// ----------------------------------------------- RELATORIOS ----------------------------------------------------------------------------------------------------------
// PESSOAL
Route::get('/relatorio/pessoal/transferencia', [RelatoriosController::class, 'transferencias'])->name('transferencias.imprimir');
Route::get('/relatorio/pessoal/transferencia/pdf', [RelatoriosController::class, 'transferenciasPdf'])->name('transferencias.pdf');


// REDE
    Route::get('/relatorio/rede/provincias', [RelatoriosController::class, 'provincias'])->name('provincias.imprimir');
    Route::get('/relatorio/rede/provincias/pdf', [RelatoriosController::class, 'provinciasPdf'])->name('provincias.pdf');

    Route::get('/relatorio/rede/paroquias', [RelatoriosController::class, 'paroquias'])->name('paroquias.imprimir');
    Route::get('/relatorio/rede/paroquias/pdf', [RelatoriosController::class, 'paroquiasPdf'])->name('paroquias.pdf');

    Route::get('/relatorio/rede/obras', [RelatoriosController::class, 'obras'])->name('obras.imprimir');
    Route::get('/relatorio/rede/obras/pdf', [RelatoriosController::class, 'obrasPdf'])->name('obras.pdf');

    Route::get('/relatorio/rede/funcoes', [RelatoriosController::class, 'funcoes'])->name('funcoes.imprimir');
    Route::get('/relatorio/rede/funcoes/pdf', [RelatoriosController::class, 'funcoesPdf'])->name('funcoes.pdf');

    Route::get('/relatorio/rede/dioceses', [RelatoriosController::class, 'dioceses'])->name('dioceses.imprimir');
    Route::get('/relatorio/rede/dioceses/pdf', [RelatoriosController::class, 'diocesesPdf'])->name('dioceses.pdf');

    Route::get('/relatorio/rede/comunidades_aniv', [RelatoriosController::class, 'comunidades_aniv'])->name('comunidades_aniv.imprimir');
    Route::get('/relatorio/rede/comunidades_aniv/pdf', [RelatoriosController::class, 'comunidades_anivPdf'])->name('comunidades_aniv.pdf');

    Route::get('/relatorio/rede/comunidades', [RelatoriosController::class, 'comunidades'])->name('comunidades.imprimir');
    Route::get('/relatorio/rede/comunidades/pdf', [RelatoriosController::class, 'comunidadesPdf'])->name('comunidades.pdf');

    Route::get('/relatorio/rede/cemiterios', [RelatoriosController::class, 'cemiterios'])->name('cemiterios.imprimir');
    Route::get('/relatorio/rede/cemiterios/pdf', [RelatoriosController::class, 'cemiteriosPdf'])->name('cemiterios.pdf');

    Route::get('/relatorio/rede/associacoes', [RelatoriosController::class, 'associacoes'])->name('associacoes.imprimir');
    Route::get('/relatorio/rede/associacoes/pdf', [RelatoriosController::class, 'associacoesPdf'])->name('associacoes.pdf');

    Route::get('/pessoal/pessoas/arquivos', [PessoalController::class, 'pessoasArquivos'])->name('pessoas.arquivos');
    Route::get('/pessoal/pessoas/atividades', [PessoalController::class, 'pessoasAtividades'])->name('pessoas.atividades');
    Route::get('/pessoal/pessoas/cursos', [PessoalController::class, 'pessoasCursos'])->name('pessoas.cursos');
    Route::get('/pessoal/pessoas/parentes', [PessoalController::class, 'pessoasParentes'])->name('pessoas.parentes');
    Route::get('/pessoal/pessoas/formacoes', [PessoalController::class, 'pessoasFormacoes'])->name('pessoas.formacoes');
    Route::get('/pessoal/pessoas/funcoes', [PessoalController::class, 'pessoasFuncoes'])->name('pessoas.funcoes');
    Route::get('/pessoal/pessoas/habilidades', [PessoalController::class, 'pessoasHabilidades'])->name('pessoas.habilidades');
    Route::get('/pessoal/pessoas/historico', [PessoalController::class, 'pessoasHistorico'])->name('pessoas.historico');
    Route::get('/pessoal/pessoas/itinerarios', [PessoalController::class, 'pessoasItinerarios'])->name('pessoas.itinerarios');
    Route::get('/pessoal/pessoas/ocorrenciasMedicas', [PessoalController::class, 'pessoasOcorrenciasMedicas'])->name('pessoas.ocorrenciasMedicas');
    Route::get('/pessoal/pessoas/imprimir', [PessoalController::class, 'pessoasImprimir'])->name('pessoas.imprimir');
    Route::get('/pessoal/pessoas/edit', [PessoalController::class, 'pessoasEdit'])->name('pessoas.edit');
    // IMPRIMIR
    Route::get('/relatorio/rede/provincias', [RelatoriosController::class, 'provincias'])->name('provincias.imprimir');
    Route::get('/relatorio/rede/provincias/pdf', [RelatoriosController::class, 'provinciasPdf'])->name('provincias.pdf');

});


