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
  <title>Panel de cliente</title>
  <link rel="stylesheet" href="/css/dashboard.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
  <div class="cliente-container">

    <div class="logout-container">
      <form action="/index.php?url=auth/cerrarSesion" method="POST">
        <button type="submit" class="panel-button logout-button">
          <i class="fa fa-sign-out-alt"></i> Cerrar sesión
        </button>
      </form>
    </div>

    <div class="logo-container">
      <img class="logo" src="assets/images/logo.jpg" alt="Logo BaLa Aluminio y PVC S.L">
    </div>

    <h1>Bienvenido/a <?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : '' ?></h1>
  <?php if (!empty($_SESSION['mensaje_exito'])): ?>
    <div class="success-message">
        <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>
    </div>
    <?php unset($_SESSION['mensaje_exito']); ?>
<?php endif; ?>

    <h2>Mis facturas</h2>
    <table class="facturas-table">
      <thead>
        <tr>
          <th>Nº Factura</th>
          <th>Fecha</th>
          <th>Precio</th>
          <th>Descripcion</th>
          <th>Estado</th>
          <th>Adjunto</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($facturas as $factura): ?>
          <tr>
            <td><?= htmlspecialchars($factura['numero_factura']) ?></td>
            <td><?= date('d/m/Y', strtotime($factura['fecha'])) ?></td>
            <td><?= number_format($factura['monto'], 2, ',', '.') ?> €</td>
            <td class="descripcion"><?= htmlspecialchars($factura['descripcion']) ?></td>
            <td> 
                <span class="estado <?= strtolower($factura['estado']) ?>"><?= htmlspecialchars($factura['estado']) ?></span>
            </td>
            <td>
              <?php if (!empty($factura['pdf'])): ?>
                <a href="/index.php?url=admin/verPdfFactura&archivo=<?= urlencode($factura['pdf']) ?>" target="_blank" class="pdf-link">Ver Factura</a>
              <?php else: ?>
                Sin archivo
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>Mis presupuestos</h2>
    <table class="presupuestos-table">
      <thead>
        <tr>
          <th>Nº Presupuesto</th>
          <th>Fecha</th>
          <th>Precio</th>
          <th>Descripcion</th>
          <th>Estado</th>
          <th>Adjunto</th>
          <th>Firmar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($presupuestos as $presupuesto): ?>
          <tr>
            <td><?= htmlspecialchars($presupuesto['numero_presupuesto']) ?></td>
            <td><?= date('d/m/Y', strtotime($presupuesto['fecha'])) ?></td>
            <td><?= number_format($presupuesto['monto'], 2, ',', '.') ?> €</td>
            <td class="descripcion"><?= htmlspecialchars($presupuesto['descripcion']) ?></td>
            <td>
                <span class="estado <?= strtolower($presupuesto['estado']) ?>"><?= htmlspecialchars($presupuesto['estado']) ?></span>
            </td>
            <td>
              <?php if (!empty($presupuesto['pdf'])): ?>
                <a href="/index.php?url=admin/verPdfPresupuesto&archivo=<?= urlencode($presupuesto['pdf']) ?>" target="_blank" class="pdf-link">Ver Presupuesto</a>
              <?php else: ?>
                Sin archivo
              <?php endif; ?>
            </td>
            <td>
              <?php if (isset($presupuesto['id_presupuesto']) && strtolower($presupuesto['estado']) !== 'aceptado'): ?>
                  <a href="/index.php?url=cliente/firmarPresupuesto&id=<?= htmlspecialchars($presupuesto['id_presupuesto']) ?>" class="firmar">Firmar</a>
              <?php else: ?>
                  <span class="firmar disabled">Firmar</span>
              <?php endif; ?>



            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    

  </div>
</body>

</html>
