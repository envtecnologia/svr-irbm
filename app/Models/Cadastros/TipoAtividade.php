<?php

namespace App\Models\Cadastros;

use App\Models\Pessoal\Atividade;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoAtividade extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao',
    ];


    protected $searchable = ['descricao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = 'tipo_atividades';


    public function comunidades(){
        return $this->hasMany(Atividade::class, 'cod_tipoatividade_id');
    }
}
