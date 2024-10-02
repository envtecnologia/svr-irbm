<?php

namespace App\Models;

use App\Models\Controle\Comunidade;
use App\Models\Controle\Obra;
use App\Models\Pessoal\Pessoa;
use App\Models\Pessoal\Transferencia;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codantigo',
        'cod_cidade_id',
        'descricao',
        'endereco',
        'cep',
        'estado',
        'pais',
        'caixapostal',
        'telefone1',
        'telefone2',
        'telefone3',
        'email1',
        'email2',
        'email3',
        'site',
        'responsavel',
        'fundacao',
        'encerramento',
        'protecao',
        'detalhes',
        'situacao',
    ];

    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function desativarRegistros()
    {
        // Atualiza os registros onde a coluna situacao for igual a 0
        $this->where('situacao', 0)->update(['deleted_at' => now()]);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade_id');
    }


    public function pessoas()
    {
        return $this->hasMany(Pessoa::class, 'cod_provincia_id');
    }
    public function comunidades()
    {
        return $this->hasMany(Comunidade::class, 'cod_provincia_id');
    }
    public function obras()
    {
        return $this->hasMany(Obra::class, 'cod_provincia_id');
    }

    public function provincias_origem()
    {
        return $this->hasMany(Transferencia::class, 'cod_provinciaori');
    }
    public function provincias_destino()
    {
        return $this->hasMany(Transferencia::class, 'cod_provinciades');
    }

}
