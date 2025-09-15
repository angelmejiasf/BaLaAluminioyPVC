<?php
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: /index.php?url=auth/login");
    exit();
}

$pendienteCobroTotal = $pendienteCobroTotal ?? 0;
$atrasadoTotal = $atrasadoTotal ?? 0;
$noVencidoTotal = $noVencidoTotal ?? 0;
$cobrado60Total = $cobrado60Total ?? 0;
$cobrado30Total = $cobrado30Total ?? 0;
$cobrado3060Total = $cobrado3060Total ?? 0;
$totalCompras = $totalCompras ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Contabilidad</title>
  <link rel="stylesheet" href="/css/contabilidad.css"> 
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="contabilidad-container">
    <div class="div_volver"> 
        <a href="/index.php?url=admin" class="back-button">
        <i class="fa fa-arrow-left"></i> Volver al panel
        </a>
    </div>

        <?php
        if (!isset($totales) || !is_array($totales)) {
            $totales = [
                'totalFacturasPagadas' => 0,
                'totalFacturasSinCobrar' => 0,
                'totalPresupuestosAceptados' => 0,
            ];
        }
        ?>
  <div class="contabilidad-header">Contabilidad General</div>
  
    <div class="botones-contabilidad">
        <a href="/index.php?url=admin/contabilidad&tipo=inicio" class="btn-inicio">Inicio</a>
        
        <a href="/index.php?url=admin/contabilidad&tipo=ventas" class="btn-ventas">Ventas</a>
        
        <a href="/index.php?url=admin/contabilidad&tipo=compras" class="btn-compras">Compras</a>
      
    </div>

    <?php if ($tipo === 'inicio'): ?>
        <div class="dashboard-row">

          <!-- Tarjeta: Facturas venta pendientes -->
          <div class="dash-card">
            <h3>Facturas de venta</h3>
            <div class="dash-section dash-pendientes">
              <span class="dash-card-label">Pendiente de cobro</span>
              <div class="dash-card-main-amount"><?= number_format($pendienteCobroTotal, 2, ',', '.') ?>€</div>
        
              <div class="dash-breakdown-row">
                <span class="dash-late"><?= number_format($atrasadoTotal,2,',','.') ?>€</span>
                <span class="dash-not-due"><?= number_format($noVencidoTotal,2,',','.') ?>€</span>
              </div>
              <div class="dash-breakdown-row sublabels">
                <span class="dash-late-label">Atrasado</span>
                <span class="dash-not-due-label">No vencido</span>
              </div>
              <div class="dash-bar">
                <div class="dash-bar-late" style="width: <?= $atrasadoTotal/($pendienteCobroTotal?:1)*100 ?>%;"></div>
                <div class="dash-bar-not-due" style="width: <?= $noVencidoTotal/($pendienteCobroTotal?:1)*100 ?>%;"></div>
              </div>
            </div>
            <hr class="dash-divider">
        
            <div class="dash-section dash-cobrado">
              <span class="dash-card-label">Cobrado últimos 60 días</span>
              <div class="dash-card-main-amount"><?= number_format($cobrado60Total, 2, ',', '.') ?>€</div>
              <div class="dash-breakdown-row">
                <span class="dash-green"><?= number_format($cobrado30Total, 2, ',', '.') ?>€</span>
                <span class="dash-light-green"><?= number_format($cobrado3060Total, 2, ',', '.') ?>€</span>
              </div>
              <div class="dash-breakdown-row sublabels">
                <span class="dash-green-label">Últimos 30 días</span>
                <span class="dash-light-green-label">Entre 30 y 60 días</span>
              </div>
              <div class="dash-bar dash-bar-green-bg">
                <div class="dash-bar-green" style="width: <?= $cobrado30Total/($cobrado60Total?:1)*100 ?>%;"></div>
                <div class="dash-bar-light-green" style="width: <?= $cobrado3060Total/($cobrado60Total?:1)*100 ?>%;"></div>
              </div>
            </div>
          </div>

          <!-- Tarjeta: Beneficio neto -->
          <div class="dash-card beneficio-neto">
            <h3>Beneficio neto</h3>
            <span class="resumen-periodo-title">
              <?php if ($periodo === '30d'): ?>
                Últimos 30 días
              <?php elseif ($periodo === 'trimestre'): ?>
                Último trimestre
              <?php else: ?>
                Este año
              <?php endif; ?>
            </span>
            <div class="resumen-beneficio-valor">
              <?= number_format($beneficioPeriodo, 2, ',', '.') ?>€
            </div>
            <div class="resumen-bar-row">
              <span class="resumen-ingresos"><?= number_format($ingresosPeriodo, 2, ',', '.') ?>€<br><span class="resumen-label">Ingresos</span></span>
              <span class="resumen-gastos"><?= number_format($gastosPeriodo, 2, ',', '.') ?>€<br><span class="resumen-label">Gastos</span></span>
            </div>
            <div class="resumen-bar-total">
              <?php
                $total = $ingresosPeriodo + $gastosPeriodo;
                $wIngresos = $total > 0 ? round($ingresosPeriodo * 100 / $total, 1) : 50;
                $wGastos = 100 - $wIngresos;
              ?>
              <div class="resumen-bar-ingresos" style="width: <?= $wIngresos ?>%"></div>
              <div class="resumen-bar-gastos" style="width: <?= $wGastos ?>%"></div>
            </div>
            <form method="get" class="resumen-periodo-filtro">
              <input type="hidden" name="url" value="admin/contabilidad">
              <input type="hidden" name="tipo" value="inicio">
              <select name="periodo" onchange="this.form.submit()">
                <option value="30d" <?= $periodo === '30d' ? 'selected' : '' ?>>Últimos 30 días</option>
                <option value="trimestre" <?= $periodo === 'trimestre' ? 'selected' : '' ?>>Último trimestre</option>
                <option value="year" <?= $periodo === 'year' ? 'selected' : '' ?>>Este año</option>
              </select>
            </form>
          </div>

        </div>
    <?php endif; ?>



  



    <?php if ($tipo === 'ventas'): ?>
    <div class="totales-container">
        <div class="total-box total-presupuestos">
            <h3>Presupuestos abiertos</h3>
            <p><?= number_format($totales['totalPresupuestosAceptados'], 2, ',', '.') ?> €</p>
         </div>
    </div>
  <!-- Tabla de facturas -->
  <div class="section-title">Facturas</div>
  <form method="GET" action="/public/index.php">
      <input type="hidden" name="url" value="admin/contabilidad">
     <input type="hidden" name="tipo" value="ventas">
      <label for="estado">Filtrar por estado:</label>
      <select name="estado" id="estado" onchange="this.form.submit()">
        <option value="" <?= (!isset($_GET['estado']) || $_GET['estado'] == '') ? 'selected' : '' ?>>Todas</option>
        <option value="pagada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pagada') ? 'selected' : '' ?>>Pagada</option>
        <option value="atrasada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'atrasada') ? 'selected' : '' ?>>Atrasada</option>
        <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
      </select>
    </form>
    
  <table class="contab-table">
    <thead>
      <tr>
        <th>Factura</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Adjunto</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($facturas)) : ?>
        <?php foreach ($facturas as $factura): ?>
          <tr>
            <td><?= htmlspecialchars($factura['numero_factura']) ?></td>
            <td><?= htmlspecialchars($factura['nombre_cliente'] ?? 'Sin Nombre') ?></td>
            <td><?= date('d/m/Y', strtotime($factura['fecha'])) ?></td>
            <td><?= number_format($factura['monto'], 2, ',', '.') ?> €</td>
            <td>
              <?php if (!empty($factura['pdf'])): ?>
                <a href="/index.php?url=admin/verPdfFactura&archivo=<?= urlencode($factura['pdf']) ?>" target="_blank" title="Ver archivo PDF">
                  Ver factura
                </a>
              <?php else: ?>
                Sin Archivo
              <?php endif; ?>
            </td>

            <td>
                <span class="estado <?= strtolower($factura['estado']) ?>">
                <?= htmlspecialchars($factura['estado']) ?>
                </span>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5">No hay facturas registradas.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
  
    <?php if ($filtroEstado): ?>
  <div class="total-panel">
    Total Facturas <?= ucfirst($filtroEstado) ?>: 
    <span class="<?=
      $filtroEstado == 'atrasada' ? 'importe_atrasado' :
      ($filtroEstado == 'pendiente' ? 'importe_pendiente' : 'importe')
    ?>">
      <?= number_format($totalFiltrado ?? 0, 2, ',', '.') ?> €
    </span>
  </div>
