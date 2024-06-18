<?php

namespace App\Models\Pessoal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arquivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipoarquivo_id',
        'descricao',
        'caminho',
        'situacao'
    ];
}
