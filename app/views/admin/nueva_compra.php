<?php
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
  <title>Crear Compra</title>
  <link rel="stylesheet" href="/css/formcreacion.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="form-container">

<div class="div_volver"> 
    <a href="/index.php?url=admin/contabilidad&tipo=compras" class="panel-button">
        <i class="fa fa-arrow-left"></i> Volver atrás
    </a>
</div>

<h2 class="section-title">Nueva Compra</h2>

<?php
if (!empty($_SESSION['mensaje_compra'])) {
    echo '<div class="success-message">' . htmlspecialchars($_SESSION['mensaje_compra']) . '</div>';
    unset($_SESSION['mensaje_compra']);
}
?>

<form method="POST" action="/index.php?url=admin/guardarCompra" enctype="multipart/form-data">

  <label for="concepto">Concepto:</label>
  <input type="text" id="concepto" name="concepto" required>

  <label for="precio">Precio (€):</label>
  <input type="number" id="precio" name="precio" step="0.01" min="0" required>

  <label for="fecha">Fecha:</label>
  <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required>

  <label for="adjunto">Adjuntar archivo (foto o PDF) - opcional:</label>
  <input type="file" id="adjunto" name="adjunto" accept="image/*,application/pdf">

  <input type="submit" value="Crear compra">

</form>

</div>

</body>
</html>