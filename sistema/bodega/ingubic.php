<?php 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    conectarDB();
    $db =conectarDB();

    conectarDB2();
    $db2 =conectarDB2();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }
    $mensaje = null; 
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $lugar = mysqli_real_escape_string($db, $_POST['lugar']);
            $apartado = mysqli_real_escape_string($db, $_POST['apartado']);


        if(!$lugar) {
            $errores[] = "Pon todo son dos datos y te jalas";
        }
        if(!$apartado) {
            $errores[] = "U sigue pon todo, por dios!!!";
        }
        
        
        if(empty($errores)) {
            // insertar datos en la base
        $query = "INSERT INTO ubicacion (lugar, apartado) 
            VALUES ('$lugar', '$apartado')";
            //echo $query;

            $resultado = mysqli_query($db2, $query);
            //     //echo "hasta aquí funciona";

                if ($resultado) {
                    $mensaje = 1;
                }
        }

    }
?>
    <?php if(intval($mensaje) === 1 ): ?>
        <p class="alerta2">YA AGREGASTE UN PRODUCTO, FACIL ES.</p>
    <?php elseif(intval($mensaje) === 2 ): ?>
        <p class="alerta">YA DAÑASTE NO SE GUARDO, LLAMA A UN SUPERADMIN</p>
    <?php endif ?>

<form action=" " class="form2" method="POST">
    <h2 class="form__titulo titulo__pagina">AGREAR UN ESPACIO EN BODEGA</h2>
        <h2 class="form__titulo">FICHA DE INGRESO</h2>
        <p class="form__p form2--p">
            Recuerda llenar bien estos campos para poder realizar una 
            correcta operación.
        </p>
        <?php foreach($errores as $error) : ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach ?>

    <div class="container2">
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="text" name="lugar" id="lugar"class="form__input" placeholder=" " value="" >
                <label for="lugar" class="form__label">Nombre del lugar en Bodega</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="apartado" id="apartado"class="form__input" placeholder=" " value="" >
                <label for="apartado" class="form__label">APARTADO</label>
                <span class="form__linea"></span>
            </div>
            <input type="submit" class="form__submit" value="AGREGAR PRODCUTO">
        </div>
    </div>
</form>
<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>

</html>