<?php
require_once '../config/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {

    
    public function cerrarSesion() {
        session_start();          // Iniciamos sesión para poder destruirla
        session_unset();          // Limpiamos todas las variables de sesión
        session_destroy();        // Destruimos la sesión
    
        // Redirigimos a la página de inicio de sesión
        header("Location: /index.php?url=auth/login");
        exit();
    }

    public function login() {
        require_once __DIR__ . '/../views/auth/inicioareaprivada.php';
    }

    public function procesarLogin() {
    session_start();

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    global $pdo;

    $stmt = $pdo->prepare("SELECT id_usuario, contrasena , nombre FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario'] = $user['id_usuario'];
        $_SESSION['nombre'] = $user['nombre'];

        // Redirigir según ID
        if ($user['id_usuario'] == 1) {
             header("Location: /index.php?url=admin");
            exit();
        } else {
            header("Location: /index.php?url=cliente/dashboard");;
            exit();
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
        require_once '../app/views/auth/inicioareaprivada.php';
    }

    
    }

    private $db;

    public function __construct($databaseConnection)
    {
        $this->db = $databaseConnection;  // Inyectar conexión PDO
    }

     public function forgotPassword() {
        $mensaje = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

            if (!$email) {
                $mensaje = '❌ Por favor, ingresa un correo válido.';
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

                    // Destinatarios
                    $mail->setFrom('balaaluminioypvc.sl@gmail.com', 'BaLa Aluminio y PVC');
                    $mail->addAddress('balaaluminioypvc.sl@gmail.com', 'Administración');

                    // Configurar Reply-To para que la empresa pueda responder al usuario
                    $mail->addReplyTo($email);

                    $mail->CharSet = 'UTF-8';       // Configura el charset a UTF-8
                    $mail->Encoding = 'base64';     // o 'quoted-printable', para codificación adecuada
                    // Contenido
                    $mail->isHTML(false);
                    $mail->Subject = '✅ Solicitud de recuperación de contraseña';
                    $mail->Body    = "❌ El usuario con correo $email ha solicitado recuperar su contraseña.\nPor favor, gestionar la incidencia.";

                    $mail->send();
                    $mensaje = '✅ Hemos enviado tu solicitud a nuestro equipo de soporte. Nos pondremos en contacto contigo pronto.';
                } catch (Exception $e) {
                    $mensaje = "❌ No se pudo enviar el mensaje.";
                }
            }
        }
        include __DIR__ . '/../views/cliente/forgot_password.php';
    }
    
}
