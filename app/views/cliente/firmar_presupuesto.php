<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /index.php?url=auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Firmar Presupuesto</title>
    <link rel="stylesheet" href="/css/firma.css">
    <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="/js/firma.js"></script>
</head>
<body>
<div class="presupuesto-info">
    <h2>Firmar Presupuesto</h2>
    <p><strong>Nº:</strong> <?= htmlspecialchars($presupuesto['numero_presupuesto']) ?></p>
    <p><strong>Concepto:</strong> <?= htmlspecialchars($presupuesto['descripcion']) ?></p>
    <p><strong>Importe:</strong> <?= number_format($presupuesto['monto'], 2, ',', '.') ?> €</p>
</div>
<div class="firma-container">
    <canvas id="canvas-firma" width="350" height="150"></canvas>
    <div class="firma-botones">
        <button type="button" id="btn-guardar-firma" class="panel-button">Guardar firma</button>
        <button type="button" id="btn-limpiar-firma" class="panel-button">Limpiar</button>
        <a href="/index.php?url=cliente/dashboard" class="panel-button">Cancelar</a>
    </div>
</div>
</body>
</html>
