<?php

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location /index.php?url=auth/login");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Factura</title>
  <link rel="stylesheet" href="/css/formcreacion.css"> 
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="form-container">
    <a href="/index.php?url=admin/listarFacturas" class="panel-button">
        <i class="fa fa-arrow-left"></i> Volver atrás
    </a>
    
  <h2>Crear nueva factura</h2>
  
  <form action="/public/index.php?url=admin/guardarFactura" method="POST" enctype="multipart/form-data">
    <label for="id_usuario">Asignar a usuario</label>
    <select name="id_usuario" required>
      <option value="">Seleccione un usuario</option>
      <?php foreach ($usuarios as $usuario): ?>
        <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>"><?= htmlspecialchars($usuario['usuario']) ?></option>
      <?php endforeach; ?>
    </select>

    <label for="numero_factura">Número de factura</label>
    <input type="text" name="numero_factura">

    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" rows="4" cols="50" placeholder="Descripción de la factura..."></textarea>

    <label for="precio">Precio</label>
    <input type="number" name="precio" step="0.01" placeholder="0.00">
    
    <label for="fecha">Fecha</label>
    <input type="date" name="fecha" required value="<?= date('Y-m-d') ?>">


    <label for="archivo_pdf">Subir PDF</label>
    <input type="file" name="archivo_pdf" accept="application/pdf" required>

    <input type="submit" value="Crear factura">
  </form>


</div>

</body>
</html>
