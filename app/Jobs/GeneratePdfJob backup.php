<?php

namespace App\Jobs;

use App\Events\JobProgressUpdate;
use App\Events\PDFGenerated;
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
use setasign\Fpdi\Fpdi;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempPath;
    protected $view;
    protected $outputPath;
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @param string $view
     * @param string $outputPath
     */

    public function __construct($tempPath, string $view, string $outputPath, string $filename)
    {

        $this->tempPath = $tempPath;
        $this->view = $view;
        $this->outputPath = $outputPath;
        $this->filename = $filename;
    }


    /**
     * Execute the job.
     *
     * @return void
     */

     public function handle(): void
     {
        $data = json_decode(Storage::get($this->tempPath), true);

        $chunkedData = array_chunk($data, 50); // Dividir os dados em chunks de 50 registros
        $totalChunks = count($chunkedData);   // Total de chunks
Log::info($totalChunks);
        $page = 1;

        foreach ($chunkedData as $chunk) {
            $this->gerarPdf($chunk, $page);
            $page++;
        }

        $this->combinePdfs($totalChunks); // Passar o número total de chunks como $totalPages

        Storage::delete($this->tempPath);
    }


     public function gerarPdf($data, $page)
     {
         try {
             $options = new Options();
             $options->set('defaultFont', 'Arial');
             $dompdf = new Dompdf($options);

             $html = View::make($this->view, ['dados' => $data])->render();

             $dompdf->loadHtml($html);
             $dompdf->setPaper('A4', 'landscape');
             $dompdf->render();

             $output = $dompdf->output();

             usleep(2000000); // 2 segundos
             $filename = "{$this->outputPath}_page_{$page}.pdf";
             Storage::put($filename, $output);
            //  Broadcast::event(new PDFGenerated($filename));

             // APAGA O PDF DEPOIS DE 48 HORAS
             $deleteJob = new DeletePdfJob($filename);
             $deleteJob->delay(now()->addHours(48));
             dispatch($deleteJob);

         } catch (\Exception $e) {
             Log::error('Erro ao gerar PDF: ' . $e->getMessage());
         }
     }

     public function combinePdfs($totalPages)
     {
         try {
             $pdf = new Fpdi();
             $outputDir = storage_path('app/public/pdfs');
             $combinedPdfPath = "{$outputDir}/{$this->filename}.pdf";

             // Garantir que o diretório existe
             if (!file_exists($outputDir)) {
                 mkdir($outputDir, 0777, true);
             }

             // Array para rastrear páginas já adicionadas
             $pagesAdded = [];

             for ($page = 1; $page <= $totalPages; $page++) {
                 $filename = "{$this->outputPath}_page_{$page}.pdf";
                 if (Storage::exists($filename)) {
                     $filePath = storage_path('app/' . $filename);
                     $pageCount = $pdf->setSourceFile($filePath);

                     for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                         $tplIdx = $pdf->importPage($pageNo);

                         // Verificar se a página já foi adicionada
                         if (!isset($pagesAdded[$pageNo])) {
                             $pdf->AddPage();
                             $pdf->useTemplate($tplIdx);
                             $pagesAdded[$pageNo] = true;
                         }
                     }

                     // Limpar o arquivo temporário
                     Storage::delete($filename);
                 }
             }

             // Garantir que o caminho completo é válido
             if (!file_exists(dirname($combinedPdfPath))) {
                 mkdir(dirname($combinedPdfPath), 0777, true);
             }

             // Salvar o PDF combinado
             $pdf->Output($combinedPdfPath, 'F');

             // Disparar evento de PDF gerado
             Broadcast::event(new PDFGenerated($this->filename));

         } catch (\Exception $e) {
             Log::error('Erro ao combinar PDFs: ' . $e->getMessage());
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
