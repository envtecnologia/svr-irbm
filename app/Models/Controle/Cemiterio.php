<?php

namespace App\Models\Controle;

use App\Models\Cidade;
use App\Models\Pessoal\Falecimento;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cemiterio extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_cidade_id',
        'descricao',
        'endereco',
        'cep',
        'telefone1',
        'telefone2',
        'detalhes',
        'contato',
        'situacao',
    ];


    protected $searchable = ['descricao', 'cod_cidade_id', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id');
    }
    public function falecimentos()
    {
        return $this->hasMany(Falecimento::class, 'cod_cemiterio');
    }
}
