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
  <title>Presupuestos</title>
  <link rel="stylesheet" href="/css/presupuestos.css">
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

  <h2>Presupuestos</h2>

  <!-- Filtro por cliente -->
<form method="get" action="/public/index.php" class="filtro-form">
  <input type="hidden" name="url" value="admin/listarPresupuestos">
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


    <?php if (!empty($_SESSION['mensaje_presupuesto'])): ?>
      <div class="success-message">
        <i class="fa fa-check-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_presupuesto']) ?>
      </div>
      <?php unset($_SESSION['mensaje_presupuesto']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['mensaje_presupuesto_error'])): ?>
      <div class="error-message">
        <i class="fa fa-exclamation-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_presupuesto_error']) ?>
      </div>
      <?php unset($_SESSION['mensaje_presupuesto_error']); ?>
    <?php endif; ?>


  <table class="presupuestos-table">
    <thead>
      <tr>
        <th>Nº presupuesto</th>
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
      <?php foreach ($presupuestos as $presupuesto): ?>
      <tr>
        <td><?= htmlspecialchars($presupuesto['numero_presupuesto']) ?></td>
        <td><?= htmlspecialchars($presupuesto['nombre_usuario']) ?></td>
        <td><?= date('d/m/Y', strtotime($presupuesto['fecha'])) ?></td>
        <td class="descripcion"><?= htmlspecialchars($presupuesto['descripcion']) ?></td>
        <td><?= htmlspecialchars($presupuesto['monto']) ?>€</td>
        <td>
            <span class="estado <?= strtolower($presupuesto['estado']) ?>">
                <?= htmlspecialchars($presupuesto['estado']) ?>
            </span>
        </td>

        <td>
          <?php if (!empty($presupuesto['pdf'])): ?>
            <a href="/public/index.php?url=admin/verPdfPresupuesto&archivo=<?= urlencode($presupuesto['pdf']) ?>" target="_blank" class="pdf-link">
              <i class="fa fa-file-pdf"></i> Ver PDF
            </a>
          <?php else: ?>
            <span style="color:#aaa;">Sin PDF</span>
          <?php endif; ?>
        </td>
        <td>
          <!-- Botón Editar -->
          <a href="/public/index.php?url=admin/editarPresupuesto&id=<?= $presupuesto['id_presupuesto'] ?>" class="action-btn edit-btn" title="Editar presupuesto">
            <i class="fa fa-edit"></i>
          </a>
          <!-- Botón Eliminar -->
          <a href="/public/index.php?url=admin/eliminarPresupuesto&id=<?= $presupuesto['id_presupuesto'] ?>" class="action-btn delete-btn" title="Eliminar presupuesto" onclick="return confirm('¿Seguro que deseas eliminar esta presupuesto?');">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($presupuestos)): ?>
      <tr>
        <td colspan="8" style="color:#888; text-align:center;">No hay Presupuestos para mostrar.</td>
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
    <a href="/public/index.php?url=admin/crearpresupuesto" class="panel-button">
      <i class="fa fa-file-invoice"></i> Crear presupuesto
    </a>
  </div>
</div>

</body>
</html>