<?php else: ?>
  <div class="total-panel">
    Total Facturas Pagadas: <span class="importe"><?= number_format($this->getVentasPorEstado('pagada'), 2, ',', '.') ?> €</span>
  </div>
  <div class="total-panel">
    Total Facturas Atrasadas: <span class="importe_atrasado"><?= number_format($this->getVentasPorEstado('atrasada'), 2, ',', '.') ?> €</span>
  </div>
  <div class="total-panel">
    Total Facturas Pendientes: <span class="importe_pendiente"><?= number_format($this->getVentasPorEstado('pendiente'), 2, ',', '.') ?> €</span>
  </div>
<?php endif; ?>


  
  
    <div class="section-title">Presupuestos</div>
    <form method="GET" action="/public/index.php">
        <input type="hidden" name="tipo" value="ventas">
      <input type="hidden" name="url" value="admin/contabilidad">
      <label for="estado_presupuesto">Filtrar por estado:</label>
      <select name="estado_presupuesto" id="estado_presupuesto" onchange="this.form.submit()">
        <option value="" <?= (!isset($_GET['estado_presupuesto']) || $_GET['estado_presupuesto'] == '') ? 'selected' : '' ?>>Todas</option>
        <option value="aceptado" <?= (isset($_GET['estado_presupuesto']) && $_GET['estado_presupuesto'] == 'aceptado') ? 'selected' : '' ?>>Aceptado</option>
        <option value="rechazado" <?= (isset($_GET['estado_presupuesto']) && $_GET['estado_presupuesto'] == 'rechazado') ? 'selected' : '' ?>>Rechazado</option>
        <option value="enviado" <?= (isset($_GET['estado_presupuesto']) && $_GET['estado_presupuesto'] == 'enviado') ? 'selected' : '' ?>>Enviado</option>
      </select>
    </form>

    
  <table class="contab-table">
  <thead>
    <tr>
      <th>Presupuesto</th>
      <th>Cliente</th>
      <th>Fecha</th>
      <th>Total</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($presupuestos)) : ?>
      <?php foreach ($presupuestos as $presupuesto): ?>
        <tr>
          <td><?= htmlspecialchars($presupuesto['numero_presupuesto']) ?></td>
          <td><?= htmlspecialchars($presupuesto['nombre_cliente'] ?? 'Sin Nombre') ?></td>
          <td><?= date('d/m/Y', strtotime($presupuesto['fecha'])) ?></td>
          <td><?= number_format($presupuesto['monto'], 2, ',', '.') ?> €</td>
          <td>            
          <span class="estado <?= strtolower($presupuesto['estado']) ?>">
                <?= htmlspecialchars($presupuesto['estado']) ?>
            </span>
        </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="5">No hay presupuestos registrados.</td></tr>
    <?php endif; ?>
  </tbody>
