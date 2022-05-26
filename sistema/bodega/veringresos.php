<?php  
    $resultado = $_GET['resultado'] ?? null; 
    $id = $_GET['id'] ?? NULL;
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
            
            $m3entrad = $largo * $ancho * $alto;
            $m3total = $m3entrad * $cCaja;

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
<?php 
    //consultar los datos de la tabla general
    $query2 = "SELECT * FROM ingresog ORDER BY fIngres DESC";
    $consultaG = mysqli_query($db2, $query2);
?>
<h2 class="form__titulo titulo__pagina">DETALLE DE CARGAS CONSIGNADAS</h2>
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
                <th>DETALLES</th>
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
                    <td>
                        <div class="accion__actualizar">
                            <a href="verdetalles.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">VER</a>
                        </div>
                        <div class="accion__actualizar">
                            <a href="detalle_ing.php?id=<?php echo $datos['id']; ?>" class="acciones__enlace">INGRESAR</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="boton__anidado">
        <a href="../<?php echo $_SESSION['rol']; ?>.php" class="enlace">salir sin guardar</a>
    </div>
</html>