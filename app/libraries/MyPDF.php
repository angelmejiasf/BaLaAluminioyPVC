<?php
// app/libraries/MyPDF.php
require_once __DIR__ . '/tfpdf/tfpdf.php';

class MyPDF extends tFPDF {
    function Header() {
        if ($this->PageNo() == 1) {
            // Construye correctamente la ruta absoluta a la imagen
            $logoPath = __DIR__ . '/../assets/images/logo.jpg';

            if ($logoPath && file_exists($logoPath)) {
                $this->Image($logoPath, 20, 8, 48);
            } else {
                $this->SetFont('Arial', '', 8);
                $this->Cell(0, 5, "Logo no encontrado: " . ($logoPath ?: "ruta no resuelta"), 0, 1, "L");
            }
        }

    }

    public function NbLines($w, $txt) {
        $cw = $this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb-1] == "\n") $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue;
            }
            if ($c == ' ') $sep = $i;
            $l += is_numeric($cw[$c] ?? null) ? $cw[$c] : 0;

            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                }
                else $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    public function getPageBreakTrigger() {
        return $this->PageBreakTrigger;
    }

    function CheckPageBreak($h)
{
    // Si la altura h no cabe, salta de página
    if($this->GetY() + $h > $this->PageBreakTrigger) {
        $this->AddPage($this->CurOrientation);
    }
}

}
