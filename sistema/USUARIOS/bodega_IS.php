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
    $ciudad = null;
    $filtro = null;

    //filtro de orden
    $filtro = "SELECT * FROM datosordenes WHERE status = 'returnes' order by responsable_m ASC";
        $query = $filtro;
        $resultado = mysqli_query($db4, $query);
        
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //REGSITRAR EL MOVIMIENTO DEL PAQUETE   
            $id = $_POST['id'];
            $ubicacion_p = "Ingreso a bodega";
            $resp_ubp = $_SESSION['usuario'];
            $responsable_m = "Envia el mismo";
            $observacion = "Ingreso a bodega";
            
            $actualizar_mov = "UPDATE datosordenes set ubicacion_p = '${ubicacion_p}' WHERE id = '${id}';";
            $act_query = mysqli_query($db4, $actualizar_mov);
            //historial
            $historial_ubicacion = "INSERT INTO historial_paquetes (id_primary, responsable_m, ubicacion_p, observacion, res_ubp) VALUES 
                                                            ('${id}', '${responsable_m}', '${ubicacion_p}', '${observacion}', '${resp_ubp}');";
                    $his_ubicacion = mysqli_query($db4, $historial_ubicacion);
        
    }

    

?>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="table-wrapper-scroll-y my-custom-scrollbar mt-4" style="overflow-x: auto"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>GESTION</th>
                        <th>RESPONSABLE</th>
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
                            <td class="btn-group-vertical">
                            <form method="POST">
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