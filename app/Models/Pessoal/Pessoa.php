<?php

namespace App\Models\Pessoal;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'codantigo',
        'cod_tipopessoa_id',
        'cod_provincia_id',
        'cod_comunidade_id',
        'cod_nacionalidade_id',
        'cod_origem_id',
        'cod_raca_id',
        'cod_profissao_id',
        'cod_escolaridade_id',
        'cod_usuario_id',
        'cod_local_id',
        'nome',
        'sobrenome',
        'opcao',
        'religiosa',
        'datanascimento',
        'aniversario',
        'rh',
        'gruposanguineo',
        'email',
        'foto',
        'rg',
        'rgdata',
        'rgorgao',
        'inscricaonumero',
        'inscricaodata',
        'inscricaoorgao',
        'cpf',
        'titulo',
        'titulozona',
        'titulosecao',
        'habilitacaonumero',
        'habilitacaodata',
        'habilitacaocategoria',
        'habilitacaolocal',
        'ctps',
        'passaporte',
        'ctpsserie',
        'secretaria',
        'pis',
        'inss',
        'aposentadoriadata',
        'aposentadoriaorgao',
        'endereco',
        'cep',
        'telefone1',
        'telefone2',
        'telefone3',
        'datacadastro',
        'horacadastro',
        'situacao'
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'datanascimento',
        'rgdata',
        'inscricaodata',
        'habilitacaodata',
        'aposentadoriadata',
        'datacadastro'
    ];
}
