<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\TipoHabilidade;
use App\Models\Pessoal\Habilidade;
use App\Models\Pessoal\Pessoa;
use Illuminate\Http\Request;

class HabilidadeController extends Controller
{
    public function index($pessoa_id)
    {

        $id = $pessoa_id;
        $pessoa = Pessoa::find($pessoa_id);
        $dados = Habilidade::withoutTrashed()->where('cod_pessoa_id', $pessoa_id)->paginate(10);

        foreach ($dados as $dado) {

            $tipo_habilidade = TipoHabilidade::find($dado->cod_tipo_habilidade_id);
            $dado->setAttribute('tipo_habilidade', $tipo_habilidade);

        }
        $dados->appends(['id' => $id]);

        return view('authenticated.pessoal.pessoas.habilidades.habilidades', [
            'dados' => $dados,
            'id' => $id,
            'pessoa' => $pessoa,
            'pessoa_id' => $pessoa_id,
            'provincias' => []
        ]);
    }

    public function create($pessoa_id)
    {
        $tipos_habilidade = Habilidade::withoutTrashed()->get();


        return view('authenticated.pessoal.pessoas.habilidade.habilidades', compact(
            'tipos_habilidade',
            'pessoa_id'
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

    public function edit($habilidade)
    {
        // Retorna a view para editar um post existente
    }

    public function update(Request $request, $id)
    {
        // Atualiza um post existente no banco de dados
    }

    public function destroy($habilidade)
    {
        // Remove um post do banco de dados
    }
}
