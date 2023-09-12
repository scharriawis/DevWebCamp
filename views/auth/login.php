<main class="auth">
    <h2 class="auth__heading">
        <?php echo $titulo; ?>
    </h2>
    <p class="auth__texto">Inicia sesión con DevWebCamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form action="/login" class="formulario" method="POST">

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input 
                type="email" 
                class="formulario__input"
                id="email"
                name="email"
                placeholder="Tu Email"
            />
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password</label>
            <input 
                type="password" 
                class="formulario__input"
                id="password"
                name="password"
                placeholder="Tu Password"
            />
        </div>

        <input type="submit" value="Iniciar Sesión" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
    
</main>