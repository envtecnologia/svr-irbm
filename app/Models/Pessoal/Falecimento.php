
<?php

namespace App\Models\Pessoal;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egresso extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_pessoa',
        'cod_cemiterio',
        'cod_doenca1',
        'cod_doenca2',
        'cod_doenca3',
        'jazigo',
        'datafalecimento',
        'certidaonumero',
        'certidaodata',
        'certidaozona',
        'certidaolivro',
        'zona',
        'situacao',
        'cod_pessoa',
        'cod_cemiterio',
        'cod_doenca1',
        'cod_doenca2',
        'cod_doenca3'
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

}
