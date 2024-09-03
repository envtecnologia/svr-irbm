<?php

namespace App\Models\Pessoal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoOcorrencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codantigo',
        'cod_tipo_tratamento',
        'descricao',
        'detalhes',
        'situacao',
    ];

    protected $dates = ['deleted_at'];
    protected $table = 'tipos_ocorrencias';
}
