<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
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
        'estado',
        'pais',
        'caixapostal',
        'telefone1',
        'telefone2',
        'telefone3',
        'email1',
        'email2',
        'email3',
        'site',
        'responsavel',
        'fundacao',
        'encerramento',
        'protecao',
        'detalhes',
        'situacao',
    ];

    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function desativarRegistros()
    {
        // Atualiza os registros onde a coluna situacao for igual a 0
        $this->where('situacao', 0)->update(['deleted_at' => now()]);
    }
}
