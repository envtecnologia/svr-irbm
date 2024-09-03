<?php

namespace App\Models\Controle;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codantigo',
        'cod_tipo_obra_id',
        'cod_provincia_id',
        'cod_setor_id',
        'cod_cidade_id',
        'cod_banco_id',
        'cnpj',
        'descricao',
        'endereco',
        'cep',
        'caixapostal',
        'telefone1',
        'telefone2',
        'telefone3',
        'email',
        'site',
        'fundacao',
        'encerramento',
        'agencia',
        'conta',
        'detalhes',
        'situacao',
        'foto',
        'foto2',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id')->withTrashed();
    }


}
