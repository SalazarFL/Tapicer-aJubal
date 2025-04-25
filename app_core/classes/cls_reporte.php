<?php
require_once(__CLS_PATH . "cls_mysql.php");
require_once(__ROOT__ . "/tapiceria-jubal/vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class cls_Reporte {
    private cls_Mysql $db;

    public function __construct() {
        $this->db = new cls_Mysql();
    }

    /**
     * Genera un reporte en PDF o Excel desde cualquier tabla y consulta
     */
    public function generarReporte(string $titulo, string $sql, string $formato = "pdf", array $encabezados = []) {
        $result = $this->db->sql_execute($sql);
        $datos = $this->db->sql_get_rows_assoc($result);

        if ($formato === "pdf") {
            $this->generarPDF($titulo, $encabezados, $datos);
        } elseif ($formato === "excel") {
            $this->generarExcel($titulo, $encabezados, $datos);
        } else {
            echo "Formato no soportado.";
        }
    }

    /**
     * Generar PDF con TCPDF
     */
    private function generarPDF(string $titulo, array $encabezados, array $datos) {
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tapicería Jubal');
        $pdf->SetTitle($titulo);
        $pdf->SetHeaderData(__ROOT__ . "/tapiceria-jubal/resources/logo.png", 30, "Tapicería Jubal", $titulo);
        $pdf->setHeaderFont(['helvetica', '', 12]);
        $pdf->setFooterFont(['helvetica', '', 10]);
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage();

        // Crear tabla HTML
        $html = '<table border="1" cellpadding="4" cellspacing="0">';
        $html .= '<thead><tr>';
        foreach ($encabezados as $encabezado) {
            $html .= '<th style="background-color:#eeba0b;font-weight:bold;">' . $encabezado . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($datos as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= '<td>' . htmlspecialchars($valor) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        ob_clean();
        $pdf->Output('reporte_' . strtolower(str_replace(" ", "_", $titulo)) . '.pdf', 'I');
    }

    /**
     * Generar Excel con PhpSpreadsheet
     */
    private function generarExcel(string $titulo, array $encabezados, array $datos) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(substr($titulo, 0, 31)); // Título corto (Excel tiene límite)

        // Escribir encabezados
        $col = 'A';
        foreach ($encabezados as $encabezado) {
            $sheet->setCellValue($col . '1', $encabezado);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        // Escribir filas
        $row = 2;
        foreach ($datos as $fila) {
            $col = 'A';
            foreach ($fila as $valor) {
                $sheet->setCellValue($col . $row, $valor);
                $col++;
            }
            $row++;
        }

        // Descargar archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . strtolower(str_replace(" ", "_", $titulo)) . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
