<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Empresa especializada en construcción de productos de aluminio y PVC">
    <title>BaLa Aluminio y PVC S.L</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/contacto.css">
    <script src="/js/script.js"></script>
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
</head>

<body>
  <!-- Icono de WhatsApp fijo -->
  <a href="https://wa.me/34636481331" target="_blank" class="whatsapp-icon">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/600px-WhatsApp.svg.png" alt="WhatsApp" />
  </a>
    <header>
        <div class="logo">
            <a href="index.php?url=home"><img class="logo" src="assets/images/logo.jpg" alt="Logo BaLa Aluminio y PVC S.L"></a>
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

    <section class="contact-section">
        
        <!-- Contenedor para el texto y el formulario -->
        <div class="contact-content">
            <!-- Texto informativo -->
            <div class="contact-text">
                <h2>¡Ponerse en contacto con nosotros es fácil!</h2>
                <p>Estamos aquí para ayudarte. Si tienes alguna pregunta o necesitas más información, no dudes en
                    contactarnos.
                    Te ofreceremos un presupuesto sin compromiso.</p>

                <div class="texto">
                    <p>
                        
                        <i class="fas fa-map-marker-alt"></i>Avenida de la Industria, 42. El Viso de San Juan, Toledo.<br>
                        <i class="fas fa-phone"></i>636481331 / 686699471 <br>
                        <i class="fa-solid fa-envelope"></i>balaaluminioypvc.sl@gmail.com<br>
                        <i class="fa-solid fa-calendar"></i>L-V 8:00 – 21:00
                        S 8:00 – 14:00
    
                    </p>
                </div>
                
                <div class="formulario-contacto">
                        <form method="POST" action="/index.php?url=contacto/mostrarFormulario">
                          <label for="nombre">Nombre:</label>
                          <input type="text" id="nombre" name="nombre" required>
                        
                          <label for="email">Tu correo electrónico:</label>
                          <input type="email" id="email" name="email" required>
                          
                          <label for="asunto">Asunto:</label>
                          <input type="text" id="asunto" name="asunto" required>
                        
                          <label for="mensaje">Mensaje:</label>
                          <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                        
                          <button type="submit">Enviar</button>
                        </form>

                    
                    
                </div>
                
                <?php if (!empty($mensaje)): ?>
                  <div class="mensaje-contacto">
                    <?= htmlspecialchars($mensaje) ?>
                  </div>
                <?php endif; ?>
                



                
            </div>


        </div>
        
        

        <!-- Imagen que acompaña el texto -->
        <div class="contact-image">
            <img class="imgc" src="assets/images/17.jpg" alt="Contacta con nuestra oficina">
        </div>
    </section>

    <section class="mapa">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3049.8365899580517!2d-3.9150631241868035!3d40.14592357148438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd41ee1be0eb9f65%3A0x44eec7839cbb3a0e!2sAv.%20de%20la%20Industria%2C%2042%2C%2045215%20El%20Viso%20de%20San%20Juan%2C%20Toledo!5e0!3m2!1ses!2ses!4v1738670817285!5m2!1ses!2ses"
            width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
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