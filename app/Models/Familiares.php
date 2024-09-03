<?php

namespace App\Models;

use App\Models\Cadastros\Parentesco;
use App\Models\Pessoal\Pessoa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familiares extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_pessoa_id',
        'cod_parentesco_id',
        'cod_cidade_id',
        'nome',
        'endereco',
        'cep',
        'sexo',
        'datanascimento',
        'datafalecimento',
        'telefone1',
        'telefone2',
        'telefone3',
        'email',
        'detalhes'
    ];

    protected $table = 'familiares';

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa_id');
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class, 'cod_parentesco_id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id')->withTrashed();
    }
}
