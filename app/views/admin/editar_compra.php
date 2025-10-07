<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: /index.php?url=auth/login");
    exit();
}

// Mostrar mensaje si existe
if (!empty($_SESSION['mensaje_compra'])) {
    echo '<div class="success-message">' . htmlspecialchars($_SESSION['mensaje_compra']) . '</div>';
    unset($_SESSION['mensaje_compra']);
}

// Protegemos esta página para que solo acceda el admin (id_usuario == 1)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location /public/index.php?url=auth/login");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
  <link rel="stylesheet" href="/css/formcreacion.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
<div class="form-container">
    <a href="/index.php?url=admin/contabilidad&tipo=compras" class="panel-button">
        <i class="fa fa-arrow-left"></i> Volver a Compras
    </a>

    <h2>Editar Compra</h2>

    <form action="/index.php?url=admin/actualizarCompra" method="POST" enctype="multipart/form-data" >

        <input type="hidden" name="id_compra" value="<?= htmlspecialchars($compra['id_compra']) ?>">

        <label for="concepto">Concepto:</label>
        <input type="text" id="concepto" name="concepto" required value="<?= htmlspecialchars($compra['concepto']) ?>">

        <label for="precio">Precio (€):</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required value="<?= htmlspecialchars($compra['precio']) ?>">

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required value="<?= htmlspecialchars($compra['fecha']) ?>">

        <label for="adjunto">Adjuntar archivo (foto o PDF) - opcional:</label>

        <?php if (!empty($compra['adjunto'])): ?>
            <div class="concepto-item">
                Archivo actual: 
                <a href="/index.php?url=admin/verAdjuntoCompra&archivo=<?= urlencode($compra['adjunto']) ?>" target="_blank" class="panel-button">
                    <?= htmlspecialchars($compra['adjunto']) ?>
                </a>
            </div>
        <?php endif; ?>

        <input type="file" id="adjunto" name="adjunto" accept="image/*,application/pdf" class="input-imagen">

        <!-- Guardar el nombre del archivo actual para referencia -->
        <input type="hidden" name="adjunto_actual" value="<?= htmlspecialchars($compra['adjunto']) ?>">

        <input type="submit" value="Actualizar" class="añadir-button">

    </form>
</div>

</body>
</html>