<?php
// Protegemos esta página para que solo acceda el admin (id_usuario == 1)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: /index.php?url=auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Factura</title>
  <link rel="stylesheet" href="/css/formcreacion.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="form-container">
  <div class="div_volver"> 
    <a href="/index.php?url=admin/listarFacturas" class="panel-button">
      <i class="fa fa-arrow-left"></i> Volver atrás
    </a>
  </div>
  <h2>Editar factura</h2>
  <!-- Selector de factura (si quieres permitir cambiar entre facturas fácilmente) -->
  <form method="GET" action="/public/index.php">
    <input type="hidden" name="url" value="admin/editarFactura">
    
  </form>

  <?php if ($factura): ?>
  <form action="/public/index.php?url=admin/actualizarFactura" method="POST">
    <input type="hidden" name="id_factura" value="<?= htmlspecialchars($factura['id_factura']) ?>">
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($factura['id_usuario']) ?>">
    <label>Número de factura:</label>
    <input type="text" name="numero_factura" value="<?= htmlspecialchars($factura['numero_factura']) ?>" required>

    <label>Descripción:</label>
    <input type="text" name="descripcion" value="<?= htmlspecialchars($factura['descripcion']) ?>" required>

    <label>Precio:</label>
    <input type="number" step="0.01" name="monto" value="<?= htmlspecialchars($factura['monto']) ?>" required>
    
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" required value="<?= htmlspecialchars($factura['fecha']) ?>">



    <label>Estado:</label>
    <select name="estado" required>
      <option value="pendiente" <?= ($factura['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
      <option value="pagada" <?= ($factura['estado'] == 'pagada') ? 'selected' : '' ?>>Pagada</option>
      <option value="atrasada" <?= ($factura['estado'] == 'atrasada') ? 'selected' : '' ?>>Atrasada</option>
      <!-- Agrega más estados si los tienes -->
    </select>

    <!-- Si quieres permitir cambiar el PDF, añade aquí el input de archivo -->

    <input type="submit" value="Actualizar factura">
  </form>
  <?php else: ?>
    <p>No se encontró la factura solicitada.</p>

  <?php endif; ?>
</div>

</body>
</html>
