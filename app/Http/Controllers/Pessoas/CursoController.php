<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Controle\Diocese;
use App\Models\Curso;
use App\Models\Provincia;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index($pessoa_id)
    {

        $dados = Curso::where('cod_pessoa_id', $pessoa_id)->withoutTrashed()->paginate(10);
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

    public function create()
    {
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
