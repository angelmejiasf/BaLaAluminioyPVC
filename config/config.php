<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u370401672_areaprivada');
define('DB_USER', 'root'); //u370401672_BaLaAdmin
define('DB_PASS', ''); //BaLaAdmin0225 

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage()); 
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Página en mantenimiento</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #e3eeff 0%, #f4f6fb 100%);
                font-family: 'Segoe UI', Arial, sans-serif;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 6px 32px rgba(231, 76, 60, 0.12);
                padding: 36px 32px 28px 32px;
                max-width: 400px;
                text-align: center;
            }
            .error-icon {
                color: #e74c3c;
                font-size: 2.3em;
                margin-bottom: 18px;
            }
            .error-title {
                color: #c0392b;
                font-size: 1.4em;
                font-weight: 700;
                margin-bottom: 10px;
            }
            .error-message {
                color: #2d3a4b;
                font-size: 1em;
                margin-bottom: 24px;
            }
            .back-button {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background-color: #74EF58;
                color: #222;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                font-size: 1em;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                box-shadow: 0 2px 8px rgba(33, 150, 243, 0.09);
                transition: background 0.2s, transform 0.2s;
                justify-content: center;
            }
            .back-button i {
                font-size: 1.1em;
            }
            .back-button:hover {
                background-color: #5fd143;
                color: #222;
                transform: translateY(-2px) scale(1.03);
                box-shadow: 0 6px 12px rgba(33, 150, 243, 0.12);
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <div class="error-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="error-title">Página en mantenimiento</div>
            <div class="error-message">Vuelva a intentarlo más tarde.</div>
            <a href="index.php?url=home" class="back-button">
                <i class="fa fa-arrow-left"></i> Volver atrás
            </a>
        </div>
    </body>
    </html>
    <?php
    exit;
}
