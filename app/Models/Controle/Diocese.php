<?php

namespace App\Models\Controle;

use App\Models\Cidade;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diocese extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codantigo',
        'cod_cidade_id',
        'descricao',
        'endereco',
        'cep',
        'pais',
        'telefone1',
        'telefone2',
        'telefone3',
        'caixapostal',
        'email',
        'site',
        'fundacao',
        'encerramento',
        'bispo',
        'detalhes',
        'situacao',
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fundacao', 'encerramento', 'deleted_at'];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id');
    }


}
