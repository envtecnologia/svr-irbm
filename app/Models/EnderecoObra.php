<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnderecoObra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_obra_id',
        'cod_provincia_id',
        'cod_cidade_id',
        'datainicio',
        'datafinal',
        'endereco',
        'cep',
        'situacao',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at, datainicio, datafinal'];
    protected $table = 'enderecos_obras';
}