</table>


  <!-- Totales separados -->
    <?php if ($filtroEstadoPresupuesto): ?>
      <div class="total-panel">
        Total Presupuestos <?= ucfirst($filtroEstadoPresupuesto) ?>: 
        <span class="<?=
          $filtroEstadoPresupuesto == 'rechazado' ? 'importe_atrasado' :
          ($filtroEstadoPresupuesto == 'enviado' ? 'importe_pendiente' : 'importe')
        ?>">
          <?= number_format($totalPresupuestoFiltrado ?? 0, 2, ',', '.') ?> €
        </span>
      </div>
    <?php else: ?>
      <div class="total-panel">
        Total Presupuestos Aceptados: <span class="importe"><?= number_format($totalPresupuestosAceptados, 2, ',', '.') ?> €</span>
      </div>
      <div class="total-panel">
        Total Presupuestos Enviados: <span class="importe_pendiente"><?= number_format($totalPresupuestosEnviados, 2, ',', '.') ?> €</span>
      </div>
      <div class="total-panel">
        Total Presupuestos Rechazados: <span class="importe_atrasado"><?= number_format($totalPresupuestosRechazados, 2, ',', '.') ?> €</span>
      </div>
    <?php endif; ?>

    <?php elseif ($tipo === 'compras'): ?>
    
    <div class="totales-container">
        <div class="total-box total-compras">
            <h3>Total compras (gastos)</h3>
            <p><?= number_format($totalCompras, 2, ',', '.') ?> €</p>
        </div>
    </div>
    <div class="section-title">Compras</div>


        <table class="contab-table">
          <thead>
            <tr>
              <th>Concepto</th>
              <th>Precio</th>
              <th>Fecha</th>
              <th>Adjunto</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($compras)): ?>
              <?php foreach ($compras as $compra): ?>
                <tr>
                  <td><?= htmlspecialchars($compra['concepto']) ?></td>
                  <td><?= number_format($compra['precio'], 2, ',', '.') ?> €</td>
                  <td><?= date('d/m/Y', strtotime($compra['fecha'])) ?></td>
                  <td>
                    <?php if (!empty($compra['adjunto'])): ?>
                      <a href="/index.php?url=admin/verAdjuntoCompra&archivo=<?= urlencode($compra['adjunto']) ?>" target="_blank" title="Ver adjunto">
                        <i class="fa fa-file-pdf"></i> Ver archivo
                      </a>
                    <?php else: ?>
                      <span style="color:#aaa;">Sin adjunto</span>
                    <?php endif; ?>
                  </td>
                <td>
                  <!-- Botón Editar -->
                  <a href="/index.php?url=admin/editarCompra&id=<?= $compra['id_compra'] ?>" class="action-btn edit-btn" title="Editar compra">
                    <i class="fa fa-edit"></i>
                  </a>
                
                  <!-- Botón Eliminar -->
                  <a href="/index.php?url=admin/eliminarCompra&id=<?= $compra['id_compra'] ?>" class="action-btn delete-btn" title="Eliminar compra" onclick="return confirm('¿Seguro que deseas eliminar esta compra?');">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>

                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5">No hay compras para mostrar.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>



    


    <?php if (!empty($_SESSION['success'])): ?>
      <div class="success-message"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); endif; ?>
    
    <?php if (!empty($_SESSION['error'])): ?>
      <div class="error-message"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); endif; ?>

    <?php if (!empty($_SESSION['mensaje_compra'])): ?>
      <div class="success-message"><?= htmlspecialchars($_SESSION['mensaje_compra']) ?></div>
      <?php unset($_SESSION['mensaje_compra']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['error_compra'])): ?>
      <div class="error-message"><?= htmlspecialchars($_SESSION['error_compra']) ?></div>
      <?php unset($_SESSION['error_compra']); ?>
    <?php endif; ?>

    <a href="/index.php?url=admin/nuevaCompra" class="contab-action-btn">
        <i class="fa fa-plus"></i> Añadir Compra
    </a>

     <?php endif; ?>
</div>
</body>
</html>
