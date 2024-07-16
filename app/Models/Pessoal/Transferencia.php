<?php

namespace App\Models\Pessoal;

use App\Models\Controle\Comunidade;
use App\Models\Provincia;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    use HasFactory,SoftDeletes, Searchable;

    protected $fillable = [
        'cod_pessoa',
        'cod_provinciaori',
        'cod_comunidadeori',
        'cod_provinciades',
        'cod_comunidadedes',
        'data_transferencia'

    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'cod_pessoa');
    }

    public function com_origem()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidadeori');
    }

    public function com_des()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidadedes');
    }

    public function prov_origem()
    {
        return $this->belongsTo(Provincia::class, 'cod_provinciaori');
    }

    public function prov_des()
    {
        return $this->belongsTo(Provincia::class, 'cod_provinciades');
    }



}
