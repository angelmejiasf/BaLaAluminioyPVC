document.addEventListener("DOMContentLoaded", function () {
    let slideIndex = 0;
    let direction = 1; // 1 para avanzar, -1 para retroceder
    const slides = document.querySelectorAll('.slide');

    function moveSlide(n) {
        slides[slideIndex].classList.remove('active');
        slideIndex += n;

        // Revertir dirección al llegar a los extremos
        if (slideIndex >= slides.length - 1) {
            direction = -1;
        } else if (slideIndex <= 0) {
            direction = 1;
        }

        slides[slideIndex].classList.add('active');

        // Mueve el carrusel
        document.querySelector('.carousel-container').style.transform = `translateX(${-slideIndex * 100}%)`;
    }

    // Cambio automático cada 3 segundos en ambas direcciones
    setInterval(() => moveSlide(direction), 3000);

    // Asignar eventos a los botones manuales
    document.querySelector('.prev').addEventListener('click', () => moveSlide(-1));
    document.querySelector('.next').addEventListener('click', () => moveSlide(1));
});



function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.classList.toggle("show");
}


// Para la musica pagina principal 
document.addEventListener("DOMContentLoaded", () => {
    const audio = document.getElementById("background-music");
    audio.play().catch(error => console.log("Autoplay bloqueado: " + error));
});

// Para hacer aparecer las tarjetas
document.addEventListener("DOMContentLoaded", function () {
    const tarjetas = document.querySelectorAll(".tarjeta");

    function mostrarTarjetas() {
        const triggerBottom = window.innerHeight * 0.85; // Punto donde se activará la animación

        tarjetas.forEach((tarjeta) => {
            const tarjetaTop = tarjeta.getBoundingClientRect().top;

            if (tarjetaTop < triggerBottom) {
                tarjeta.classList.add("mostrar"); // Agrega la clase para hacerlas visibles
            }
        });
    }

    // Ejecutar cuando se haga scroll
    window.addEventListener("scroll", mostrarTarjetas);

    // Ejecutar al cargar la página (por si ya están en pantalla)
    mostrarTarjetas();
});

// Para hacer aparecer el boton de contacto
document.addEventListener("DOMContentLoaded", function () {
    const contactoBtn = document.querySelector(".contacto-btn"); // Seleccionamos el botón

    function mostrarBoton() {
        if (!contactoBtn) return; // Si no existe el botón, salir de la función
        
        const triggerBottom = window.innerHeight * 0.85;
        const botonTop = contactoBtn.getBoundingClientRect().top;

        if (botonTop < triggerBottom) {
            contactoBtn.classList.add("mostrar"); // Agrega la clase cuando el botón es visible
        }
    }

    // Detectar scroll para activar la animación
    window.addEventListener("scroll", mostrarBoton);

    // Ejecutar al cargar la página por si ya está visible
    mostrarBoton();
});

document.addEventListener("DOMContentLoaded", function () {
    let scrollSpeed = 0.1; // Ajusta la velocidad (0.05 a 0.3 para diferentes efectos)

    function smoothScroll() {
        let scrollPosition = window.scrollY;
        let targetScroll = scrollPosition + (window.scrollY - scrollPosition) * scrollSpeed;

        window.scrollTo(0, targetScroll);

        requestAnimationFrame(smoothScroll);
    }

    smoothScroll();
});



// GALERIAS

function openLightbox(img) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    lightboxImg.src = img.src;
    lightbox.classList.add('show');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
}