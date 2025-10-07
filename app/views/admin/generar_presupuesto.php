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
    <title>Generar Presupuesto</title>
    <link rel="stylesheet" href="/css/formcreacion.css">
    <link rel="icon" type="image/png" href="/assets/images/favicon.ico"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="/js/areaprivada.js"></script>
</head>
<body>
<div class="form-container">
    <a href="/index.php?url=admin" class="panel-button">
  <i class="fa fa-arrow-left"></i> Volver al panel
  </a>
  <h2>Generar Presupuesto</h2>
  <form action="/public/index.php?url=admin/descargarPresupuesto" method="POST" id="form-presupuesto" enctype="multipart/form-data">
    
    <label for="numero_presupuesto">Número de presupuesto:</label>
    <input type="number" id="numero_presupuesto" name="numero_presupuesto" required>

    <label for="metodo_pago">Método de pago:</label>
    <select id="metodo_pago" name="metodo_pago" required>
      <option value="Transferencia">Transferencia</option>
      <option value="Efectivo">Efectivo</option>
      <option value="Tarjeta">Tarjeta</option>
      <option value="Otro">Otro</option>
    </select>

    <label for="cliente">Cliente:</label>
    <select id="cliente" name="cliente" required>
      <option value="">Seleccione un cliente</option>
      <?php foreach ($usuarios as $usuario): ?>
        <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>"><?= htmlspecialchars($usuario['usuario']) ?></option>
      <?php endforeach; ?>
    </select>


    <label for="direccion_cliente">Dirección del cliente:</label>
    <input type="text" id="direccion_cliente" name="direccion_cliente" required>

    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="fecha" required>

    <div id="conceptos-container">
      <div class="concepto-item">
        <label>Concepto:</label>
        <textarea name="concepto[]" required class="concepto-textarea"></textarea>

        <label>Cantidad:</label>
        <input type="number" name="cantidad[]" min="1" value="1" required>

        <label>Precio:</label>
        <input type="number" name="precio[]" step="0.01" min="0" required>
        
        <label>Imagen:</label>
        <input type="file" accept="image/*" name="imagen[]" class="input-imagen">
        <img src="" class="preview-imagen" style="display:none;max-width:60px;max-height:60px;margin-left:10px;">

        <button type="button" class="back-button" onclick="this.parentNode.remove()">Eliminar</button>
      </div>
    </div>
    <button type="button" class="añadir-button" onclick="agregarConcepto()">Añadir concepto</button>
    <input type="submit" value="Generar PDF">
  </form>
</div>
</body>
</html>
