<?php

namespace App\Models;

use App\Models\Pessoal\Pessoa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipeCapitulos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_capitulo_id',
        'cod_pessoa_id',
        'principal'
    ];

    protected $table = 'equipe_capitulos';

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa_id');
    }
}
