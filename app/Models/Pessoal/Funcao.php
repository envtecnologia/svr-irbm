<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\TipoFuncao;
use App\Models\Controle\Comunidade;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcao extends Model
{
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_tipo_funcao_id',
        'cod_provincia_id',
        'cod_comunidade_id',
        'datainicio',
        'datafinal',
        'detalhes',
        'situacao',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['datainicio', 'datafinal', 'deleted_at'];
    protected $table = 'funcoes';

    public function comunidade()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'cod_provincia_id');
    }

    public function tipo_funcao()
    {
        return $this->belongsTo(TipoFuncao::class, 'cod_tipo_funcao_id');
    }

}
