<?php  
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //BASE DE DATOS GLOBAL CARGO
    conectarDB();
    $db =conectarDB();
    $auth = estaAutenticado();
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //proteger la página
    if (!$auth) {
        header('location: ../global/index.php');
    }

    //consulta de prodcuto para seleccion opcional
    $producto = "SELECT * FROM producto";
    $producto2 = mysqli_query($db2 , $producto);

    //consulta de prodcuto para seleccion opcional
    $producto3 = "SELECT * FROM ubicacion";
    $ubicacion1 = mysqli_query($db2 , $producto3);

    $errores = [];
    $mensaje = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit; 
            $marca = mysqli_real_escape_string($db, $_POST['marca']);
            $notsanit  = mysqli_real_escape_string($db, $_POST['notsanit']);
            $lote = mysqli_real_escape_string($db, $_POST['lote']);
            $fElab = mysqli_real_escape_string($db, $_POST['fElab']);
            $fVenc = mysqli_real_escape_string($db, $_POST['fVenc']);
            $cCaja = mysqli_real_escape_string($db, $_POST['cCaja']);
            $cUnid = mysqli_real_escape_string($db, $_POST['cUnid']);
            $ubicac = mysqli_real_escape_string($db, $_POST['ubicac']);
            $observac = mysqli_real_escape_string($db, $_POST['observac']);
            $largo = mysqli_real_escape_string($db, $_POST['largo']);
            $ancho = mysqli_real_escape_string($db, $_POST['ancho']);
            $alto = mysqli_real_escape_string($db, $_POST['alto']);
            $editor = $_SESSION['usuario'];
            $idIngresog = $id;
            $editado = 'si';
            
            $m3entra = $largo * $ancho * $alto;

            $m3entrad = $m3entra/1000000;
            $m3tota = $m3entrad * $cCaja;

            $m3total = filter_var( $m3tota, FILTER_VALIDATE_FLOAT);

        // validar el formulario

        if(!$marca) {
            $errores[] = "ESTA MARCA NO EXISTE O NO ESTA REGISTRADA SISTEMA....VERIFICA!!!";
        }
        if(!$fElab){
            $errores[] = "debes ingresar la fecha elaboración registrada en la etiqueta";
        }
        if(!$fVenc) {
            $errores [] = "debes ingresar la fecha vencimiento registrada en la etiqueta";
        }
        if(!$cCaja){
            $errores [] = "ingresar la cantidad de cajas total.... DEBE SER EL MISMO INGRESADO";
        }
        if(!$cUnid){
            $errores [] = "Ingrese la cantidad exacta de unidades de cada caja... CUANTAS CONTIENE CADA CAJA";
        }
        if(!$m3entrad) {
            $errores[] = "Con este campo sabemos el espacio ocupado bodega POOON!!!";
        }
        if(!$ubicac) {
            $errores [] = "Escoger bien el lugar donde ingresa... VERIFIQUE!!";
        }
        if(!$observac) {
            $errores[] = "existe algun detalle sobre la carga";
        }
        
        if(empty($errores)) {
            // insertar datos en la base
        $query = "INSERT INTO ingreso ( marca, notsanit, lote, fElab, fVenc, cCaja, cUnid, largo, ancho, alto, m3entrad, m3total, ubicac, observac, editor, guia, idIngresog) 
                VALUES ('$marca', '$notsanit', '$lote', '$fElab', '$fVenc', '$cCaja' , '$cUnid', '$largo', '$ancho', '$alto', '$m3entrad', '$m3total', '$ubicac', '$observac', '$editor', '$editado', $idIngresog)"; 
        //echo $query;

            $resultado = mysqli_query($db2, $query);
                //echo "hasta aquí funciona";

                if ($resultado) {
                    $mensaje = 1;
                }else{
                    header('location: detalle_ing.php?resultado=2');
                }
        }

    }
?>

<div class="cajas__producto">
        <?php 
        $queryS = "SELECT marca, SUM(cCaja) FROM ingreso GROUP by (marca)";
        $total = mysqli_query($db2, $queryS);
        ?>
        <div class="datosactuales">
            <?php while($totalCajas = mysqli_fetch_assoc($total)):?>
            <p>Cajas de <a href="" class="suma"><?php echo $totalCajas["marca"]; ?> <?php echo $totalCajas["SUM(cCaja)"]; ?></a></p>
            <?php endwhile; ?>
        </div>
    </div>
<?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * FROM ingresog WHERE ingresog.id = ${id}";
    $consultaG = mysqli_query($db2, $query2);
?>

