<div class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (is_Auth()) { ?>
                <a href="<?php echo is_Admin() ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__enlace">Administrar</a>
                <form action="/logout" method="POST" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php }else { ?>
                <a href="/registro" class="header__enlace">Registro</a>
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php } ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">
                    &lt;DevWebCamp/>
                </h1>
            </a>

            <p class="header__texto">Julio 15-16 2023</p>
            <p class="header__texto header__texto--modalidad">En linea - Presencial</p>

            <a href="/registro" class="header__boton">Comprar Pase</a>
        </div>
    </div>
</div>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
                &lt;DevWebCamp/>
            </h2>
        </a>

        <nav class="navegacion">
            <a href="/devwebcamp" class="navegacion__enlace <?php echo paginaActual('/devwebcamp') ? 'navegacion__enlace--actual' : ''; ?>">Evento</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo paginaActual('/paquetes') ? 'navegacion__enlace--actual' : ''; ?>">Paquetes</a>
            <a href="/workshops-conferencias" class="navegacion__enlace <?php echo paginaActual('/workshops-conferencias') ? 'navegacion__enlace--actual' : ''; ?>">Workshops / conferencias</a>
            <a href="/registro" class="navegacion__enlace <?php echo paginaActual('/registro') ? 'navegacion__enlace--actual' : ''; ?>">Comprar Pase</a>
        </nav>
    </div>
</div>