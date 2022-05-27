<?php 
    $resultado = $_GET['resultado'] ?? null;

    //incluye el header
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('location: ../index.php');
    }

    require '../../includes/config/database.php';
    incluirTemplate('headersis2');
    conectarDB();
    $db =conectarDB(); 
    
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //conexion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    //variables de la pagina
    $ciudad = null;
    $filtro = null;
    $CONFIRM = null;
    $erroes = []; 

    //filtro de orden
    $filtro = "SELECT * FROM datosordenes order by responsable_m desc";
        $query = $filtro;
        $resultado = mysqli_query($db4, $query);
    
    //VARIABLES DE CONFIRMACION
    
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //REGSITRAR EL MOVIMIENTO DEL PAQUETE   
        $id = $_POST['id'];
        $ubicacion_p = "Ingreso a bodega";
        $resp_ubp = $_SESSION['usuario'];
        $responsable_m = "Envia el mismo";
        $observacion = "Ingreso a bodega";
        $responsable = $_SESSION['usuario'];
        //REINGRESOS A BODEGA
            //sonsultar el numero de unidades para el reingreso a bodega
            $consul_unid = "SELECT SUM(quantity) FROM order_products WHERE order_id = '${id}';";
                $eje_consul = mysqli_query($db3, $consul_unid);
                $unidades_ing = mysqli_fetch_assoc($eje_consul);
            //fin
            $unidades= $unidades_ing['SUM(quantity)']; 
            $fecha_seg = $_POST['fecha_seg'];
            $lugarAlmacenamiento = 'BODEGA';
        
        if(!$fecha_seg) {
                $errores[] = "EMPEZO!!!!! PONGA LA FECHA SI NO, COMO!!!!";
        }
        if(empty($errores)) {
                $actualizar_mov = "UPDATE datosordenes set ubicacion_p = '${ubicacion_p}' WHERE id = '${id}';";
                $act_query = mysqli_query($db4, $actualizar_mov);
                //historial
                $historial_ubicacion = "INSERT INTO historial_paquetes (id_primary, responsable_m, ubicacion_p, observacion, res_ubp) VALUES 
                                                                ('${id}', '${responsable_m}', '${ubicacion_p}', '${observacion}', '${resp_ubp}');";
                        $his_ubicacion = mysqli_query($db4, $historial_ubicacion);
            
            //agregar los reingresos a la base de datos
                        $ubicacion_bodega = "INSERT INTO reingreso (unidades, fecha, lugarAlmacenamiento, observacion, responsable, nguia, marca, order_id) VALUES 
                                                                ('${unidades}', '${fecha_seg}', '${lugarAlmacenamiento}', '${observacion}', '${responsable}', ' ', ' ', '${id}')";
                        //echo $ubicacion_bodega;
                        //exit;
                        $reing_ubicacion = mysqli_query($db2, $ubicacion_bodega);
                if ($reing_ubicacion){
                    $CONFIRM = 1;   
                }else{
                    $CONFIRM = 2;
                }
        }
    }

    

?>
<body class="bg-gradient-primary">
    <div class="container">
    <?php if(intval($CONFIRM) === 1 ): ?>
         <p class="alert alert-success">INGRESO REGISTRADO BIEN HECHO!!!!</p>
     <?php elseif(intval($CONFIRM) === 2 ): ?>
         <p class="alert alert-danger">QUESF!!! HAGA BIEN NO SE PUEDE ASI!!!!</p>
     <?php endif ?>
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>GESTION</th>
                        <th>RESPONSABLE</th>
                        <th>FECHA DE INGRESO</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($resultadoApi = mysqli_fetch_assoc($resultado)) : ?>
                        <tr>
                            <td class="fs-6">
                                <?php echo $resultadoApi['order_id']; ?>
                            </td>
                            <td class="fs-6">
                                <?php 
                                    echo $resultadoApi['ubicacion_p'];
                                ?>
                            </td>
                            <td class="fs-6">
                                <?php echo $resultadoApi['responsable_m']; ?>
                            </td>
                            <form method="POST">
                            <td class="fs-6">
                                <input type="date" name="fecha_seg" id="fecha_seg">
                            </td>
                            <td class="btn-group-vertical">
                                <input type="hidden" name="id" value="<?php echo $resultadoApi['id']; ?>">
                                <input type="submit" class="btn btn-warning" value="EN BODEGA">
                            </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
    incluirTemplate('fottersis');     
?>