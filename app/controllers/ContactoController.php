<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactoController {
    public function mostrarFormulario() {
        $mensaje = ''; // Mensaje vacío por defecto
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $asunto = trim($_POST['asunto'] ?? '');
            $mensajeUsuario = trim($_POST['mensaje'] ?? '');

            if (!$email || empty($nombre) || empty($mensajeUsuario) || empty($asunto)) {
                $mensaje = '❌ Por favor completa todos los campos correctamente.';
            } else {
                $mail = new PHPMailer(true);
                try {
                    // Configuración SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'angelmejiasfigueras2002@gmail.com';           // Cambia a tu email
                    $mail->Password   = 'srlf bdca sgbl yvlg'; // Usa password de app si usas 2FA
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Remitente y destinatario
                    $mail->setFrom('balaaluminioypvc.sl@gmail.com', 'BaLa Aluminio y PVC');
                    $mail->addAddress('balaaluminioypvc.sl@gmail.com', 'Administración');
                    $mail->addReplyTo($email, $nombre);

                    // Contenido del mensaje
                    $mail->CharSet = 'UTF-8';
                    $mail->isHTML(false);
                    $mail->Subject = $asunto;
                    $contenido = "Nombre: $nombre\nEmail: $email\nAsunto: $asunto\nMensaje:\n$mensajeUsuario\n";
                    $mail->Body = $contenido;

                    $mail->send();
                    $mensaje = '✅ Mensaje enviado correctamente. Gracias por contactarnos.';
                } catch (Exception $e) {
                    $mensaje = "❌ Error al enviar el mensaje.";
                }
            }
        }
        require '../app/views/static/contacto.php';
    }
}



?>