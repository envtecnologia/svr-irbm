<?php

namespace App\Jobs;

use App\Events\JobProgressUpdate;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempPath;
    protected $view;
    protected $outputPath;
    protected $filename;
    protected $chunkzar;
    protected $records;
    protected $orientation;

    /**
     * Create a new job instance.
     *
     * @param string $view
     * @param array $data
     * @param string $outputPath
     */

    public function __construct($tempPath, string $view, string $outputPath, string $filename, bool $chunkzar = true, int $records = 0, string $orientation = 'landscape')
    {

        $this->tempPath = $tempPath;
        $this->view = $view;
        $this->outputPath = $outputPath;
        $this->filename = $filename;
        $this->chunkzar = $chunkzar;
        $this->records = $records;
        $this->orientation = $orientation;
    }


    /**
     * Execute the job.
     *
     * @return void
     */

     public function handle(): void
     {

        set_time_limit(0);
        $data = json_decode(Storage::get($this->tempPath), true);
        $records = $this->records;

        if($this->chunkzar){
            $records = count($data);
            $data = array_chunk($data, 100);
        }

        // dd($data);
        // Log:info($data);
        $this->gerarPdf($data, $records, $this->orientation);
        Storage::delete($this->tempPath);
    }

    public function gerarPdf($data, $records, $orientation){
        try {

            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($options);

            $html = View::make($this->view, ['chunks' => $data, 'records' => $records])->render();

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', $orientation);
            $dompdf->render();

            $output = $dompdf->output();

            Storage::put($this->outputPath, $output);

            usleep(4000000);
            Broadcast::event(new \App\Events\PDFGenerated($this->filename));

            // APAGA O PDF DEPOIS DE 48 HORAS
            $deleteJob = new DeletePdfJob($this->outputPath);
            $deleteJob->delay(now()->addHours(48));
            dispatch($deleteJob);

        } catch (\Exception $e) {
            Log::error('Erro no Handle do GeneratePdfJob: ' . $e->getMessage());
            Broadcast::event(new \App\Events\PDFError());
        }
    }

    public function startTiming(){
        for ($i = 0; $i <= 100; $i++) {
            // Atualizar o progresso ou tempo restante e enviar para o WebSocket
            $progress = $i;
            $this->sendProgressUpdate($progress);

            // Simular processamento
            usleep(50000); // 50 milissegundos
        }

        // Finalizar o job
        $this->sendProgressUpdate(100);
    }

    protected function sendProgressUpdate($progress)
    {
        // Enviar atualização de progresso para o WebSocket usando Laravel WebSockets ou Reverb
        broadcast(new JobProgressUpdate($progress))->toOthers();
    }
}
