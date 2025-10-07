<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Empresa especializada en construcción de productos de aluminio y PVC">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/recuperarcontraseña.css">
    <script src="/js/script.js"></script>
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
</head>

<body>

    <div class="form-container">
        <a href="/index.php?url=auth/login" class="back-button">
            <i class="fa fa-arrow-left"></i> Volver atrás
        </a>
        <h2>Recuperar contraseña</h2>

        <form method="post" action="index.php?url=auth/forgotPassword" novalidate>
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" required>
                <?php if (!empty($mensaje)): ?>
                    <div class="form-message"><?= htmlspecialchars($mensaje) ?></div>
                <?php endif; ?>
            <input type="submit" value="Enviar solicitud">
        </form>

      
    </div>

</body>

</html>
