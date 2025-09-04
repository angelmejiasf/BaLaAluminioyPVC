<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] != 1) {
    header("Location: /index.php?url=auth/login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="icon" type="image/png" href="assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container">
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
  <h1>Bienvenido <?= isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : '' ?></h1>


<div class="button-row">
    <a href="/public/index.php?url=admin/listarUsuarios" class="panel-button">
      <i class="fa fa-user"></i> Usuarios
    </a>
    
  </div>
  <div class="button-row">
    <a href="/public/index.php?url=admin/listarFacturas" class="panel-button">
      <i class="fa fa-file-invoice"></i> Facturas
    </a>

  </div>
  <div class="button-row">
    <a href="/public/index.php?url=admin/listarPresupuestos" class="panel-button">
      <i class="fa fa-file-alt"></i> Presupuestos
    </a>

  </div> 
  <div class="button-row">
    <a href="/public/index.php?url=admin/generarPresupuesto" class="panel-button">
      <i class="fa fa-file-alt"></i> Crear presupuesto
    </a>
  </div>
    <div class="button-row">
    <a href="/public/index.php?url=admin/contabilidad" class="panel-button">
      <i class="fas fa-chart-pie"></i> Contabilidad
    </a>

  </div> 
  </div>

</body>
</html>
