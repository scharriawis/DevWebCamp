<h2 class="pagina__heading"><?php echo $titulo; ?></h2>
<p class="pagina__descripcion">Elige hasta 5 eventos para asistir de forma presencial.</p>

<div class="eventos-registro">
    <main class="eventos-registro__listado">
        <!--Conferencias-->
        <h3 class="eventos-registro__heading--conferencias">&lt;DevWebCamp/></h3>
        <p class="eventos-registro__fecha">Viernes, 25 de Agosto</p>
        
        <div class="eventos-registro__grid">          
            <?php foreach($eventos['conferencias_v'] as $evento) : ?>
                <?php include __DIR__ . '/eventos.php';?>
            <?php endforeach; ?>
        </div>

        <p class="eventos-registro__fecha">Sábado, 26 de Agosto</p>

        <div class="eventos-registro__grid">
            <?php foreach($eventos['conferencias_s'] as $evento) : ?>
                <?php include __DIR__ . '/eventos.php';?>
            <?php endforeach; ?>
        </div>

        <!--Workshops-->
        <h3 class="eventos-registro__heading--workshops">&lt;Workshops/></h3>
        <p class="eventos-registro__fecha">Viernes, 25 de Agosto</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach($eventos['workshops_v'] as $evento) : ?>
                <?php include __DIR__ . '/eventos.php';?>
            <?php endforeach; ?>
        </div>

        <p class="eventos-registro__fecha">Sábado, 26 de Agosto</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach($eventos['workshops_s'] as $evento) : ?>
                <?php include __DIR__ . '/eventos.php';?>
            <?php endforeach; ?>
        </div>

    </main>

    <aside class="registro">
        <h2 class="registro__heading">Tu Registro</h2>

        <div id="registro-resumen" class="registro__resumen">
                <!--registro.js-->
        </div>

        <div class="registro__regalo">
            <!--Regalo.js-->
            <label class="registro__label" for="regalo">Selecciona un regalo</label>
            <select id="regalo" class="registro__select">
                <option value="">--Selecciona Tu Regalo--</option>
                <?php foreach ($regalos as $regalo) : ?>
                    <option value="<?php echo $regalo->id; ?>"><?php echo $regalo->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <form id="registro" class="formulario">
            <div class="formulario__campo">
                <input type="submit" class="formulario__submit formulario__submit--full" value="Registrarme">
            </div>
        </form>
    </aside>
    
</div>
