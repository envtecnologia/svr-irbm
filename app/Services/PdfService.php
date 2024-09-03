<?php

namespace App\Services;

use FPDF;

class PdfService extends FPDF
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
    }

        # Rodape
        function Footer()
        {
            $this->SetY(-15);
            $this->SetX(20);
            $this->SetTextColor(160);
            $this->SetFont('Arial', 'B', 8);
            $this->SetDrawColor(0);

            $data = date("d/m/Y");
            $hora = date("H");
            $minutos = date("i");

            $this->Cell(50, 5, iconv("utf-8", "iso-8859-1", "Impressão em: {$data}, {$hora}h{$minutos}min"), 0, 0, "L");
            $this->Cell(70, 5, iconv("utf-8", "iso-8859-1", "Sistema de Vida Religiosa (SRVICM)"), 0, 0, "C");
            $this->SetFont("Arial", "", 8);
            $this->Cell(50, 5, iconv("utf-8","iso-8859-1", "Página " . $this->PageNo() . " de {total}"), 0, 0, "R");
            $this->Ln();
        }

}
