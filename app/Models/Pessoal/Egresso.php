<?php

namespace App\Models\Pessoal;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egresso extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codantigo',
        'cod_diocese_id',
        'cod_cidade_id',
        'descricao',
        'endereco',
        'cep',
        'telefone1',
        'telefone2',
        'telefone3',
        'caixapostal',
        'email',
        'site',
        'fundacao',
        'encerramento',
        'paroco',
        'detalhes',
        'situacao',
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

}
