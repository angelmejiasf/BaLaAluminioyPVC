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
    <div class="div_volver"> 
  <a href="/index.php?url=admin/listarUsuarios" class="panel-button">
      <i class="fa fa-arrow-left"></i> Volver atrás
    </a>
  </div>
  <h2>Editar usuario</h2>
  <form method="GET" action="/public/index.php">
    <input type="hidden" name="url" value="admin/editarUsuario">
    <label for="id_usuario">Selecciona un usuario:</label>
    <select name="id" id="id_usuario" onchange="this.form.submit()">
      <option value="">-- Selecciona --</option>
      <?php foreach ($usuarios as $u): ?>
        <option value="<?= $u['id_usuario'] ?>" <?= (isset($usuario) && $usuario && $usuario['id_usuario'] == $u['id_usuario']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($u['usuario']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <?php if ($usuario): ?>
  <form action="/public/index.php?url=admin/actualizarUsuario" method="POST">
    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
    <label>Usuario:</label>
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
    <label for="password">Nueva contraseña (dejar en blanco para no cambiar)</label>
    <input type="password" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" 
       title="La contraseña debe tener al menos 8 caracteres e incluir letras y números">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
    <label>Primer Apellido:</label>
    <input type="text" name="apellido1" value="<?= htmlspecialchars($usuario['apellido1']) ?>" required>
    <label>Segundo Apellido:</label>
    <input type="text" name="apellido2" value="<?= htmlspecialchars($usuario['apellido2']) ?>" required>
    <label>Teléfono:</label>
    <input type="text" name="telefono" required pattern="^\d{9}$" title="El teléfono debe tener exactamente 9 números" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>
    <input type="submit" value="Actualizar usuario">
  </form>
  <?php endif; ?>
</div>

</body>
</html>