<main class="auth">
    <h2 class="auth__heading">
        <?php echo $titulo; ?>
    </h2>

    <p class="auth__texto">Reestablece tu password DevWebCamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php if($token_valido) : ;?>

        <form class="formulario" method="POST">


            <div class="formulario__campo">
                <label for="password" class="formulario__label">Nuevo Password</label>
                <input 
                    type="password" 
                    class="formulario__input"
                    id="password"
                    name="password"
                    placeholder="Reestablece Tu Password"
                />
            </div>
            
            <input type="submit" value="Enviar Instrucciones" class="formulario__submit">
        </form>
        
        <div class="acciones">
            <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Crea una</a>
            <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
        </div>
    <?php endif; ?>
</main>