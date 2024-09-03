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
        $dados = OcorrenciaMedica::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

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
        $doencas = Doenca::withoutTrashed()->get();
        $tipo_tratamento = TipoTratamento::withoutTrashed()->get();
        $tipo_tratamentoocorrencia = TipoOcorrencia::withoutTrashed()->get();




        return view('authenticated.pessoal.pessoas.ocorrencias_medicas.ocorrencias_medicas', compact(
            'doencas',
            'tipo_tratamento',
            'tipo_tratamentoocorrencia'
        ));

        // Retorna a view para criar um novo post
    }

    public function store(Request $request)
    {
        // Armazena um novo post no banco de dados
    }

    public function show($id)
    {
        // Exibe um post específico
    }

    public function edit($id)
    {
        // Retorna a view para editar um post existente
    }

    public function update(Request $request, $id)
    {
        // Atualiza um post existente no banco de dados
    }

    public function destroy($id)
    {
        // Remove um post do banco de dados
    }
}
