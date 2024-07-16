<?php

namespace App\Models\Pessoal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parente extends Model
{
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_parentesco_id',
        'cod_cidade_id',
        'nome',
        'endereco',
        'cep',
        'sexo',
        'datanascimento',
        'datafalecimento',
        'telefone1',
        'telefone2',
        'telefone3',
        'email',
        'detalhes',
        'situacao',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['datanascimento', 'datafalecimento', 'deleted_at'];
}