<h2 class="form__titulo titulo__pagina">VER CARGA CONSIGNADA E INGRESAR</h2>
    <table class="form2 consulta__tabla">
    <p class="form2--p">
        INFORMACION GENERAL DE LA CARGA
    </p>
        <thead>
            <tr>
                <th>Numero de Guía</th>
                <th>Fecha de Ingreso</th>
                <th>Proveedor</th>
                <th>Cantidad de Cajas</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php while($datos = mysqli_fetch_assoc($consultaG)):?>
                <tr>
                    <td><?php echo $datos['nGuia']; ?></td>
                    <td><?php echo $datos['fIngres']; ?></td>
                    <td><?php echo $datos['proveed']; ?></td>
                    <td><?php echo $datos['cCaja']; ?></td>
                    <td><?php echo $datos['produc']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if(intval($mensaje) === 1 ): ?>
        <p class="alerta2">CARGA UBICADA CORRECTAMENTE</p>
    <?php elseif(intval($mensaje) === 2 ): ?>
        <p class="alerta">YA DAÑASTE NO SE GUARDO, LLAMA A UN SUPERADMIN</p>
    <?php endif ?>

    <?php 
    $query3 = "SELECT * FROM ingreso WHERE ingreso.idIngresog = ${id}";
    $tabla = mysqli_query($db2, $query3);
    ?>

<h2 class="form__titulo titulo__pagina">INGRESOS REALIZADOS</h2>
<table class="form2 consulta__tabla">
        <thead>
            <tr>
                <th>Marca</th>
                <th>N Sanitaria</th>
                <th>Lote</th>
                <th>F Elaboracion</th>
                <th>F. Vencimiento</th>
                <th>Numero de Cajas</th>
                <th>VOL por Caja</th>
                <th>VOL Totales</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php while($datos = mysqli_fetch_assoc($tabla)):?>
                <tr>
                    <td><?php echo $datos['marca']; ?></td>
                    <td><?php echo $datos['notsanit']; ?></td>
                    <td><?php echo $datos['lote']; ?></td>
                    <td><?php echo $datos['fElab']; ?></td>
                    <td><?php echo $datos['fVenc']; ?></td>
                    <td><?php echo $datos['cCaja']; ?></td>
                    <td><?php echo $datos['m3entrad']; ?></td>
                    <td><?php echo $datos['m3total']; ?></td>
                    <td>
                        <div class="accion__actualizar">
                            <a href="actingreso.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">CORREGIR</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    
    <form action=" " class="form2" method="POST">
        <h2 class="form__titulo">DETALLE DE DATOS DE INGRESO</h2>
    <p class="form__p form2--p">
        Llenar correctamente los datos del registro.
    </p>
    <?php foreach($errores as $error) : ?>
        <div class="Corregir">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>


    <div class="container2">
        <div class="form__container form--2">
            <div class="form__grupo">
                <select name="marca"  class="form__input">
                    <option value=" " >--- Seleccionar Marca ---</option>
                    <?php   while($conProduc = mysqli_fetch_assoc($producto2)): ?>
                        <option <?php //echo $idCarga === $conProduc['id'] ? 'selected' : '';
                                ?>value="<?php echo $conProduc['nombre']; ?>" ><?php echo $conProduc['nombre']; ?></option>
                    <?php  endwhile  ?>
                </select>
            </div>
            <div class="form__grupo">
                <input type="text" name="notsanit" id="notsanit" class="form__input" placeholder=" " value="" >
                <label for="notsanit" class="form__label">Not Sanitario</label>
            </div>
            <div class="form__grupo">
                <input type="text" name="lote" id="lote" class="form__input" placeholder=" " value="" >
                <label for="lote" class="form__label">Lote</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fElab" id="fElab" class="form__input" placeholder=" " value="" >
                <label for="fElab" class="form__label">Fecha Elaboración</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="date" name="fVenc" id="fVenc" class="form__input" placeholder=" " value="">
                <label for="fVenc" class="form__label">Fecha de Vencimiento</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="cCaja" id="cCaja" class="form__input" placeholder=" " value="" >
                <label for="cCaja" class="form__label">Cantidad de Cajas</label>
                <span class="form__linea"></span>
            </div>
        </div>
        <div class="form__container form--2">
            <div class="form__grupo">
                <input type="text" name="cUnid" id="cUnid" class="form__input" placeholder=" " valvue="" >
                <label for="cUnid" class="form__label">Cantidad de Unidades</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="largo" id="largo" class="form__input" placeholder=" " valvue="" >
                <label for="largo" class="form__label">Largo de la Caja</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="ancho" id="ancho" class="form__input" placeholder=" " valvue="" >
                <label for="ancho" class="form__label">Ancho de la caja</label>
                <span class="form__linea"></span>
            </div>
            <div class="form__grupo">
                <input type="number" name="alto" id="alto" class="form__input" placeholder=" " valvue="" >
                <label for="alto" class="form__label">Alto de la caja</label>
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
                <input type="text" name="observac" id="observac" class="form__input" placeholder=" " value="" >
                <label for="observac" class="form__label">Observación</label>
                <span class="form__linea"></span>
            </div>
        </div>
    </div>
    <div class="botones-fin">
        <div class="form__submit lectura">
            <input type="submit" class="form__submit" value="ingresar">
        </div>
        <div class="enlace--boton">
                <a href="ingprod.php" class="enlace">Agregar Producto</a>
        </div>
    </div>


    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</form>


</html>