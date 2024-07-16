<?php

namespace App\Listeners;

use App\Events\JobCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogJobCompletion
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobCompleted $event)
    {
        // Log ou gravação em banco de dados do job concluído
        Log::info('Job ID ' . $event->jobId . ' foi concluído com sucesso.');

        // Ou, se preferir, gravação em banco de dados
        // Exemplo: JobCompletionLog::create(['job_id' => $event->jobId]);
    }
}
