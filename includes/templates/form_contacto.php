<form action="../includes/enviar.php" class="form" method="POST">
    <h2 class="form__titulo">Necesitas ayuda..?</h2>
    <p class="form__p">
        Si necesitas atención inmediata entra a nuestro directorio 
        <a href="../../globalcargo/directorio.php" class="form__link">CLICK AQUI...</a>
    </p>
    <div class="form__container">
        <div class="form__grupo">
            <input type="text" name="nombre" id="nombre"class="form__input" placeholder=" " required>
            <label for="nombre" class="form__label">Nombre</label>
            <span class="form__linea"></span>
        </div>
        <div class="form__grupo">
            <input type="text" name="empresa" id="empresa" class="form__input" placeholder=" " required>
            <label for="empresa" class="form__label">Empresa</label>
            <span class="form__linea"></span>
        </div>
        <div class="form__grupo">
            <input type="email" name="email" id="email"class="form__input" placeholder=" " required>
            <label for="email" class="form__label">Email</label>
            <span class="form__linea"></span>
        </div>
        <div class="form__grupo">
            <input type="tel" name="telefono" id="telefono"class="form__input" placeholder=" " required>
            <label for="telefono" class="form__label">Conatcto</label>
            <span class="form__linea"></span>
        </div>
        <div class="form__grupo">
            <input type="text" name="mensaje" id="mensaje" class="form__input" placeholder=" " required>
            <label for="mensaje" class="form__label">Mensaje</label>
            <span class="form__linea"></span>
        </div>
        
        <input type="submit" class="form__submit" value="Enviar">
    </div>
</form>
