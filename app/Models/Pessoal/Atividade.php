<?php

namespace App\Models\Pessoal;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atividade extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipoatividade_id',
        'cod_obra_id',
        'cod_comunidade_id',
        'cod_cidade_id',
        'endereco',
        'cep',
        'datainicio',
        'datafinal',
        'responsavel',
        'detalhes',
        'situacao',
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'datainicio',
        'datafinal'
    ];
}
