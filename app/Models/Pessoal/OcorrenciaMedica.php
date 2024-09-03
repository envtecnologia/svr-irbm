<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\Doenca;
use App\Models\Cadastros\TipoTratamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OcorrenciaMedica extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cod_pessoa_id',
        'cod_doenca_id',
        'cod_tipo_tratamento_id',
        'cod_tipo_ocorrencia_id',
        'datainicio',
        'datafinal',
        'detalhes'
    ];

    protected $dates = ['deleted_at'];
    protected $table = 'ocorrencias_medicas';

    public function doenca()
    {
        return $this->belongsTo(Doenca::class, 'cod_doenca_id');
    }

    public function tratamento()
    {
        return $this->belongsTo(TipoTratamento::class, 'cod_tipo_tratamento_id');
    }

    public function ocorrencia()
    {
        return $this->belongsTo(TipoOcorrencia::class, 'cod_tipo_ocorrencia_id');
    }
}
