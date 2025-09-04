<?php
session_start();

// Borra todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la cookie de sesión, también se debe borrar.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión.
session_destroy();

// Redirigir al formulario de inicio de sesión
header("Location: /app/views/auth/inicioareaprivada.php");
exit();
?>
