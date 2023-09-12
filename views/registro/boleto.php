<main class="pagina">
    <h2 class="pagina__heading"><?php echo $titulo; ?></h2>
    <p class="pagina__descripcion">Tú boleto - te recomendamos almacenarlo, puedes compartirlo en redes sociales.</p>

    <div class="boleto-virtual">

    <div class="boleto boleto--<?php echo strtolower($registro->paquete->nombre); ?> boleto--acceso">
        <div class="boleto__contenido">
            <h4 class="boleto__logo">&lt;DevWebCamp/></h4>
            <p class="boleto__plan"><?php echo $registro->paquete->nombre; ?></p>
            <p class="boleto__nombre">
                <?php echo $registro->usuario->nombre . ' ' . $registro->usuario->apellido; ?>
            </p>
            <p class="boleto__codigo"><?php echo '#' . $registro->token; ?></p>
        </div>
    </div>
    </div>
</main>