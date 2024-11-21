<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadastrosController;
use App\Http\Controllers\ControleController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FpdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PessoalController;
use App\Http\Controllers\Pessoas\ArquivoController;
use App\Http\Controllers\Pessoas\AtividadeController;
use App\Http\Controllers\Pessoas\CursoController;
use App\Http\Controllers\Pessoas\FormacoesController;
use App\Http\Controllers\Pessoas\FuncaoController;
use App\Http\Controllers\Pessoas\HabilidadeController;
use App\Http\Controllers\Pessoas\HistoricoController;
use App\Http\Controllers\Pessoas\ItinerarioController;
use App\Http\Controllers\Pessoas\OcorrenciaMedicaController;
use App\Http\Controllers\Pessoas\ParenteController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilsController;
use App\Jobs\GeneratePdfJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        if (auth()->check()) {

            return redirect()->route('home');
        }
        return view('auth/login');
    })->name('login');

Route::post('/auth', [AuthController::class, 'auth']);

// Mostrar o formulário para solicitar link de redefinição de senha
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Mostrar o formulário para redefinir a senha
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Todas as rotas dentro deste grupo só estarão disponíveis para usuários autenticados
Route::middleware('auth')->group(function () {
    // Geral
    Route::get('/obter-pais/{estado_id}', [UtilsController::class, 'obterPais']);
    Route::get('/obter-estado/{cidade_id}', [UtilsController::class, 'obterEstado']);
    Route::get('/obter-cidade/{cidade_id}', [UtilsController::class, 'obterCidade']);

    Route::get('/obter-estados/{pais_id}', [UtilsController::class, 'obterEstados']);
    Route::get('/obter-cidades/{estado_id}', [UtilsController::class, 'obterCidades']);
    Route::get('/obter-paroquias/{diocese_id}', [UtilsController::class, 'obterParoquias']);
    Route::post('/action-button', [RelatoriosController::class, 'actionButton'])->name('actionButton');


    // Menu UL Início
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/meus-dados', [UserController::class, 'index']);
    Route::post('/meus-dados/update', [UserController::class, 'update']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/sobre', function () { return view('authenticated.sobre'); });
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
    Route::get('/cadastros/doencas', [CadastrosController::class, 'doencas'])->name('doencas.index');
        Route::get('/cadastros/doencas/new', function () { return view('authenticated.cadastros.doencas.newDoenca'); })->name('doencas.new');
        Route::post('/cadastros/doencas/create', [CadastrosController::class, 'createDoenca'])->name('doencas.create');
        Route::delete('/cadastros/doenca/{id}', [CadastrosController::class, 'deleteDoenca'])->name('doencas.delete');
        Route::get('/cadastros/doenca/edit/{id}', [CadastrosController::class, 'editDoenca'])->name('doencas.edit');
        Route::post('/cadastros/doenca/update', [CadastrosController::class, 'updateDoenca'])->name('doencas.update');

    // ORIGENS
    Route::get('/cadastros/origens', [CadastrosController::class, 'origens'])->name('origens.index');
        Route::get('/cadastros/origens/new', function () { return view('authenticated.cadastros.origens.newOrigem'); })->name('origens.new');
        Route::post('/cadastros/origens/create', [CadastrosController::class, 'createOrigem'])->name('origens.create');
        Route::delete('/cadastros/origem/{id}', [CadastrosController::class, 'deleteOrigem'])->name('origens.delete');
        Route::get('/cadastros/origem/edit/{id}', [CadastrosController::class, 'editOrigem'])->name('origens.edit');
        Route::post('/cadastros/origem/update', [CadastrosController::class, 'updateOrigem'])->name('origens.update');
    // PARENTESCOS
    Route::get('/cadastros/parentescos', [CadastrosController::class, 'parentescos'])->name('parentescos.index');
        Route::get('/cadastros/parentescos/new', function () { return view('authenticated.cadastros.parentescos.newParentesco'); })->name('parentescos.new');
        Route::post('/cadastros/parentescos/create', [CadastrosController::class, 'createParentesco'])->name('parentescos.create');
        Route::delete('/cadastros/parentesco/{id}', [CadastrosController::class, 'deleteParentesco'])->name('parentescos.delete');
        Route::get('/cadastros/parentesco/edit/{id}', [CadastrosController::class, 'editParentesco'])->name('parentescos.edit');
        Route::post('/cadastros/parentesco/update', [CadastrosController::class, 'updateParentesco'])->name('parentescos.update');
    // PROFISSOES
    Route::get('/cadastros/profissoes', [CadastrosController::class, 'profissoes'])->name('profissoes.index');
        Route::get('/cadastros/profissoes/new', function () { return view('authenticated.cadastros.profissoes.newProfissao'); })->name('profissoes.new');
        Route::post('/cadastros/profissoes/create', [CadastrosController::class, 'createProfissao'])->name('profissoes.create');
        Route::delete('/cadastros/profissao/{id}', [CadastrosController::class, 'deleteProfissao'])->name('profissoes.delete');
        Route::get('/cadastros/profissao/edit/{id}', [CadastrosController::class, 'editProfissao'])->name('profissoes.edit');
        Route::post('/cadastros/profissao/update', [CadastrosController::class, 'updateProfissao'])->name('profissoes.update');
    // SITUACOES
    Route::get('/cadastros/situacoes', [CadastrosController::class, 'situacoes'])->name('situacoes.index');
        Route::get('/cadastros/situacoes/new', function () { return view('authenticated.cadastros.situacoes.newSituacao'); })->name('situacoes.new');
        Route::post('/cadastros/situacoes/create', [CadastrosController::class, 'createSituacao'])->name('situacoes.create');
        Route::delete('/cadastros/situacao/{id}', [CadastrosController::class, 'deleteSituacao'])->name('situacoes.delete');
        Route::get('/cadastros/situacao/edit/{id}', [CadastrosController::class, 'editSituacao'])->name('situacoes.edit');
        Route::post('/cadastros/situacao/update', [CadastrosController::class, 'updateSituacao'])->name('situacoes.update');
    // TIPO ARQUIVOS
    Route::get('/cadastros/tipo_arquivos', [CadastrosController::class, 'tipo_arquivos'])->name('tipo_arquivos.index');
        Route::get('/cadastros/tipo_arquivos/new', function () { return view('authenticated.cadastros.tipo_arquivos.newTipoArquivo'); })->name('tipo_arquivos.new');
        Route::post('/cadastros/tipo_arquivos/create', [CadastrosController::class, 'createTipoArquivo'])->name('tipo_arquivos.create');
        Route::delete('/cadastros/tipo_arquivo/{id}', [CadastrosController::class, 'deleteTipoArquivo'])->name('tipo_arquivos.delete');
        Route::get('/cadastros/tipo_arquivo/edit/{id}', [CadastrosController::class, 'editTipoArquivo'])->name('tipo_arquivos.edit');
        Route::post('/cadastros/tipo_arquivo/update', [CadastrosController::class, 'updateTipoArquivo'])->name('tipo_arquivos.update');
    // TIPO ATIVIDADES
    Route::get('/cadastros/tipo_atividades', [CadastrosController::class, 'tipo_atividades'])->name('tipo_atividades.index');
        Route::get('/cadastros/tipo_atividades/new', function () { return view('authenticated.cadastros.tipo_atividades.newTipoAtividade'); })->name('tipo_atividades.new');
        Route::post('/cadastros/tipo_atividades/create', [CadastrosController::class, 'createTipoAtividade'])->name('tipo_atividades.create');
        Route::delete('/cadastros/tipo_atividade/{id}', [CadastrosController::class, 'deleteTipoAtividade'])->name('tipo_atividades.delete');
        Route::get('/cadastros/tipo_atividade/edit/{id}', [CadastrosController::class, 'editTipoAtividade'])->name('tipo_atividades.edit');
        Route::post('/cadastros/tipo_atividade/update', [CadastrosController::class, 'updateTipoAtividade'])->name('tipo_atividades.update');
    // TIPO CURSOS
    Route::get('/cadastros/tipo_cursos', [CadastrosController::class, 'tipo_cursos'])->name('tipo_cursos.index');
        Route::get('/cadastros/tipo_cursos/new', function () { return view('authenticated.cadastros.tipo_cursos.newTipoCurso'); })->name('tipo_cursos.new');
        Route::post('/cadastros/tipo_cursos/create', [CadastrosController::class, 'createTipoCurso'])->name('tipo_cursos.create');
        Route::delete('/cadastros/tipo_curso/{id}', [CadastrosController::class, 'deleteTipoCurso'])->name('tipo_cursos.delete');
        Route::get('/cadastros/tipo_curso/edit/{id}', [CadastrosController::class, 'editTipoCurso'])->name('tipo_cursos.edit');
        Route::post('/cadastros/tipo_curso/update', [CadastrosController::class, 'updateTipoCurso'])->name('tipo_cursos.update');
    // TIPO FORM RELIGIOSA
    Route::get('/cadastros/tipo_formReligiosa', [CadastrosController::class, 'tipo_formReligiosa'])->name('tipo_formReligiosa.index');
        Route::get('/cadastros/tipo_formReligiosa/new', function () { return view('authenticated.cadastros.tipo_formReligiosa.newTipoFormReligiosa'); })->name('tipo_formReligiosa.new');
        Route::post('/cadastros/tipo_formReligiosa/create', [CadastrosController::class, 'createTipoFormReligiosa'])->name('tipo_formReligiosa.create');
        Route::delete('/cadastros/tipo_formReligiosa/{id}', [CadastrosController::class, 'deleteTipoFormReligiosa'])->name('tipo_formReligiosa.delete');
        Route::get('/cadastros/tipo_formReligiosa/edit/{id}', [CadastrosController::class, 'editTipoFormReligiosa'])->name('tipo_formReligiosa.edit');
        Route::post('/cadastros/tipo_formReligiosa/update', [CadastrosController::class, 'updateTipoFormReligiosa'])->name('tipo_formReligiosa.update');
    // TIPO FUNCAO
    Route::get('/cadastros/tipo_funcao', [CadastrosController::class, 'tipo_funcao'])->name('tipo_funcao.index');
        Route::get('/cadastros/tipo_funcao/new', function () { return view('authenticated.cadastros.tipo_funcao.newTipoFuncao'); })->name('tipo_funcao.new');
        Route::post('/cadastros/tipo_funcao/create', [CadastrosController::class, 'createTipoFuncao'])->name('tipo_funcao.create');
        Route::delete('/cadastros/tipo_funcao/{id}', [CadastrosController::class, 'deleteTipoFuncao'])->name('tipo_funcao.delete');
        Route::get('/cadastros/tipo_funcao/edit/{id}', [CadastrosController::class, 'editTipoFuncao'])->name('tipo_funcao.edit');
        Route::post('/cadastros/tipo_funcao/update', [CadastrosController::class, 'updateTipoFuncao'])->name('tipo_funcao.update');
    // TIPO HABILIDADE
    Route::get('/cadastros/tipo_habilidades', [CadastrosController::class, 'tipo_habilidades'])->name('tipo_habilidades.index');
        Route::get('/cadastros/tipo_habilidades/new', function () { return view('authenticated.cadastros.tipo_habilidades.newTipoHabilidade'); })->name('tipo_habilidades.new');
        Route::post('/cadastros/tipo_habilidades/create', [CadastrosController::class, 'createTipoHabilidade'])->name('tipo_habilidades.create');
        Route::delete('/cadastros/tipo_habilidades/{id}', [CadastrosController::class, 'deleteTipoHabilidade'])->name('tipo_habilidades.delete');
        Route::get('/cadastros/tipo_habilidades/edit/{id}', [CadastrosController::class, 'editTipoHabilidade'])->name('tipo_habilidades.edit');
        Route::post('/cadastros/tipo_habilidades/update', [CadastrosController::class, 'updateTipoHabilidade'])->name('tipo_habilidades.update');
    // TIPO INSTITUICOES
    Route::get('/cadastros/tipo_instituicoes', [CadastrosController::class, 'tipo_instituicoes'])->name('tipo_instituicoes.index');
        Route::get('/cadastros/tipo_instituicoes/new', function () { return view('authenticated.cadastros.tipo_instituicoes.newTipoInstituicao'); })->name('tipo_instituicoes.new');
        Route::post('/cadastros/tipo_instituicoes/create', [CadastrosController::class, 'createTipoInstituicao'])->name('tipo_instituicoes.create');
        Route::delete('/cadastros/tipo_instituicoes/{id}', [CadastrosController::class, 'deleteTipoInstituicao'])->name('tipo_instituicoes.delete');
        Route::get('/cadastros/tipo_instituicoes/edit/{id}', [CadastrosController::class, 'editTipoInstituicao'])->name('tipo_instituicoes.edit');
        Route::post('/cadastros/tipo_instituicoes/update', [CadastrosController::class, 'updateTipoInstituicao'])->name('tipo_instituicoes.update');
    // TIPO OBRAS
    Route::get('/cadastros/tipo_obras', [CadastrosController::class, 'tipo_obras'])->name('tipo_obras.index');
        Route::get('/cadastros/tipo_obras/new', function () { return view('authenticated.cadastros.tipo_obras.newTipoObra'); })->name('tipo_obras.new');
        Route::post('/cadastros/tipo_obras/create', [CadastrosController::class, 'createTipoObra'])->name('tipo_obras.create');
        Route::delete('/cadastros/tipo_obras/{id}', [CadastrosController::class, 'deleteTipoObra'])->name('tipo_obras.delete');
        Route::get('/cadastros/tipo_obras/edit/{id}', [CadastrosController::class, 'editTipoObra'])->name('tipo_obras.edit');
        Route::post('/cadastros/tipo_obras/update', [CadastrosController::class, 'updateTipoObra'])->name('tipo_obras.update');
    // TIPO PESSOAS
    Route::get('/cadastros/tipo_pessoas', [CadastrosController::class, 'tipo_pessoas'])->name('tipo_pessoas.index');
        Route::get('/cadastros/tipo_pessoas/new', function () { return view('authenticated.cadastros.tipo_pessoas.newTipoPessoa'); })->name('tipo_pessoas.new');
        Route::post('/cadastros/tipo_pessoas/create', [CadastrosController::class, 'createTipoPessoa'])->name('tipo_pessoas.create');
        Route::delete('/cadastros/tipo_pessoas/{id}', [CadastrosController::class, 'deleteTipoPessoa'])->name('tipo_pessoas.delete');
        Route::get('/cadastros/tipo_pessoas/edit/{id}', [CadastrosController::class, 'editTipoPessoa'])->name('tipo_pessoas.edit');
        Route::post('/cadastros/tipo_pessoas/update', [CadastrosController::class, 'updateTipoPessoa'])->name('tipo_pessoas.update');
    // TIPO TRATAMENTO
    Route::get('/cadastros/tipo_tratamento', [CadastrosController::class, 'tipo_tratamento'])->name('tipo_tratamento.index');
        Route::get('/cadastros/tipo_tratamento/new', function () { return view('authenticated.cadastros.tipo_tratamento.newTipoTratamento'); })->name('tipo_tratamento.new');
        Route::post('/cadastros/tipo_tratamento/create', [CadastrosController::class, 'createTipoTratamento'])->name('tipo_tratamento.create');
        Route::delete('/cadastros/tipo_tratamento/{id}', [CadastrosController::class, 'deleteTipoTratamento'])->name('tipo_tratamento.delete');
        Route::get('/cadastros/tipo_tratamento/edit/{id}', [CadastrosController::class, 'editTipoTratamento'])->name('tipo_tratamento.edit');
        Route::post('/cadastros/tipo_tratamento/update', [CadastrosController::class, 'updateTipoTratamento'])->name('tipo_tratamento.update');
    // TIPO TITULO
    Route::get('/cadastros/tipo_titulo', [CadastrosController::class, 'tipo_titulo'])->name('tipo_titulo.index');
        Route::get('/cadastros/tipo_titulo/new', function () { return view('authenticated.cadastros.tipo_titulo.newTipoTitulo'); })->name('tipo_titulo.new');
        Route::post('/cadastros/tipo_titulo/create', [CadastrosController::class, 'createTipoTitulo'])->name('tipo_titulo.create');
        Route::delete('/cadastros/tipo_titulo/{id}', [CadastrosController::class, 'deleteTipoTitulo'])->name('tipo_titulo.delete');
        Route::get('/cadastros/tipo_titulo/edit/{id}', [CadastrosController::class, 'editTipoTitulo'])->name('tipo_titulo.edit');
        Route::post('/cadastros/tipo_titulo/update', [CadastrosController::class, 'updateTipoTitulo'])->name('tipo_titulo.update');

        Route::get('/cadastros/parentes', [CadastrosController::class, 'parentes'])->name('parentes.index');
        Route::get('/cadastros/parentes/new', function () { return view('authenticated.cadastros.parentes.newParentesco'); })->name('parentes.new');
        Route::post('/cadastros/parentes/create', [CadastrosController::class, 'createParentes'])->name('parentes.create');
        Route::delete('/cadastros/parentes/{id}', [CadastrosController::class, 'deleteParentes'])->name('parentes.delete');
        Route::get('/cadastros/parentes/edit/{id}', [CadastrosController::class, 'editParentes'])->name('parentes.edit');
        Route::post('/cadastros/parentes/update', [CadastrosController::class, 'updateParentes'])->name('parentes.update');

// MENU UL CONTROLE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // ASSOCIACOES
    Route::get('/controle/associacoes', [ControleController::class, 'associacoes'])->name('associacoes.index');
        Route::get('/controle/associacoes/new', [ControleController::class, 'associacoesNew'])->name('associacoes.new');
        Route::post('/controle/associacoes/create', [ControleController::class, 'createAssociacao'])->name('associacoes.create');
        Route::delete('/controle/associacoes/{id}', [ControleController::class, 'deleteAssociacao'])->name('associacoes.delete');
        Route::get('/controle/associacoes/edit/{id}', [ControleController::class, 'editAssociacao'])->name('associacoes.edit');
        Route::post('/controle/associacoes/update', [ControleController::class, 'updateAssociacao'])->name('associacoes.update');
    // CAPITULOS
    Route::get('/controle/capitulos', [ControleController::class, 'capitulos'])->name('capitulos.index');
        Route::get('/controle/capitulos/new', [ControleController::class, 'capitulosNew'])->name('capitulos.new');
        Route::post('/controle/capitulos/create', [ControleController::class, 'createCapitulo'])->name('capitulos.create');
        Route::delete('/controle/capitulos/{id}', [ControleController::class, 'deleteCapitulo'])->name('capitulos.delete');
        Route::get('/controle/capitulos/edit/{id}', [ControleController::class, 'editCapitulo'])->name('capitulos.edit');
        Route::post('/controle/capitulos/update', [ControleController::class, 'updateCapitulo'])->name('capitulos.update');
    // CEMITERIOS
    Route::get('/controle/cemiterios', [ControleController::class, 'cemiterios'])->name('cemiterios.index');
        Route::get('/controle/cemiterios/new', [ControleController::class, 'cemiteriosNew'])->name('cemiterios.new');
        Route::post('/controle/cemiterios/create', [ControleController::class, 'createCemiterio'])->name('cemiterios.create');
        Route::delete('/controle/cemiterios/{id}', [ControleController::class, 'deleteCemiterio'])->name('cemiterios.delete');
        Route::get('/controle/cemiterios/edit/{id}', [ControleController::class, 'editCemiterio'])->name('cemiterios.edit');
        Route::post('/controle/cemiterios/update', [ControleController::class, 'updateCemiterio'])->name('cemiterios.update');
    // DIOCESES
    Route::get('/controle/dioceses', [ControleController::class, 'dioceses'])->name('dioceses.index');
        Route::get('/controle/dioceses/new', [ControleController::class, 'diocesesNew'])->name('dioceses.new');
        Route::post('/controle/dioceses/create', [ControleController::class, 'createDiocese'])->name('dioceses.create');
        Route::delete('/controle/dioceses/{id}', [ControleController::class, 'deleteDiocese'])->name('dioceses.delete');
        Route::get('/controle/dioceses/edit/{id}', [ControleController::class, 'editDiocese'])->name('dioceses.edit');
        Route::post('/controle/dioceses/update', [ControleController::class, 'updateDiocese'])->name('dioceses.update');
    // PAROQUIAS
    Route::get('/controle/paroquias', [ControleController::class, 'paroquias'])->name('paroquias.index');
        Route::get('/controle/paroquias/new', [ControleController::class, 'paroquiasNew'])->name('paroquias.new');
        Route::post('/controle/paroquias/create', [ControleController::class, 'createParoquia'])->name('paroquias.create');
        Route::delete('/controle/paroquias/{id}', [ControleController::class, 'deleteParoquia'])->name('paroquias.delete');
        Route::get('/controle/paroquias/edit/{id}', [ControleController::class, 'editParoquia'])->name('paroquias.edit');
        Route::post('/controle/paroquias/update', [ControleController::class, 'updateParoquia'])->name('paroquias.update');
    // PROVINCIAS
    Route::get('/controle/provincias', [ControleController::class, 'provincias'])->name('provincias.index');
        Route::get('/controle/provincias/new', [ControleController::class, 'provinciasNew'])->name('provincias.new');
        Route::post('/controle/provincias/create', [ControleController::class, 'createProvincia'])->name('provincias.create');
        Route::delete('/controle/provincias/{id}', [ControleController::class, 'deleteProvincia'])->name('provincias.delete');
        Route::get('/controle/provincias/edit/{id}', [ControleController::class, 'editProvincia'])->name('provincias.edit');
        Route::post('/controle/provincias/update', [ControleController::class, 'updateProvincia'])->name('provincias.update');
    // SETORES
    Route::get('/controle/setores', [ControleController::class, 'setores'])->name('setores.index');
        Route::get('/controle/setores/new', function () { return view('authenticated.controle.setores.newSetor'); })->name('setores.new');
        Route::post('/controle/setores/create', [ControleController::class, 'createSetor'])->name('setores.create');
        Route::delete('/controle/setores/{id}', [ControleController::class, 'deleteSetor'])->name('setores.delete');
        Route::get('/controle/setores/edit/{id}', [ControleController::class, 'editSetor'])->name('setores.edit');
        Route::post('/controle/setores/update', [ControleController::class, 'updateSetor'])->name('setores.update');
    // COMUNIDADES
    Route::get('/controle/comunidades', [ControleController::class, 'comunidades'])->name('comunidades');
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
    // OBRAS
    Route::get('/controle/obras', [ControleController::class, 'obras'])->name('obras.index');
        Route::get('/controle/obras/new', [ControleController::class, 'obrasNew'])->name('obras.new');
        Route::post('/controle/obras/create', [ControleController::class, 'createObra'])->name('obras.create');
        Route::delete('/controle/obras/{id}', [ControleController::class, 'deleteObra'])->name('obras.delete');
        Route::get('/controle/obras/edit/{id}', [ControleController::class, 'editObra'])->name('obras.edit');
        Route::post('/controle/obras/update', [ControleController::class, 'updateObra'])->name('obras.update');
        Route::post('/search/obras', [ControleController::class, 'searchObra'])->name('searchObra');
        // ENDERECOS_OBRAS
        Route::get('/controle/obras/map/{id}', [ControleController::class, 'enderecosObras'])->name('obras.map');
            Route::get('/controle/enderecosObra/{id_obra}/new', [ControleController::class, 'enderecosObrasNew'])->name('enderecosObra.new');
            Route::post('/controle/enderecosObra/create', [ControleController::class, 'createEnderecoObra'])->name('enderecosObra.create');
            Route::delete('/controle/enderecosObra/{id}', [ControleController::class, 'deleteEnderecoObra'])->name('enderecosObra.delete');
            Route::get('/controle/enderecosObra/{id_obra}/edit/{id}', [ControleController::class, 'editEnderecoObra'])->name('enderecosObra.edit');
            Route::post('/controle/enderecosObra/update', [ControleController::class, 'updateEnderecoObra'])->name('enderecosObra.update');
            Route::post('/search/enderecosObra', [ControleController::class, 'searchEndereco'])->name('searchEnderecoObra');

    //Pessoal
    // Egressos
    //  Route::get('/pessoal/egressos', [PessoalController::class, 'egressos']);
    //  Route::get('/pessoal/egressos/new', [PessoalController::class, 'egressosNew'])->name('egressos.new');
    //     Route::post('/pessoal/egressos/create', [PessoalController::class, 'createEgressos'])->name('egressos.create');
    //     Route::delete('/pessoal/egressos/{id}', [PessoalController::class, 'deleteEgressos'])->name('egressos.delete');
    //     Route::get('/pessoal/egressos/edit/{id}', [PessoalController::class, 'editEgressos'])->name('egressos.edit');
    //     Route::post('/pessoal/egressos/update', [PessoalController::class, 'updateEgressos'])->name('egressos.update');
    //     Route::post('/search/egressos', [PessoalController::class, 'searchEgresso'])->name('searchEgresso');

    // //transferencia
    //     Route::get('/pessoal/transferencia', [PessoalController::class, 'transferencia']);
    //     Route::get('/pessoal/transferencia/new', [PessoalController::class, 'transferenciaNew'])->name('transferencia.new');
    //        Route::post('/pessoal/transferencia/create', [PessoalController::class, 'createTransferencia'])->name('transferencia.create');
    //        Route::get('/pessoal/transferencia/edit/{id}', [PessoalController::class, 'editTransferencia'])->name('transferencia.edit');
    //        Route::post('/pessoal/transferencia/update', [PessoalController::class, 'updateTransferencia'])->name('transferencias.update');
    //        Route::post('/search/transferencia', [PessoalController::class, 'searchTransferencia'])->name('searchTransferencia');

            //falecimentos
            // Route::get('/pessoal/falecimentos', [PessoalController::class, 'falecimentos']);
            // Route::get('/pessoal/falecimentos/new', [PessoalController::class, 'falecimentosNew'])->name('falecimentos.new');
            //    Route::post('/pessoal/falecimentos/create', [PessoalController::class, 'createFalecimentos'])->name('falecimentos.create');
            //    Route::delete('/pessoal/falecimentos/{id}', [PessoalController::class, 'deleteFalecimentos'])->name('falecimentos.delete');
            //    Route::get('/pessoal/falecimentos/edit/{id}', [PessoalController::class, 'editFalecimentos'])->name('falecimentos.edit');
            //    Route::post('/pessoal/falecimentos/update', [PessoalController::class, 'updateFalecimentos'])->name('falecimentos.update');
            //    Route::post('/search/falecimentos', [PessoalController::class, 'searchFalecimentos'])->name('searchFalecimentos');


// MENU PESSOAS
        // PESSOAS
        Route::get('/pessoal/pessoas', [PessoalController::class, 'pessoas'])->name('pessoas.index');
        Route::get('/pessoal/pessoas/new', [PessoalController::class, 'pessoasNew'])->name('pessoas.new');
        Route::post('/pessoal/pessoas/create', [PessoalController::class, 'storePessoa'])->name('pessoas.store');
        Route::delete('/pessoal/pessoas/{id}', [PessoalController::class, 'deletePessoa'])->name('pessoas.delete');
        Route::get('/pessoal/pessoas/edit/{id}', [PessoalController::class, 'editPessoa'])->name('pessoas.edit');
        Route::post('/pessoal/pessoas/update', [PessoalController::class, 'updatePessoa'])->name('pessoas.update');
        Route::get('/search/pessoas', [PessoalController::class, 'searchPessoa'])->name('searchPessoa');
        // OPERACOES DO MENU PESSOAS
        // ARQUIVOS
        Route::resource('/pessoal/pessoas/{pessoa_id}/arquivos', ArquivoController::class)->names('pessoas.arquivos');
            Route::get('/search/pessoas/arquivos', [ArquivoController::class, 'searchArquivo'])->name('searchArquivo');
        // ATIVIDADES
        Route::resource('/pessoal/pessoas/{pessoa_id}/atividades', AtividadeController::class)->names('pessoas.atividades');
            Route::get('/search/pessoas/atividades', [AtividadeController::class, 'searchAtividade'])->name('searchAtividade');
        // CURSOS
        Route::resource('/pessoal/pessoas/{pessoa_id}/cursos', CursoController::class)->names('pessoas.cursos');
            Route::get('/search/pessoas/cursos', [CursoController::class, 'searchCurso'])->name('searchCurso');
        // PARENTES
        Route::resource('/pessoal/pessoas/{pessoa_id}/parentes', ParenteController::class)->names('pessoas.parentes');
            Route::get('/search/pessoas/parentes', [ParenteController::class, 'searchParente'])->name('searchParente');
        // FORMACOES
        Route::resource('/pessoal/pessoas/{pessoa_id}/formacoes', FormacoesController::class)->names('pessoas.formacoes');
            Route::get('/search/pessoas/formacoes', [FormacoesController::class, 'searchFormacao'])->name('searchFormacao');
        // FUNCOES
        Route::resource('/pessoal/pessoas/{pessoa_id}/funcoes', FuncaoController::class)->names('pessoas.funcoes');
            Route::get('/search/pessoas/funcoes', [FuncaoController::class, 'searchFuncao'])->name('searchFuncao');
        // HABILIDADES
        Route::resource('/pessoal/pessoas/{pessoa_id}/habilidades', HabilidadeController::class)->names('pessoas.habilidades');
            Route::get('/search/pessoas/habilidades', [HabilidadeController::class, 'searchHabilidade'])->name('searchHabilidade');
        // HISTORICO
        Route::resource('/pessoal/pessoas/{pessoa_id}/historico', HistoricoController::class)->names('pessoas.historico');
            Route::get('/search/pessoas/historico', [HistoricoController::class, 'searchHistorico'])->name('searchHistorico');
        // ITINERARIOS
        Route::resource('/pessoal/pessoas/{pessoa_id}/itinerarios', ItinerarioController::class)->names('pessoas.itinerarios');
            Route::get('/search/pessoas/itinerarios', [ItinerarioController::class, 'searchItinerario'])->name('searchItinerario');
        // OCORRENCIAS MEDICAS
        Route::resource('/pessoal/pessoas/{pessoa_id}/ocorrenciasMedicas', OcorrenciaMedicaController::class)->names('pessoas.ocorrenciasMedicas');
            Route::get('/search/pessoas/ocorrenciasMedicas', [HabilidadeController::class, 'searchOcorrenciaMedica'])->name('searchOcorrenciaMedica');


        Route::get('/pessoal/pessoas/{pessoa_id}/imprimir', [PessoalController::class, 'pessoasImprimir'])->name('pessoas.imprimir');
        Route::post('/pessoal/pessoas/pdf', [FpdfController::class, 'relatorioPessoa'])->name('pessoas.pdf');
        // Route::get('/pessoal/pessoas/edit', [PessoalController::class, 'pessoasEdit'])->name('pessoas.edit');

    //Pessoal
    // Egressos
    Route::get('/pessoal/egressos', [PessoalController::class, 'egressos'])->name('egressos');
    Route::get('/pessoal/egressos/new', [PessoalController::class, 'egressosNew'])->name('egressos.new');
       Route::post('/pessoal/egressos/create', [PessoalController::class, 'createEgressos'])->name('egressos.create');
       Route::delete('/pessoal/egressos/{id}', [PessoalController::class, 'deleteEgressos'])->name('egressos.delete');
       Route::get('/pessoal/egressos/edit/{id}', [PessoalController::class, 'editEgressos'])->name('egressos.edit');
       Route::post('/pessoal/egressos/update', [PessoalController::class, 'updateEgressos'])->name('egressos.update');
       Route::post('/search/egressos', [PessoalController::class, 'searchEgresso'])->name('searchEgresso');

   //transferencia
       Route::get('/pessoal/transferencia', [PessoalController::class, 'transferencia'])->name('transferencias');
       Route::get('/pessoal/transferencia/new', [PessoalController::class, 'transferenciaNew'])->name('transferencia.new');
          Route::post('/pessoal/transferencia/create', [PessoalController::class, 'createTransferencia'])->name('transferencia.create');
          Route::delete('/pessoal/transferencia/{id}', [PessoalController::class, 'deleteTransferencia'])->name('transferencia.delete');
          Route::get('/pessoal/transferencia/edit/{id}', [PessoalController::class, 'editTransferencia'])->name('transferencia.edit');
          Route::post('/pessoal/transferencia/update', [PessoalController::class, 'updateTransferencia'])->name('transferencia.update');
          Route::post('/search/transferencia', [PessoalController::class, 'searchTransferencia'])->name('searchTransferencia');

          Route::get('/pessoas/{id}/origem', [PessoalController::class, 'getOrigem'])->name('transferencia.origem');


           //falecimentos
           Route::get('/pessoal/falecimentos', [PessoalController::class, 'falecimentos'])->name('falecimentos.index');
           Route::get('/pessoal/falecimentos/new', [PessoalController::class, 'falecimentosNew'])->name('falecimentos.new');
              Route::post('/pessoal/falecimentos/create', [PessoalController::class, 'createFalecimentos'])->name('falecimentos.create');
              Route::delete('/pessoal/falecimentos/{id}', [PessoalController::class, 'deleteFalecimentos'])->name('falecimentos.delete');
              Route::get('/pessoal/falecimentos/edit/{id}', [PessoalController::class, 'editFalecimentos'])->name('falecimentos.edit');
              Route::post('/pessoal/falecimentos/update', [PessoalController::class, 'updateFalecimentos'])->name('falecimentos.update');
              Route::post('/search/falecimentos', [PessoalController::class, 'searchFalecimentos'])->name('searchFalecimentos');
       //Admissao
            //   Route::get('/pessoal/admissoes', [PessoalController::class, 'admissoes']);
            //   Route::get('/pessoal/admissoes/new', [PessoalController::class, 'admissoesNew'])->name('admissoes.new');
            //      Route::post('/pessoal/admissoes/create', [PessoalController::class, 'createAdmissoes'])->name('admissoes.create');
            //      Route::delete('/pessoal/admissoes/{id}', [PessoalController::class, 'deleteAdmissoes'])->name('admissoes.delete');
            //      Route::get('/pessoal/admissoes/edit/{id}', [PessoalController::class, 'editAdmissoes'])->name('admissoes.edit');
            //      Route::post('/pessoal/admissoes/update', [PessoalController::class, 'updateAdmissoes'])->name('admissoes.update');
            //      Route::post('/search/admissoes', [PessoalController::class, 'searchAdmissoes'])->name('searchAdmissoes');
       ///Aniversário
                //  Route::get('/pessoal/aniversarios', [PessoalController::class, 'aniversarios']);
                //  Route::get('/pessoal/aniversarios/new', [PessoalController::class, 'aniversariosNew'])->name('aniversarios.new');
                //     Route::post('/pessoal/aniversarios/create', [PessoalController::class, 'createAniversarios'])->name('aniversarios.create');
                //     Route::delete('/pessoal/aniversarios/{id}', [PessoalController::class, 'deleteAniversarios'])->name('aniversarios.delete');
                //     Route::get('/pessoal/aniversarios/edit/{id}', [PessoalController::class, 'editAniversarios'])->name('aniversarios.edit');
                //     Route::post('/pessoal/aniversarios/update', [PessoalController::class, 'updateAniversarios'])->name('aniversarios.update');
                //     Route::post('/search/aniversarios', [PessoalController::class, 'searchAniversarios'])->name('searchAniversarios');

                           ///Atual
            // Route::get('/pessoal/titulos', [PessoalController::class, 'titulos']);
            // Route::get('/pessoal/titulos/new', [PessoalController::class, 'titulosNew'])->name('titulos.new');
            //     Route::post('/pessoal/titulos/create', [PessoalController::class, 'createTitulo'])->name('titulos.create');
            //     Route::delete('/pessoal/titulos/{id}', [PessoalController::class, 'deleteTitulo'])->name('titulos.delete');
            //     Route::get('/pessoal/titulos/edit/{id}', [PessoalController::class, 'editTitulo'])->name('titulos.edit');
            //     Route::post('/pessoal/titulos/update', [PessoalController::class, 'updateTitulo'])->name('titulos.update');
            //     Route::post('/search/titulos', [PessoalController::class, 'searchTitulo'])->name('searchTitulo');


        ///Civil
            //    Route::get('/pessoal/civil', [PessoalController::class, 'civil']);
            //    Route::get('/pessoal/civil/new', [PessoalController::class, 'civilNew'])->name('civil.new');
            //        Route::post('/pessoal/civil/create', [PessoalController::class, 'createCivil'])->name('civil.create');
            //        Route::delete('/pessoal/civil/{id}', [PessoalController::class, 'deleteCivil'])->name('civil.delete');
            //        Route::get('/pessoal/civil/edit/{id}', [PessoalController::class, 'editCivil'])->name('civil.edit');
            //        Route::post('/pessoal/civil/update', [PessoalController::class, 'updateCivil'])->name('civil.update');
            //        Route::post('/search/civil', [PessoalController::class, 'searchCivil'])->name('searchCivill');
        ///mediaIdade
            //    Route::get('/pessoal/mediaIdade', [PessoalController::class, 'mediaIdade']);
            //    Route::get('/pessoal/mediaIdade/new', [PessoalController::class, 'mediaIdadeNew'])->name('medIdade.new');
            //        Route::post('/pessoal/mediaIdade/create', [PessoalController::class, 'createmediaIdade'])->name('mediaIdade.create');
            //        Route::delete('/pessoal/mediaIdade/{id}', [PessoalController::class, 'deletemediaIdade'])->name('mediaIdade.delete');
            //        Route::get('/pessoal/mediaIdade/edit/{id}', [PessoalController::class, 'editmediaIdade'])->name('mediaIdade.edit');
            //        Route::post('/pessoal/mediaIdade/update', [PessoalController::class, 'updatemediaIdade'])->name('mediaIdade.update');
            //        Route::post('/search/mediaIdade', [PessoalController::class, 'searchmediaIdade'])->name('searchmediaIdade');

       ///Capitulos
    //   Route::get('/pessoal/capitulos', [PessoalController::class, 'capitulos']);
    //   Route::get('/pessoal/capitulos/new', [PessoalController::class, 'medCapitulos'])->name('capitulos.new');
    //       Route::post('/pessoal/capitulos/create', [PessoalController::class, 'createCapitulos'])->name('capitulos.create');
    //       Route::delete('/pessoal/capitulos/{id}', [PessoalController::class, 'deleteCapitulos'])->name('capitulos.delete');
    //       Route::get('/pessoal/capitulos/edit/{id}', [PessoalController::class, 'editCapitulos'])->name('capitulos.edit');
    //       Route::post('/pessoal/capitulos/update', [PessoalController::class, 'updateCapitulos'])->name('capitulos.update');
    //       Route::post('/search/capitulos', [PessoalController::class, 'searchCapitulos'])->name('searchCapitulos');



    // ----------------------------------------------- RELATORIOS ----------------------------------------------------------------------------------------------------------
    // PESSOAL
    Route::get('/relatorios/pessoal/origens', [RelatoriosController::class, 'origens'])->name('origens.imprimir');
    Route::get('/relatorios/pessoal/origens/pdf', [RelatoriosController::class, 'origensPdf'])->name('origens.pdf');

    Route::get('/relatorios/pessoal/egresso', [RelatoriosController::class, 'egresso'])->name('egresso.imprimir');
    Route::get('/relatorios/pessoal/egressos/pdf', [RelatoriosController::class, 'egressosPdf'])->name('egressos.pdf');

    Route::get('/relatorios/pessoal/transferencia', [RelatoriosController::class, 'transferencia'])->name('transferencia.imprimir');
    Route::get('/relatorios/pessoal/transferencia/pdf', [RelatoriosController::class, 'transferenciaPdf'])->name('transferencia.pdf');

    Route::get('relatorios/pessoal/falecimento', [RelatoriosController::class, 'falecimentos'])->name('falecimento.imprimir');
    Route::get('relatorios/pessoal/falecimento/pdf', [RelatoriosController::class, 'falecimentoPdf'])->name('falecimento.pdf');

    Route::get('relatorios/pessoal/admissoes', [RelatoriosController::class, 'admissoes'])->name('admissoes.imprimir');
    Route::get('relatorios/pessoal/admissoes/pdf', [RelatoriosController::class, 'admissoesPdf'])->name('admissoes.pdf');

    Route::get('relatorios/pessoal/aniversariante', [RelatoriosController::class, 'aniversariante'])->name('aniversariante.imprimir');
    Route::get('relatorios/pessoal/aniversariante/pdf', [RelatoriosController::class, 'aniversariantePdf'])->name('aniversariante.pdf');

    Route::get('relatorios/pessoal/atividade', [RelatoriosController::class, 'atividade'])->name('atividade.imprimir');
    Route::get('relatorios/pessoal/atividade/pdf', [RelatoriosController::class, 'atividadePdf'])->name('atividade.pdf');

    Route::get('relatorios/pessoal/titulos', [RelatoriosController::class, 'titulos'])->name('titulos.imprimir');
    Route::get('relatorios/pessoal/titulos/pdf', [RelatoriosController::class, 'titulosPdf'])->name('titulos.pdf');

    Route::get('relatorios/pessoal/atual', [RelatoriosController::class, 'atual'])->name('atual.imprimir');
    Route::get('relatorios/pessoal/atual/pdf', [RelatoriosController::class, 'atualPdf'])->name('atual.pdf');

    Route::get('relatorios/pessoal/civil', [RelatoriosController::class, 'civil'])->name('civil.imprimir');
    Route::get('relatorios/pessoal/civil/pdf', [RelatoriosController::class, 'civilPdf'])->name('civil.pdf');

    Route::get('relatorios/pessoal/pessoa', [RelatoriosController::class, 'pessoa'])->name('pessoa.imprimir');
    Route::get('relatorios/pessoal/pessoa/pdf', [RelatoriosController::class, 'pessoaPdf'])->name('pessoa.pdf');

    Route::get('relatorios/pessoal/mediaIdade', [RelatoriosController::class, 'mediaIdade'])->name('mediaIdade.imprimir');
    Route::get('relatorios/pessoal/mediaIdade/pdf', [RelatoriosController::class, 'mediaIdadePdf'])->name('mediaIdade.pdf');

    Route::get('relatorios/pessoal/capitulos', [RelatoriosController::class, 'capitulos'])->name('capitulos.imprimir');
    Route::get('relatorios/pessoal/capitulos/pdf', [RelatoriosController::class, 'capitulosdf'])->name('capitulos.pdf');


// REDE

    Route::get('/relatorio/rede/provincias', [RelatoriosController::class, 'provincias'])->name('provincias.imprimir');
    Route::get('/relatorio/rede/provincias/pdf', [FpdfController::class, 'provinciasPdf'])->name('provincias.pdf');

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

    Route::get('/relatorio/controle/comunidade/{id}', [FpdfController::class, 'comunidadePdf'])->name('comunidade.imprimir');
    Route::get('/relatorio/rede/comunidades', [RelatoriosController::class, 'comunidades'])->name('comunidades.imprimir');
    Route::get('/relatorio/rede/comunidades/pdf', [RelatoriosController::class, 'comunidadesPdf'])->name('comunidades.pdf');

    Route::get('/relatorio/rede/cemiterios', [RelatoriosController::class, 'cemiterios'])->name('cemiterios.imprimir');
    Route::get('/relatorio/rede/cemiterios/pdf', [RelatoriosController::class, 'cemiteriosPdf'])->name('cemiterios.pdf');

    Route::get('/relatorio/rede/associacoes', [RelatoriosController::class, 'associacoes'])->name('associacoes.imprimir');
    Route::get('/relatorio/rede/associacoes/pdf', [RelatoriosController::class, 'associacoesPdf'])->name('associacoes.pdf');



    // Endpoint para verificar o status do job
    Route::get('/api/check-job-status/{jobId}', function ($jobId) {
     // Consulta a tabela de jobs
     $job = DB::table('jobs')->where('id', $jobId)->first();

     if ($job) {
         $payload = json_decode($job->payload);

         // Verifica se o job é do tipo GeneratePdfJob
         if ($payload->displayName === 'App\\Jobs\\GeneratePdfJob') {
             // Verifica o status do job
             if ($job->attempts > 0 && $job->reserved_at === null) {
                 // Job está em execução
                 return response()->json(['status' => 'pending']);
             } else {
                 // Job concluído
                 return response()->json(['status' => 'completed']);
             }
         } else {
             // Job não encontrado ou não é do tipo esperado
             return response()->json(['status' => 'error', 'message' => 'Job não encontrado']);
         }
     } else {
         // Job não encontrado na tabela de jobs
         return response()->json(['status' => 'error', 'message' => 'Job não encontrado']);
     }
    });

    Route::get('/pdf/view/{filename}', [PdfController::class, 'view'])->name('pdf.view');
    Route::get('/pdf/download/{filename}', [PdfController::class, 'download'])->name('pdf.download');


    Route::get('/testpdf', [FpdfController::class, 'provinciasPdf']);

});


