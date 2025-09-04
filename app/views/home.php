<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Empresa especializada en construcción de productos de aluminio y PVC">
  <title>BaLa Aluminio y PVC S.L</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/estilo.css">
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
      <img class="logo" src="assets/images/logo.jpg" alt="Logo BaLa Aluminio y PVC S.L">
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
  <section class="carousel">
    <div class="carousel-container">
      <div class="slide active">
        <img src="assets/images/1.jpg" alt="Carpinteria en Aluminio y PVC de calidad">
        <div class="carousel-text">
          <h2>Calidad en Aluminio y PVC</h2>
          <p>Diseños personalizados para tu hogar</p>
        </div>
      </div>
      <div class="slide">
        <img src="assets/images/2.jpg" alt="Ventanas y puertas modernas">
        <div class="carousel-text">
          <h2>Ventanas y Puertas Modernas</h2>
          <p>Alta resistencia y durabilidad</p>
        </div>
      </div>
      <div class="slide">
        <img src="assets/images/3.jpg" alt="Proyectos a medida innovadores para cada espacio de tu hogar">
        <div class="carousel-text">
          <h2>Proyectos a Medida</h2>
          <p>Soluciones innovadoras para cada espacio</p>
        </div>
      </div>
    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>
  </section>



  <section id="nosotros" class="section">
    <div>
      <div class="ubi">
        <i class="fas fa-map-marker-alt"></i>

        <p> Avenida de la Industria, 42. El Viso de San Juan, Toledo</p>

      </div>

      <div class="tlf">
        <i class="fas fa-phone"></i>
        <p>Miguel Ángel 636481331 </p>
      </div>

      <div class="tlf">
        <i class="fas fa-phone"></i>
        <p> Rubén 686699471</p>
      </div>


    </div>

    <div>
      <a href="index.php?url=servicios/contacto"><button class="contacto-btn">¿Tienes una consulta?</button></a>
    </div>

  </section>

  <section id="productos" class="section">

    <!-- Contenedor de las tarjetas -->
    <div class="tarjetas-container">

      <div class="tarjeta">
        <img class="img" src="assets/images/6.jpg" alt="Ventanas">
        <h3>Ventanas</h3>
        <p>De apertura oscilobatiente, abatible, corredera, entre otros, diseñadas para optimizar el aislamiento térmico
          y acústico</p>
      </div>

      <div class="tarjeta">
        <img class="img" src="assets/images/cerramiento.jpg" alt="cerramiento">
        <h3>Cerramientos</h3>
        <p>Adaptados a balcones, terrazas o porches, asegurando resistencia y estética.</p>
      </div>

      <div class="tarjeta">
        <img class="img" src="assets/images/p3.jpg" alt="puerta">
        <h3>Puertas</h3>
        <p>De interior y exterior, con sistemas de seguridad avanzados y materiales que garantizan un perfecto
          aislamiento.</p>
      </div>

      <div class="tarjeta">
        <img class="img" src="assets/images/14.png" alt="mosquitera">
        <h3>Mosquiteras</h3>
        <p>Fáciles de instalar y mantener, ideales para mantener los insectos fuera sin renunciar a la ventilación
          natural.</p>
      </div>
    </div>
  </section>

  <section class="cualelegir">
    <h2>CÓMO ELEGIR BIEN TUS VENTANAS</h2>
    <a href="index.php?url=servicios/cualelegir"><img src="assets/images/cualelegir.png" class="cualelegir-img"></a>
    <div>
      <a href="index.php?url=servicios/cualelegir"><button class="info-btn">Más Información</button></a>
    </div>
  </section>

  <section class="colaboradores">
    <h2>BALA EMPRESA COLABORADORA CON:</h2>
    <a href="index.php?url=servicios/suvent"><img src="assets/images/logos/suvent.png"></a>
    <div>
      <a href="index.php?url=servicios/suvent"><button class="info-btn">Más Información</button></a>
    </div>
  </section>

  

</div>
  <footer>
    <div class="partelegal">
    <a href="index.php?url=servicios/avisolegal">Aviso legal</a>
    <a href="index.php?url=servicios/privacidad">Privacidad</a>

    </div>
    <p>&copy; 2025 BaLa Aluminio y PVC S.L - Todos los derechos reservados</p>
    
  </footer>

</body>

</html>