<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_comunidade_id',
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
    protected $table = 'enderecos_comunidades';

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id');
    }

}
