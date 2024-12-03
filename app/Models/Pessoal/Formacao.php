<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\TipoFormReligiosa;
use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formacao extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipo_formacao_id',
        'cod_comunidade_id',
        'cod_cidade_id',
        'data',
        'prazo',
        'detalhes',
        'situacao',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['data', 'deleted_at'];
    protected $table = 'formacoes';

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa_id');
    }

    public function comunidade()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_id');
    }

    public function tipo_formacao()
    {
        return $this->belongsTo(TipoFormReligiosa::class, 'cod_tipo_formacao_id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id')->withTrashed();
    }
}
