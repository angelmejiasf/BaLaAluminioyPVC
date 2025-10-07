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
  <title>Crear Usuario</title>
  <link rel="stylesheet" href="/css/formcreacion.css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="form-container">
  <a href="/index.php?url=admin/listarUsuarios" class="panel-button">
  <i class="fa fa-arrow-left"></i> Volver atrás
  </a>

  <h2>Crear nuevo usuario</h2>

  <form action="/index.php?url=admin/guardarUsuario" method="POST">
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" required>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>

    <label for="apellido1">Primer Apellido</label>
    <input type="text" name="apellido1" required>

    <label for="apellido2">Segundo Apellido</label>
    <input type="text" name="apellido2" required>

    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" required
        pattern="^\d{9}$"
        title="El teléfono debe tener exactamente 9 números">

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" 
       required 
       pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" 
       title="La contraseña debe tener al menos 8 caracteres e incluir letras y números">

    <input type="submit" value="Crear usuario">
  </form>


</div>

</body>
</html>
