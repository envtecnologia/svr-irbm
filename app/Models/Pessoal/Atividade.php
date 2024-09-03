<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\TipoAtividade;
use App\Models\Cidade;
use App\Models\Controle\Obra;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atividade extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipoatividade_id',
        'cod_obra_id',
        'cod_comunidade_id',
        'cod_cidade_id',
        'endereco',
        'cep',
        'datainicio',
        'datafinal',
        'responsavel',
        'detalhes',
        'situacao',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa_id')->withTrashed();
    }

    public function obra()
    {
        return $this->belongsTo(Obra::class, 'cod_obra_id')->withTrashed();
    }

    public function tipo_atividade()
    {
        return $this->belongsTo(TipoAtividade::class, 'cod_tipoatividade_id')->withTrashed();
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id')->withTrashed();
    }

    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */



}
