<?php
require_once __DIR__ . '/../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = $_GET['url'] ?? 'home/index';
$params = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

$controllerName = ucfirst($params[0]) . 'Controller';
$method = $params[1] ?? 'index';

$controllerPath = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

// Incluir config para conexión a BD
require_once __DIR__ . '/../config/config.php';  // Aquí se asigna $pdo como PDO

if (file_exists($controllerPath)) {
    require_once $controllerPath;

    // Pasar $pdo al constructor del controlador
    $controller = new $controllerName($pdo);

    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Método no encontrado.";
    }
} else {
    echo "Controlador no encontrado.";
}

?>
