<?php

namespace App\Models\Pessoal;

use App\Models\Cadastros\Doenca;
use App\Models\Controle\Cemiterio;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Falecimento extends Model
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

        public function pessoa()
        {
            return $this->belongsTo(Pessoa::class, 'cod_pessoa');
        }

        public function doenca()
        {
            return $this->belongsTo(Doenca::class, 'cod_doenca1');
        }

        public function cemiterio()
        {
            return $this->belongsTo(Cemiterio::class, 'cod_cemiterio');
        }


        protected $searchable = ['descricao', 'situacao'];

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */


}
