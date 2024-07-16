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
        'cod_pessoa',
        'data_saida',
        'data_readmissao',
        'detalhes',
        'situacao',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa');
    }


    protected $searchable = ['situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

}
