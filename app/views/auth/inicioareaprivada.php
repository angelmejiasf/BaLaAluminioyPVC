<title>Area Privada</title>
<link rel="stylesheet" href="css/areaprivada.css">
<link rel="icon" type="image/png" href="assets/images/favicon.ico"> 
<script src="js/areaprivada.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="login-container">
  <a href="index.php?url=home" class="btn-home">
    <i class="fa fa-home"></i> Volver a la página principal
  </a>

  <div class="logo-container">
      <img class="logo" src="assets/images/logo.jpg" alt="Logo BaLa Aluminio y PVC S.L">
  </div>
  <h2>Iniciar sesión</h2>
  <?php if (!empty($error)): ?>
  <div class="error-message">
    <i class="fa fa-exclamation-circle"></i>
    <?= htmlspecialchars($error) ?>
  </div>
  <?php endif; ?>
  <form action="index.php?url=auth/procesarLogin" method="post">
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" required><br>

    <label for="password">Contraseña</label>
    <div class="password-container">
      <input type="password" name="password" id="password" required>
      <span id="togglePassword" class="toggle-password" title="Mostrar/Ocultar contraseña"><i class="fa fa-eye" aria-hidden="true"></i></span>
    </div>

    <!-- Enlace para recordar contraseña -->
    <div class="forgot-password">
      <a href="index.php?url=auth/forgotPassword">¿Has olvidado tu contraseña?</a>
    </div>

    <input type="submit" value="Iniciar sesión">
  </form>
</div>

<div class="login-message">
  <i class="fa fa-info-circle" aria-hidden="true"></i>
  Si no estás registrado, ponte en contacto con nosotros y te proporcionaremos tus credenciales para acceder.
</div>
