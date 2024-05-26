<?php

namespace App\Models\Controle;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Associacao extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_instituicoes_id',
        'cod_cidade_id',
        'cod_banco_id',
        'cnpj',
        'descricao',
        'responsavel',
        'endereco',
        'cep',
        'estado',
        'pais',
        'telefone1',
        'telefone2',
        'telefone3',
        'caixapostal',
        'email',
        'site',
        'agencia',
        'conta',
        'fundacao',
        'encerramento',
        'detalhes',
        'situacao'
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fundacao', 'encerramento', 'deleted_at'];
    protected $table = 'associacoes';
}
