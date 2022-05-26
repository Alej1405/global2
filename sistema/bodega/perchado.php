<?php

    $id = $_GET['id'] ?? NULL;
    $id = filter_var($id, FILTER_VALIDATE_INT);

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

    $query1 = "SELECT * FROM ingreso WHERE id = ${id}";
    $consulta = mysqli_query($db2, $query1);
    $ingreso = mysqli_fetch_assoc($consulta);

    //consulta de prodcuto para seleccion opcional
    $producto3 = "SELECT * FROM ubicacion";
    $ubicacion1 = mysqli_query($db2 , $producto3);
    
    $alerta = null;
    $nosepuede = " ";
    $errores = [];
    $yanada = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fperchado = mysqli_real_escape_string($db, $_POST['fperchado']);
            $cUnid = mysqli_real_escape_string($db, $_POST['cUnid']);
            $ubicac  = mysqli_real_escape_string($db, $_POST['ubicac']);
            $responsab = $_SESSION['usuario'];
            $cptotalm3 = mysqli_real_escape_string($db, $_POST['cptotalm3']);
            $marca = $ingreso['marca'];
            $m3entrad1 = $ingreso['m3entrad'];
            $m3entrad = filter_var( $m3entrad1, FILTER_VALIDATE_FLOAT); 
            $idIngreso = $ingreso['id'];
            $m3perchados1 = $m3entrad * $cptotalm3;
            $m3perchados = filter_var( $m3perchados1, FILTER_VALIDATE_FLOAT);

        // validar el formulario

        if(!$fperchado) {
            $errores[] ="Ingresar la fecha de ubicación en las perchas ";
        }
        if(!$cUnid) {
            $errores [] ="Poner la cantidad de unidades colocadas en perchas ";
        }
        if(!$ubicac) {
            $errores [] ="Llenar el AREA que se ubicara el producto en las perchas";
        }
        if(!$responsab) {
            $errores [] ="Ingrese bien el Responsable.... NO ESTA REGISTRADO";
        }
        if(!$cptotalm3) {
            $errores [] ="Escribir bien la cantidad de perchado total m3... VERIFIQUE";
        }

        if (empty($errorer)){
        $query = "INSERT INTO perchado (fperchado, cUnid, ubicac, responsab, cptotalm3, marca, m3entrad, m3perchados, idIngreso ) 
                    VALUES ('$fperchado', '$cUnid', '$ubicac', '$responsab', '$cptotalm3', '$marca', '$m3entrad', '$m3perchados', '$idIngreso')";

            $guardar = mysqli_query($db2, $query); 
            if ($guardar){
                $alerta = 1;
            }

        }
    }
?>

<?php 
//consulta de cantidad de cajas por detalle
$numero1 = $ingreso['cUnid']; 

//consultar el numero para la resta
//"SELECT marca, SUM(cCaja) FROM ingreso GROUP by (marca)"
$query2 = "SELECT idIngreso, SUM(cUnid) FROM perchado WHERE idIngreso = ${id}";
$resta = mysqli_query($db2, $query2);
$restaPerchado = mysqli_fetch_assoc($resta);

$numero2 = $restaPerchado["SUM(cUnid)"];

$faltante = $numero1 - $numero2;
?>

<form action=" " class="form2" method="POST">
    <h2 class="form__titulo">PRODUCTO PERCHADO</h2>
    <p class="form__p form2--p">
        Ingresar los datos correctos en cada campo.
    </p>
    <?php foreach($errores as $error) : ?>
        <div class="Corregir">
            <?php echo $restaPerchado["SUM(cUnid)"]; ?>
        </div>
    <?php endforeach ?>

    <?php if(intval($alerta) === 1 ): ?>
        <p class="alerta2">PERCHADO CON ÉXITO, YA ERES TODO UN PERCHADOR JEJEJE</p>
    <?php elseif(intval($alerta) === 2 ): ?>
        <p class="alerta">ALGO PASO!!! YA DAÑASTE</p>
    <?php endif ?>

    <p class="form__p form2--p">
        <?php echo $faltante; 
        if($faltante === 0):
            $nosepuede = "hidden"; 
            $yanada = "DEL TODO MISMO... YA ESTÁ PERCHADO TODO, QUE DIERON YAPA..? NO VERDAD ENTONCES VAYA HECHARSE!!!";
        ?>
        <p class="alerta"><?php echo $yanada; ?></p>

        <?php endif?>
    </p>
    <div class="container2">
        <div class="form__container form2">
            <div class="form__grupo">
                <input type="date" name="fperchado" id="fperchado" class="form__input" placeholder=" " value="" >
                <label form="fperchado" class="form__label">Fecha de Perchado</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="text" name="cUnid" id="cUnid" class="form__input" placeholder=" " value="" >
                <label for="cUnid" class="form__label">Unidades en Percha</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <select name="ubicac"  class="form__input">
                    <option value=" " >--- Seleccionar Ubicacion ---</option>
                    <?php   while($ubic = mysqli_fetch_assoc($ubicacion1)): ?>
                        <option <?php //echo $idCarga === $ubic['id'] ? 'selected' : '';
                                ?>value="<?php echo $ubic['lugar']; ?>" ><?php echo $ubic['lugar']; ?></option>
                    <?php  endwhile  ?>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="cptotalm3" id="cptotalm3" class="form__input" placeholder=" " value="" >
                <label for="cptotalm3" class="form__label">Cajas Abiertas</label>
                <span class="form__linea"></span>
            </div>
            <input type="submit" <?php echo $nosepuede;  ?> class="form__submit" value="PERCHAR">
        </div>
    </div>
</form>

<div class="boton__anidado">
        <a href="verdetingreso.php" class="enlace">salir sin guardar</a>
</div>

</html>