<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Doenca;
use App\Models\Cadastros\TipoTratamento;
use App\Models\Pessoal\OcorrenciaMedica;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\TipoOcorrencia;
use Illuminate\Http\Request;

class OcorrenciaMedicaController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = OcorrenciaMedica::orderBy('datainicio', 'desc')->withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);
        // dd($dados);
        foreach ($dados as $dado) {

            $doenca = Doenca::find($dado->cod_doenca_id);
            $dado->setAttribute('doenca', $doenca);

            $tratamento = TipoTratamento::find($dado->cod_tipo_tratamento_id);
            $dado->setAttribute('tratamento', $tratamento);

            $ocorrencia = TipoOcorrencia::find($dado->cod_tipo_ocorrencia_id);
            $dado->setAttribute('ocorrencia', $ocorrencia);

        }

        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.ocorrencias_medicas.ocorrencias_medicas', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {
        $pessoa = Pessoa::find($pessoa_id);
        $doencas = Doenca::orderBy('descricao')->withoutTrashed()->get();
        $tipo_tratamento = TipoTratamento::orderBy('descricao')->withoutTrashed()->get();
        $tipo_ocorrencia = TipoOcorrencia::orderBy('descricao')->withoutTrashed()->get();




        return view('authenticated.pessoal.pessoas.ocorrencias_medicas.newOcorrencia_medica', compact(
            'pessoa',
            'pessoa_id',
            'doencas',
            'tipo_tratamento',
            'tipo_ocorrencia'
        ));

        // Retorna a view para criar um novo post
    }

    public function store(Request $request, $pessoa_id)
    {

        $dados = new OcorrenciaMedica();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_doenca_id = $request->cod_doenca_id;
        $dados->cod_tipo_tratamento_id = $request->cod_tipo_tratamento_id;
        $dados->cod_tipo_ocorrencia_id = $request->cod_tipo_ocorrencia_id;
        $dados->datainicio = $request->datainicio;
        if(!empty($request->datafinal)){
            $dados->datafinal = $request->datafinal;
        }
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.ocorrenciasMedicas.index', ['pessoa_id' => $pessoa_id])->with('success', 'Ocorrência Médica cadastrada com sucesso!');
    }

    public function show($id) {}

    public function edit($pessoa_id, $ocorrenciaId)
    {
        $dados = OcorrenciaMedica::find($ocorrenciaId);
        $doencas = Doenca::orderBy('descricao')->withoutTrashed()->get();
        $tipo_tratamento = TipoTratamento::orderBy('descricao')->withoutTrashed()->get();
        $tipo_ocorrencia = TipoOcorrencia::orderBy('descricao')->withoutTrashed()->get();
        // dd($dados);

        return view('authenticated.pessoal.pessoas.ocorrencias_medicas.newOcorrencia_medica', compact(
            'dados',
            'pessoa_id',
            'doencas',
            'tipo_tratamento',
            'tipo_ocorrencia'
        ));
    }

    public function update(Request $request, $pessoa_id, $ocorrenciaId) {

        $dados = OcorrenciaMedica::where('id', $ocorrenciaId)->first();
        $dados->cod_pessoa_id = $pessoa_id;
        $dados->cod_doenca_id = $request->cod_doenca_id;
        $dados->cod_tipo_tratamento_id = $request->cod_tipo_tratamento_id;
        $dados->cod_tipo_ocorrencia_id = $request->cod_tipo_ocorrencia_id;
        $dados->datainicio = $request->datainicio;
        if(!empty($request->datafinal)){
            $dados->datafinal = $request->datafinal;
        }
        $dados->detalhes = $request->detalhes;
        $dados->save();

        return redirect()->route('pessoas.ocorrenciasMedicas.index', ['pessoa_id' => $pessoa_id])->with('success', 'Ocorrência Médica editada com sucesso!');

    }

    public function destroy($pessoa_id, $ocorrenciaId)
    {

        $dados = OcorrenciaMedica::find($ocorrenciaId);

        if (!$dados) {
            return redirect()->route('pessoas.ocorrenciasMedicas.index', ['pessoa_id' => $pessoa_id])->with('error', 'Ocorrência Médica não encontrada.');
        }

        $dados->delete();

        return redirect()->route('pessoas.ocorrenciasMedicas.index', ['pessoa_id' => $pessoa_id])->with('success', 'Ocorrência Médica excluída com sucesso.');
    }
}
