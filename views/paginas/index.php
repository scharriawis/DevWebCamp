<?php
    include_once __DIR__ . '/workshops-conferencias.php';
?>

<section class="resumen">
    <div class="resumen__grid" <?php animaciones_aos(); ?>>
        <div class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $ponentes_total; ?></p>
            <p class="resumen__texto">Speakers</p>
        </div>

        <div class="resumen__bloque" <?php animaciones_aos(); ?>>
            <p class="resumen__texto--numero"><?php echo $conferencias_total; ?></p>
            <p class="resumen__texto">Conferencias</p>
        </div>

        <div class="resumen__bloque" <?php animaciones_aos(); ?>>
            <p class="resumen__texto--numero"><?php echo $workshops_total; ?></p>
            <p class="resumen__texto">Workshops</p>
        </div>

        <div class="resumen__bloque" <?php animaciones_aos(); ?>>
            <p class="resumen__texto--numero">500</p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Speakers</h2>
    <p class="speakers__descripcion">Conoce a nuestros expertos en DevWebCamp</p>

    <div class="speakers__grid">
        <?php foreach ($ponentes as $ponente) : ?>
            <div class="speaker" <?php animaciones_aos(); ?>>
                <picture>
                    <source srcset="echo $_ENV['HOST'] . '/img/speaker/' . $ponente->imagen; ?>.webp" type="image/webp">
                    <source srcset="echo $_ENV['HOST'] . '/img/speaker/' . $ponente->imagen; ?>.png" type="image/png">
                    <img class="speaker__imagen" width="200" height="300"src="<?php echo $_ENV['HOST'] . '/img/speaker/' . $ponente->imagen; ?>.png" alt="Sobre devwebcamp">
                </picture>
            

                <div class="speaker__informacion">

                    <h4 class="speaker__nombre">
                    <?php echo $ponente->nombre . ' ' . $ponente->apellido; ?>
                    </h4>
                    <p class="speaker__ubicacion">
                    <?php echo $ponente->ciudad . ', ' . $ponente->pais; ?>
                    </p>

                    <nav class="speaker-sociales">
                    <?php $redes = json_decode($ponente->redes); ?>

                        <?php if(!empty($redes->facebook)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->facebook; ?>">
                                <span class="speaker-sociales__ocultar">Facebook</span>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($redes->twitter)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->twitter; ?>">
                                <span class="speaker-sociales__ocultar">Twitter</span>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($redes->youtube)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->youtube; ?>">
                                <span class="speaker-sociales__ocultar">YouTube</span>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($redes->instagram)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->instagram; ?>">
                                <span class="speaker-sociales__ocultar">Instagram</span>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($redes->tiktok)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->tiktok; ?>">
                                <span class="speaker-sociales__ocultar">Tiktok</span>
                            </a>
                        <?php endif; ?>

                        <?php if(!empty($redes->github)) : ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->github; ?>">
                                <span class="speaker-sociales__ocultar">GitHub</span>
                            </a>
                        <?php endif; ?>

                    </nav>

                    <ul class="speaker__listado-skills">
                    <?php 
                        $tags = explode(',', $ponente->tags);
                        foreach($tags as $tag) :
                    ?>
                        <li class="speaker__skill">
                            <?php echo $tag; ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<div id="mapa" class="mapa"></div>

<section class="boletos">
    <h2 class="boletos__heading">Boletos y Precios</h2>
    <p class="boletos__descripcion">Precios para DevWebCamp</p>
    <div class="boletos__grid">
        <div class="boleto boleto--presencial" <?php animaciones_aos(); ?>>
            <h4 class="boleto__logo">&lt;DevWebCamp/></h4>
            <p class="boleto__plan">Presencial</p>
            <p class="boleto__precio">$199</p>
        </div>

        <div class="boleto boleto--virtual" <?php animaciones_aos(); ?>>
            <h4 class="boleto__logo">&lt;DevWebCamp/></h4>
            <p class="boleto__plan">Virtual</p>
            <p class="boleto__precio">$49</p>
        </div>

        <div class="boleto boleto--gratis" <?php animaciones_aos(); ?>>
            <h4 class="boleto__logo">&lt;DevWebCamp/></h4>
            <p class="boleto__plan">Gratis</p>
            <p class="boleto__precio">Gratis - $0</p>
        </div>
    </div>

    <div class="boleto__enlace-contenedor">
        <a class="boleto__enlace" href="/paquetes">Ver Paquetes</a>
    </div>
</section>