<?php
require_once '../config/config.php';
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


    
    
}
