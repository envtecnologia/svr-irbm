<?php

namespace App\Models\Pessoal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formacao extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipo_formacao_id',
        'cod_comunidade_id',
        'cod_cidade_id',
        'data',
        'prazo',
        'detalhes',
        'situacao',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['data', 'deleted_at'];
    protected $table = 'formacoes';
}
