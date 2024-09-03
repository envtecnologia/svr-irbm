<?php

namespace App\Models\Pessoal;

use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itinerario extends Model
{
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa_id',
        'cod_comunidade_atual_id',
        'cod_comunidade_anterior_id',
        'cod_comunidade_destino_id',
        'chegada',
        'saida',
        'detalhes',
        'situacao',
        'endereco_atual',
        'endereco_anterior',
        'endereco_destino',
        'cep_atual',
        'cep_anterior',
        'cep_destino',
        'cod_cidade_atual',
        'cod_cidade_anterior',
        'cod_cidade_destino',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['chegada', 'saida', 'deleted_at'];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa_id');
    }

    public function com_anterior()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_anterior_id');
    }

    public function com_atual()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_atual_id');
    }

    public function com_destino()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_destino_id');
    }

    public function cid_anterior()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_anterior');
    }

    public function cid_atual()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_atual');
    }

    public function cid_destino()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_destino');
    }

}
