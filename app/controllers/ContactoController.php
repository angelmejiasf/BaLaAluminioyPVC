<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ContactoController {
    public function mostrarFormulario() {
        $mensaje = ''; // Mensaje vacío por defecto
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $asunto = trim($_POST['asunto'] ?? '');
            $mensajeUsuario = trim($_POST['mensaje'] ?? '');

            if (!$email || empty($nombre) || empty($mensajeUsuario) || empty($asunto)) {
                $mensaje = 'Por favor completa todos los campos correctamente.';
            } else {
            $destino = "balaaluminioypvc.sl@gmail.com";
            //$correoRemitente = "angelmejiastecvical@gmail.com"; // Cambia por tu email profesional
            $asuntoCorreo = $asunto;
            
            $contenido = "Nombre: $nombre\n";
            $contenido .= "Email: $email\n";
            $contenido .= "Asunto: $asunto\n";
            $contenido .= "Mensaje:\n$mensajeUsuario\n";
            
            $headers = "From: contacto@balaaluminioypvcsl.com\r\n"; // Email de tu dominio
            $headers .= "Reply-To: $email\r\n";  // Responder al cliente
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            
            mail($destino, $asuntoCorreo, $contenido, $headers);


                if (mail($destino, $asuntoCorreo, $contenido, $headers)) {
                    $mensaje = 'Mensaje enviado correctamente. Gracias por contactarnos.';
                } else {
                    $mensaje = 'Error al enviar el mensaje.';
                }
            }
        }
        require '../app/views/static/contacto.php';

    }
}



?>