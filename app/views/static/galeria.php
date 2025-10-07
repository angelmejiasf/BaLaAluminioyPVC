<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Empresa especializada en construcción de productos de aluminio y PVC">
  <title>BaLa Aluminio y PVC S.L</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/galeria.css">
  <script src="js/script.js"></script>
  <link rel="icon" type="image/png" href="assets/images/favicon.ico">
</head>

<body>

    <!-- Icono de WhatsApp fijo -->
<a href="https://wa.me/34636481331" target="_blank" class="whatsapp-icon">
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/600px-WhatsApp.svg.png" alt="WhatsApp" />
</a>
  <header>
    <div class="logo">
      <a href="index.php?url=home"><img class="logo" src="assets/images/logo.jpg" alt="Logo BaLa Aluminio  onclick="openLightbox(this)" y PVC S.L"></a>
    </div>

    <div class="nombre">
      <h1>BaLa Aluminio y PVC S.L</h1>
    </div>
    <div class="menu-icon" onclick="toggleMenu()">
        &#9776; <!-- Icono de menú (☰) -->
    </div>

    <nav id="menu">
         <ul>
            <li><a href="index.php?url=servicios/nosotros">Nosotros</a></li>
            <li class="dropdown">
              <a href="#" class="dropbtn">Servicios &#9662;</a>
              <div class="dropdown-content">
                <a href="index.php?url=servicios/ventanasoscilo">Ventanas Oscilobatientes</a>
                <a href="index.php?url=servicios/ventanascorrederas">Ventanas Correderas</a>
                <a href="index.php?url=servicios/puertas">Puertas</a>
                <a href="index.php?url=servicios/ventanasosciloparalelas">Ventanas Osciloparalelas</a>
                <a href="index.php?url=servicios/ventanasplegables">Ventanas Plegables</a>
                <a href="index.php?url=servicios/persianas">Persianas</a>
                <a href="index.php?url=servicios/mosquiteras">Mosquiteras</a>
              </div>

            </li>
            <li><a href="index.php?url=servicios/galeria">Galería</a></li>
            <li><a href="index.php?url=servicios/contacto">Contacto</a></li>
            <li class="areaprivada">
              <a href="index.php?url=auth/login"><i class="fa-solid fa-user"></i> Área privada</a>
            </li>            
      </ul>
    </nav>

</header>

 
  
<div class="container">
    <div class="contenido">
        <h1>GALERÍA</h1>
        <h2>Echa un vistazo a la galería de nuestras obras realizadas:</h3>
        <h3>Vivienda Unifamiliar</h3>
    </div>
   
    <div class="galerias">
        
    <div class="galeria">
        <h2>ANTES</h2>
        <img src="assets/images/imagenes de galeria/ANTES HABITACIÓN 1.jpeg" alt="Habitacion 1 antes" onclick="openLightbox(this)" >
        <img src="assets/images/imagenes de galeria/ANTES HABITACIÓN 2.jpeg" alt="Habitacion 2 antes" onclick="openLightbox(this)" >
        <img src="assets/images/imagenes de galeria/ANTES HABITACIÓN 3.jpeg" alt="Habitacion 3 antes" onclick="openLightbox(this)" >
        <img src="assets/images/imagenes de galeria/ANTES HABITACIÓN 4.jpeg" alt="Habitacion 4 antes" onclick="openLightbox(this)" >
        <img src="assets/images/imagenes de galeria/ANTES SALÓN.jpeg" alt="Salon antes" onclick="openLightbox(this)">
    </div>

    
    
    <div class="galeria">
        <h2>DESPUÉS</h2>
        <img src="assets/images/imagenes de galeria/DESPUÉS HABITACIÓN 1.jpeg" alt="Habitacion 1 despues" onclick="openLightbox(this)">
        <img src="assets/images/imagenes de galeria/DESPUÉS HABITACIÓN 2.jpeg" alt="Habitacion 2 despues" onclick="openLightbox(this)">
        <img src="assets/images/imagenes de galeria/DESPUÉS HABITACIÓN 3.jpeg" alt="Habitacion 3 despues" onclick="openLightbox(this)">
        <img src="assets/images/imagenes de galeria/DESPUÉS HABITACIÓN 4.jpeg" alt="Habitacion 4 despues" onclick="openLightbox(this)">
        <img src="assets/images/imagenes de galeria/DESPUÉS SALÓN.jpeg" alt="Salon despues" onclick="openLightbox(this)">
    </div>
</div>
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <img id="lightbox-img" src="" alt="Imagen en grande">
</div>
</div>
<section class="mapa">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3049.8365899580517!2d-3.9150631241868035!3d40.14592357148438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd41ee1be0eb9f65%3A0x44eec7839cbb3a0e!2sAv.%20de%20la%20Industria%2C%2042%2C%2045215%20El%20Viso%20de%20San%20Juan%2C%20Toledo!5e0!3m2!1ses!2ses!4v1738670817285!5m2!1ses!2ses" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

</body>
<footer>
  <div class="partelegal">
  <a href="index.php?url=servicios/avisolegal">Aviso legal</a>
  <a href="index.php?url=servicios/privacidad">Privacidad</a>

  </div>
  <p>&copy; 2025 BaLa Aluminio y PVC S.L - Todos los derechos reservados</p>
  
</footer>
</html>