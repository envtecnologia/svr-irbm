<?php

namespace App\Models;

use App\Models\Controle\Cemiterio;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Obra;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codantigo',
        'cod_estado_id',
        'descricao'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'cod_estado_id')->withTrashed();
    }

    public function cemiterios()
    {
        return $this->hasMany(Cemiterio::class, 'cod_cidade_id');
    }

    public function comunidades()
    {
        return $this->hasMany(Comunidade::class, 'cod_cidade_id');
    }
    public function obras()
    {
        return $this->hasMany(Obra::class, 'cod_cidade_id');
    }
}
