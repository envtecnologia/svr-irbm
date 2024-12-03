<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\Origem;
use App\Models\Cadastros\Profissao;
use App\Models\Cadastros\TipoPessoa;
use App\Models\Cidade;
use App\Models\Controle\Comunidade;
use App\Models\Controle\Diocese;
use App\Models\Escolaridade;
use App\Models\Provincia;
use App\Models\Raca;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'codantigo',
        'cod_tipopessoa_id',
        'cod_provincia_id',
        'cod_comunidade_id',
        'cod_nacionalidade_id',
        'cod_origem_id',
        'cod_raca_id',
        'cod_profissao_id',
        'cod_escolaridade_id',
        'cod_usuario_id',
        'cod_local_id',
        'nome',
        'sobrenome',
        'opcao',
        'religiosa',
        'datanascimento',
        'aniversario',
        'rh',
        'gruposanguineo',
        'email',
        'email2',
        'foto',
        'rg',
        'rgdata',
        'rgorgao',
        'inscricaonumero',
        'inscricaodata',
        'inscricaoorgao',
        'cpf',
        'titulo',
        'titulozona',
        'titulosecao',
        'habilitacaonumero',
        'habilitacaodata',
        'habilitacaocategoria',
        'habilitacaolocal',
        'ctps',
        'passaporte',
        'ctpsserie',
        'secretaria',
        'pis',
        'inss',
        'aposentadoriadata',
        'aposentadoriaorgao',
        'endereco',
        'cep',
        'telefone1',
        'telefone2',
        'telefone3',
        'datacadastro',
        'horacadastro',
        'situacao'
    ];


    protected $searchable = ['descricao', 'situacao'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'datanascimento',
        'rgdata',
        'inscricaodata',
        'habilitacaodata',
        'aposentadoriadata',
        'datacadastro'
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_local_id');
    }

    public function local()
    {
        return $this->belongsTo(Cidade::class, 'cod_local_id')->withTrashed();
    }

    public function origem()
    {
        return $this->belongsTo(Origem::class, 'cod_origem_id')->withTrashed();
    }

    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'cod_diocese_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'cod_provincia_id')->withTrashed();
    }

    public function comunidade()
    {
        return $this->belongsTo(Comunidade::class, 'cod_comunidade_id');
    }

    public function egresso()
    {
        return $this->hasOne(Egresso::class, 'cod_pessoa');
    }

    public function falecimento()
    {
        return $this->hasOne(Falecimento::class, 'cod_pessoa');
    }

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class, 'cod_pessoa');
    }

    public function tipo_pessoa()
    {
        return $this->belongsTo(TipoPessoa::class, 'cod_tipopessoa_id');
    }

    public function raca()
    {
        return $this->belongsTo(Raca::class, 'cod_raca_id');
    }

    public function escolaridade()
    {
        return $this->belongsTo(Escolaridade::class, 'cod_escolaridade_id');
    }

    public function profissao()
    {
        return $this->belongsTo(Profissao::class, 'cod_profissao_id');
    }

    public function categoria()
    {
        return $this->belongsTo(TipoPessoa::class, 'cod_tipopessoa_id');
    }
    public function itinerarios()
    {
        return $this->hasMany(Itinerario::class, 'cod_pessoa_id');
    }

    public function formacoes()
    {
        return $this->hasMany(Formacao::class, 'cod_pessoa_id');
    }

}

