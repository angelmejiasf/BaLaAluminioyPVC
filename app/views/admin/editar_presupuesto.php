<?php
// Protegemos esta página para que solo acceda el admin (id_usuario == 1)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: /public/index.php?url=auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Presupuesto</title>
  <link rel="stylesheet" href="/css/formcreacion.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="form-container">
  <div class="div_volver"> 
  <a href="/index.php?url=admin/listarPresupuestos" class="panel-button">
      <i class="fa fa-arrow-left"></i> Volver atrás
    </a>
  </div>
  <h2>Editar presupuesto</h2>

  <!-- Selector de presupuesto (si quieres permitir cambiar entre presupuestos fácilmente) -->
  <form method="GET" action="/public/index.php">
    <input type="hidden" name="url" value="admin/editarPresupuesto">
    <!-- Si tienes un array $todos_los_presupuestos, puedes hacer un selector aquí -->
    <!--
    <label for="id_presupuesto">Selecciona un presupuesto:</label>
    <select name="id" id="id_presupuesto" onchange="this.form.submit()">
      <option value="">-- Selecciona --</option>
      <?php foreach ($todos_los_presupuestos as $p): ?>
        <option value="<?= $p['id_presupuesto'] ?>" <?= (isset($presupuesto) && $presupuesto && $presupuesto['id_presupuesto'] == $p['id_presupuesto']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($p['numero_presupuesto']) ?> - <?= htmlspecialchars($p['descripcion']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    -->
  </form>

  <?php if ($presupuesto): ?>
  <form action="/public/index.php?url=admin/actualizarPresupuesto" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_presupuesto" value="<?= htmlspecialchars($presupuesto['id_presupuesto']) ?>">
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($presupuesto['id_usuario']) ?>">

    <label>Número de presupuesto:</label>
    <input type="number" name="numero_presupuesto" value="<?= htmlspecialchars($presupuesto['numero_presupuesto']) ?>" required>

    <label>Descripción:</label>
    <input type="text" name="descripcion" value="<?= htmlspecialchars($presupuesto['descripcion']) ?>" required>

    <label>Precio:</label>
    <input type="number" step="0.01" name="monto" value="<?= htmlspecialchars($presupuesto['monto']) ?>" required>
    
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" required value="<?= htmlspecialchars($presupuesto['fecha']) ?>">

    <label>Estado:</label>
    <select name="estado" required>
      <option value="enviado" <?= ($presupuesto['estado'] == 'enviado') ? 'selected' : '' ?>>Enviado</option>
      <option value="aceptado" <?= ($presupuesto['estado'] == 'aceptado') ? 'selected' : '' ?>>Aceptado</option>
      <option value="rechazado" <?= ($presupuesto['estado'] == 'rechazado') ? 'selected' : '' ?>>Rechazado</option>
      <!-- Agrega más estados si los tienes -->
    </select>

    <input type="submit" value="Actualizar presupuesto">
  </form>
  <?php endif; ?>
</div>

</body>
</html>
