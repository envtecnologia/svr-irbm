<?php

namespace App\Console\Commands;

use App\Models\Provincia;
use Illuminate\Console\Command;

class DesativarRegistrosCommand extends Command
{
    protected $signature = 'registros:desativar';
    protected $description = 'Desativa registros com situacao igual a 0';

    public function handle()
    {
        $registro = new Provincia();
        $registro->desativarRegistros();

        $this->info('Registros desativados com sucesso!');
    }
}
