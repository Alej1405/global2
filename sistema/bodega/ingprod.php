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

            $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
            $fabricante = mysqli_real_escape_string($db, $_POST['fabricante']);


        if(!$nombre) {
            $errores[] = "Pon todo son dos datos y te jalas";
        }
        if(!$fabricante) {
            $errores[] = "U sigue pon todo, por dios!!!";
        }
        
        
        if(empty($errores)) {
            // insertar datos en la base
        $query = "INSERT INTO producto (nombre, fabricante) 
            VALUES ('$nombre', '$fabricante')";
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
    <h2 class="form__titulo titulo__pagina">REGISTRAR PRODUCTOS / MARCAS  </h2>
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
                <input type="text" name="nombre" id="nombre"class="form__input" placeholder=" " value="" >
                <label for="nombre" class="form__label">Nombre del Producto</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="fabricante" id="fabricante"class="form__input" placeholder=" " value="" >
                <label for="fabricante" class="form__label">Laboratorio que lo fabrica</label>
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