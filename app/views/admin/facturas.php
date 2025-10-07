<?php

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: /index.php?url=auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Facturas</title>
  <link rel="stylesheet" href="/css/facturas.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="table-container">
  <div class="div_volver"> 
    <a href="/index.php?url=admin" class="back-button">
      <i class="fa fa-arrow-left"></i> Volver al panel
    </a>
  </div>

  <h2>Facturas</h2>

  <!-- Filtro por cliente -->
<form method="get" action="/public/index.php" class="filtro-form">
  <input type="hidden" name="url" value="admin/listarFacturas">
  <label for="cliente">Filtrar por cliente:</label>
  <select name="cliente" id="cliente" onchange="this.form.submit()">
  <option value="">Todos</option>
  <?php foreach ($usuarios as $user): ?>
    <?php if ($user['id_usuario'] != 1): ?>
      <option value="<?= $user['id_usuario'] ?>" <?= (isset($_GET['cliente']) && $_GET['cliente'] == $user['id_usuario']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($user['usuario']) ?>
      </option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>

</form>


    <!-- Mensaje de éxito -->
    <?php if (!empty($_SESSION['mensaje_factura'])): ?>
      <div class="success-message">
        <i class="fa fa-check-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_factura']) ?>
      </div>
      <?php unset($_SESSION['mensaje_factura']); ?>
    <?php endif; ?>
    
    <!-- Mensaje de error -->
    <?php if (!empty($_SESSION['mensaje_error'])): ?>
      <div class="error-message">
        <i class="fa fa-exclamation-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_error']) ?>
      </div>
      <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>


  <table class="facturas-table">
    <thead>
      <tr>
        <th>Nº Factura</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>PDF</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($facturas as $factura): ?>
      <tr>
        <td><?= htmlspecialchars($factura['numero_factura']) ?></td>
        <td><?= htmlspecialchars($factura['nombre_usuario']) ?></td>
        <td><?= date('d/m/Y', strtotime($factura['fecha'])) ?></td>
        <td class="descripcion"><?= htmlspecialchars($factura['descripcion']) ?></td>
        <td><?= htmlspecialchars($factura['monto']) ?>€</td>
        <td>
            <span class="estado <?= strtolower($factura['estado']) ?>">
                <?= htmlspecialchars($factura['estado']) ?>
            </span>
        </td>

        <td>
          <?php if (!empty($factura['pdf'])): ?>
            <a href="/public/index.php?url=admin/verPdfFactura&archivo=<?= urlencode($factura['pdf']) ?>" target="_blank" class="pdf-link">
                <i class="fa fa-file-pdf"></i> Ver PDF
            </a>

          <?php else: ?>
            <span style="color:#aaa;">Sin PDF</span>
          <?php endif; ?>
        </td>
        <td>
          <!-- Botón Editar -->
        <a href="/public/index.php?url=admin/editarFactura&id=<?= $factura['id_factura'] ?>" class="action-btn edit-btn" title="Editar factura">

            <i class="fa fa-edit"></i>
          </a>
          <!-- Botón Eliminar -->
          <a href="/index.php?url=admin/eliminarFactura&id=<?= $factura['id_factura'] ?>" class="action-btn delete-btn" title="Eliminar factura" onclick="return confirm('¿Seguro que deseas eliminar esta factura?');">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($facturas)): ?>
      <tr>
        <td colspan="8">No hay facturas para mostrar.</td>
      </tr>
      <?php endif; ?>

      
    </tbody>
  </table>

    <?php if (!empty($mensaje)): ?>
    <div class="success-message">
      <?= htmlspecialchars($mensaje) ?>
    </div>
  <?php endif; ?>
  <div class="div_crear">
    <a href="/public/index.php?url=admin/crearFactura" class="panel-button">
      <i class="fa fa-file-invoice"></i> Crear factura
    </a>
  </div>
</div>

</body>
</html>
