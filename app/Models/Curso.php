<?php

namespace App\Models;

use App\Models\Cadastros\TipoCurso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipocurso_id',
        'datainicio',
        'datafinal',
        'datacancelamento',
        'local',
        'detalhes'
    ];

    public function tipo_curso()
    {
        return $this->belongsTo(TipoCurso::class, 'cod_tipocurso_id');
    }
}
