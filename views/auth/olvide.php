<main class="auth">
    <h2 class="auth__heading">
        <?php echo $titulo; ?>
    </h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form action="/olvide" class="formulario" method="POST">

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                class="formulario__input"
                id="email"
                name="email"
                placeholder="Tu Email"
                value="<?php echo $usuario->email; ?>"
            />
        </div>

        <input type="submit" value="Enviar Instrucciones" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Crea una</a>
    </div>
    
</main>