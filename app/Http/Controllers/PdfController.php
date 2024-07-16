<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
        /**
         * Exibe o PDF diretamente no navegador.
         *
         * @param string $filename
         * @return \Illuminate\Http\Response
         */
        public function view($filename)
        {
            $path = 'public/pdfs/' . $filename;

            if (!Storage::exists($path)) {
                abort(404);
            }

            $file = Storage::get($path);
            $type = Storage::mimeType($path);

            return response($file, 200)->header('Content-Type', $type);
        }

        /**
         * Faz o download do PDF.
         *
         * @param string $filename
         * @return \Symfony\Component\HttpFoundation\StreamedResponse
         */
        public function download($filename)
        {
            $path = 'public/pdfs/' . $filename;

            if (!Storage::exists($path)) {
                abort(404);
            }

            return Storage::download($path);
        }
}
