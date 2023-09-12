<main class="devwebcamp">
    <h2 class="devwevcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de latinoamérica</p>

    <div class="devwebcamp__grid">
        <picture class="devwebcamp__imagen" <?php animaciones_aos(); ?>>
            <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
            <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
            <img loading="lazy" width="200" height="300"src="build/img/sobre_devwebcamp.jppg" alt="Sobre devwebcamp">
        </picture>

        <div class="devwebcamp__contenido">
            <p class="devwebcamp__texto" <?php animaciones_aos(); ?>> 
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
            <p class="devwebcamp__texto" <?php animaciones_aos(); ?>> 
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
        </div>
    </div>
</main>