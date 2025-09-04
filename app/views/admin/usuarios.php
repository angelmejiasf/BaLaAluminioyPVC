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
  <title>Usuarios</title>
  <link rel="stylesheet" href="/css/usuarios.css">
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

  <h2>Usuarios</h2>
  <table class="usuarios-table">
  <thead>
    <tr>
      <th>Usuario</th>
      <th>Nombre</th>
      <th>Primer apellido</th>
      <th>Segundo apellido</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($usuarios) && is_array($usuarios)): ?>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
      <td><?= htmlspecialchars($usuario['usuario']) ?></td>
      <td><?= htmlspecialchars($usuario['nombre']) ?></td>
      <td><?= htmlspecialchars($usuario['apellido1']) ?></td>
      <td><?= htmlspecialchars($usuario['apellido2']) ?></td>
      <td><?= htmlspecialchars($usuario['telefono']) ?></td>
      <td><?= htmlspecialchars($usuario['email']) ?></td>
      <td>
        <!-- Botón Editar -->
        <a href="/public/index.php?url=admin/editarUsuario&id=<?= $usuario['id_usuario'] ?>" class="action-btn edit-btn" title="Editar usuario">
          <i class="fa fa-user-edit"></i>
        </a>
        <!-- Botón Eliminar -->
        <a href="/public/index.php?url=admin/eliminarUsuario&id=<?= $usuario['id_usuario'] ?>" class="action-btn delete-btn" title="Eliminar usuario" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
          <i class="fa fa-trash"></i>
        </a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

    <?php if (!empty($_SESSION['mensaje_usuario'])): ?>
      <div class="success-message">
        <i class="fa fa-check-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_usuario']) ?>
      </div>
      <?php unset($_SESSION['mensaje_usuario']); ?>
    <?php endif; ?>
    
    <?php if (!empty($_SESSION['mensaje_usuario_error'])): ?>
      <div class="error-message">
        <i class="fa fa-exclamation-circle"></i>
        <?= htmlspecialchars($_SESSION['mensaje_usuario_error']) ?>
      </div>
      <?php unset($_SESSION['mensaje_usuario_error']); ?>
    <?php endif; ?>



  <?php if (!empty($mensaje)): ?>
  <div class="success-message">
    <?= htmlspecialchars($mensaje) ?>
  </div>
  <?php endif; ?>
  <?php endif; ?>

  


    <div class="div_crear">
        <a href="/public/index.php?url=admin/crearUsuario" class="panel-button">
        <i class="fa fa-user-plus"></i>Crear usuario
        </a>
    </div>
</div>
