<?php

namespace App\Models\Controle;

use App\Models\Cadastros\Area;
use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\EnderecoObra;
use App\Models\Pessoal\Pessoa;
use App\Models\Provincia;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comunidade extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codantigo',
        'cod_paroquia_id',
        'cod_area_id',
        'cod_provincia_id',
        'cod_setor_id',
        'cod_cidade_id',
        'descricao',
        'endereco',
        'cep',
        'pais',
        'estado',
        'telefone1',
        'telefone2',
        'telefone3',
        'caixapostal',
        'email1',
        'email2',
        'email3',
        'site',
        'fundacao',
        'encerramento',
        'detalhes',
        'situacao',
        'foto',
        'foto2'
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fundacao', 'encerramento', 'deleted_at'];
    protected $table = 'comunidades';

    public function pessoas()
    {
        return $this->hasMany(Pessoa::class, 'cod_comunidade_id');
    }


    public function paroquia()
    {
        return $this->belongsTo(Paroquia::class, 'cod_paroquia_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'cod_area_id');
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'cod_setor_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'cod_provincia_id');
    }

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'cod_diocese_id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id');
    }

    public function enderecos(){
        return $this->hasMany(Endereco::class, 'cod_comunidade_id');
    }

}
