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

    //consulta de prodcuto para seleccion opcional
    $producto3 = "SELECT * FROM ubicacion";
    $ubicacion1 = mysqli_query($db2 , $producto3);

    //consulta de prodcuto para seleccion opcional
    $producto = "SELECT * FROM producto";
    $producto2 = mysqli_query($db2 , $producto);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $unidades = mysqli_real_escape_string($db, $_POST['unidades']);
            $fecha = mysqli_real_escape_string($db, $_POST['fecha']);
            $ubicacion = mysqli_real_escape_string($db, $_POST['ubicacion']);
            $observacion = mysqli_real_escape_string($db, $_POST['observacion']);
            $responsable =  $_SESSION['usuario'];
            $nguia = mysqli_real_escape_string($db, $_POST['nguia']);
            $marca = mysqli_real_escape_string($db, $_POST['marca']);


        if(!$unidades) {
            $errores[] = "Pon todo son dos datos y te jalas";
        }
        if(!$fecha) {
            $errores[] = "U sigue pon todo, por dios!!!";
        }
        if(!$ubicacion) {
            $errores[] = "Pon todo son dos datos y te jalas";
        }
        if(!$observacion) {
            $errores[] = "U sigue pon todo, por dios!!!";
        }
        if(!$responsable) {
            $errores[] = "U sigue pon todo, por dios!!!";
        }
        
        
        if(empty($errores)) {
            // insertar datos en la base
        $query = "INSERT INTO reingreso (unidades, fecha, lugarAlmacenamiento, observacion, responsable, nguia, marca) 
            VALUES ('$unidades', '$fecha', '$ubicacion', '$observacion', '$responsable' , '$nguia' , '$marca')";
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
                <input type="number" name="unidades" id="unidades"class="form__input" placeholder=" " value="" >
                <label for="unidades" class="form__label">Unidades que reingresan</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fecha" id="fecha"class="form__input" placeholder=" " value="" >
                <label for="fecha" class="form__label">Fecha de reingreso</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="ubicacion"  class="form__input">
                    <option value=" " >--- Seleccionar Ubicacion ---</option>
                    <?php   while($ubic = mysqli_fetch_assoc($ubicacion1)): ?>
                        <option <?php //echo $idCarga === $ubic['id'] ? 'selected' : '';
                                ?>value="<?php echo $ubic['lugar']; ?>" ><?php echo $ubic['lugar']; ?></option>
                    <?php  endwhile  ?>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="observacion" id="observacion"class="form__input" placeholder=" " value="" >
                <label for="observacion" class="form__label">Motivo del reingreso</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="nguia" id="nguia"class="form__input" placeholder=" " value="" >
                <label for="nguia" class="form__label">Numero de guia</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="marca"  class="form__input">
                    <option value=" " >--- Seleccionar Marca ---</option>
                    <?php   while($conProduc = mysqli_fetch_assoc($producto2)): ?>
                        <option <?php //echo $idCarga === $conProduc['id'] ? 'selected' : '';
                                ?>value="<?php echo $conProduc['nombre']; ?>" ><?php echo $conProduc['nombre']; ?></option>
                    <?php  endwhile  ?>
                </select>
            </div>
            <input type="submit" class="form__submit" value="AGREGAR PRODCUTO">
        </div>
    </div>
</form>
<div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>

</html>