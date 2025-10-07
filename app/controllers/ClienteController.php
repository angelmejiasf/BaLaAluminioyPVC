<?php

require_once '../config/config.php';

require_once '../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

class ClienteController {
    
    public function index() {
         $this->dashboard();
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: /index.php?url=auth/login");
            exit();
        }

        global $pdo;
        $id_usuario = $_SESSION['id_usuario'];

        // Solo extrae sus propias facturas y presupuestos
        $facturas = $this->getFacturasCliente($id_usuario);
        $presupuestos = $this->getPresupuestosCliente($id_usuario);

        require '../app/views/cliente/dashboard.php';
    }

    private function getFacturasCliente($id_usuario) {
        global $pdo;
        $sql = "SELECT numero_factura, fecha, monto, pdf, estado, descripcion 
                FROM facturas 
                WHERE id_usuario = :id_usuario 
                ORDER BY fecha DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getPresupuestosCliente($id_usuario) {
       global $pdo;
        $sql = "SELECT id_presupuesto, numero_presupuesto, fecha, monto, pdf, estado, descripcion
                FROM presupuestos 
                WHERE id_usuario = :id_usuario 
                ORDER BY fecha DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function firmarPresupuesto() {
        session_start();
        global $pdo;
        $id_presupuesto = intval($_GET['id'] ?? 0);
    
        $stmt = $pdo->prepare("SELECT numero_presupuesto, descripcion, monto FROM presupuestos WHERE id_presupuesto = ?");
        $stmt->execute([$id_presupuesto]);
        $presupuesto = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$presupuesto) {
            $_SESSION['mensaje_error'] = "Presupuesto no encontrado.";
            header("Location: /index.php?url=cliente/dashboard");
            exit();
        }
    
        require '../app/views/cliente/firmar_presupuesto.php';
    }

    

    public function guardarFirmaPresupuesto() {

            session_start();
            global $pdo;
            $json = json_decode(file_get_contents('php://input'), true);
    
            $id_presupuesto = intval($json['presupuesto_id'] ?? 0);
            $firmaBase64 = $json['firma'] ?? '';
    
            if ($id_presupuesto && $firmaBase64) {
                // Guardar imagen firmada
                $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
                $firmaBase64 = str_replace(' ', '+', $firmaBase64);
                $firmaData = base64_decode($firmaBase64);
                $fileNameFirma = "firma_presupuesto_".$id_presupuesto.".png";
                $rutaFirma = __DIR__."/../uploads/firmas/".$fileNameFirma;
                file_put_contents($rutaFirma, $firmaData);
    
                // Conseguir el PDF original
                $stmt = $pdo->prepare("SELECT pdf FROM presupuestos WHERE id_presupuesto = ?");
                $stmt->execute([$id_presupuesto]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    echo json_encode(['success' => false, 'error' => 'Presupuesto no encontrado']);
                    exit;
                }
                
                $nombrePdf = $row['pdf'];
                $rutaPdfOriginal = __DIR__ . '/../uploads/presupuestos/' . $nombrePdf;
    
                if (!file_exists($rutaPdfOriginal)) {
                    echo json_encode(['success' => false, 'error' => 'Archivo PDF original no encontrado']);
                    exit;
                }
    
                // Obtener nombre completo usuario de sesión
                $nombre = $_SESSION['nombre'] ?? '';
                $apellido1 = $_SESSION['apellido1'] ?? '';
                $apellido2 = $_SESSION['apellido2'] ?? '';
                $nombreCompleto = trim("$nombre $apellido1 $apellido2");
    
                // Sobrescribir PDF firmado
                $this->sobrescribirPdfFirmado($rutaPdfOriginal, $rutaFirma, $nombreCompleto);
    
                // Marcar presupuesto como firmado
                $stmtUpdate = $pdo->prepare("UPDATE presupuestos SET estado = 'aceptado' WHERE id_presupuesto = ?");
                $stmtUpdate->execute([$id_presupuesto]);
    
                echo json_encode(['success'=>true]);
            } else {
                echo json_encode(['success'=>false]);
            }
    
            exit;
        }
    
        private function sobrescribirPdfFirmado($rutaPdfOriginal, $rutaFirmaPng, $nombreCompleto) {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($rutaPdfOriginal);
            $tplIdx = $pdf->importPage(1);
            $size = $pdf->getTemplateSize($tplIdx);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplIdx);

            $pdf->AddPage();

            if (file_exists($rutaFirmaPng)) {
                $pdf->Image($rutaFirmaPng, 20, 30, 80, 40);
            }

            $pdf->SetXY(20, 75);
            $pdf->SetFont('Helvetica', '', 12);
            $pdf->Cell(0, 10, 'Firma del cliente: ' . $nombreCompleto);

            $pdf->Output('F', $rutaPdfOriginal);
        }


}


    

