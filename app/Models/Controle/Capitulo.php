<?php

namespace App\Models\Controle;

use App\Models\EquipeCapitulos;
use App\Models\Provincia;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capitulo extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_provincia_id',
        'tipo',
        'numero',
        'data',
        'detalhes',
        'situacao',
    ];


    protected $searchable = ['numero', 'data', 'cod_provincia_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['data', 'deleted_at'];

    public function equipes()
    {
        return $this->hasMany(EquipeCapitulos::class, 'cod_capitulo_id', 'numero');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'cod_provincia_id');
    }
}
