<?php
//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

//caracterizacion de la pagina. Cambia los estados a UNDELIVERED con el comentario EN CENTRO LOGISTICO 
//registra las ordenes con el distrito y subdistrito para la creacion de manifiestos automaticos de control.

//consultar datos de ordenes con estado requested
$ordenes_requested = "SELECT * FROM orders WHERE status = 'collected'";
$eje_ordenes_requested = mysqli_query($db3, $ordenes_requested);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = mysqli_real_escape_string($db3, $_POST['id']);
    

    //crear el numero de despacho
        //variables generales
        $carrier_name = 'Centro de Distribucion';
        $delivery_at = null;
        $transport_type = 'Distribucion Provincial';
        $status = 'undelivered'; // utilizada en la tabla estatus de historial
        $observation = 'En ruta para entrega';
        $order_id = $id;
        $created_at = mysqli_real_escape_string($db3, $_POST['created_at']);
        date_default_timezone_set("America/Bogota");
        date_default_timezone_get();
        $updated_at = date("Y-m-d G:i:s");
        $deleted_at = null;
        //variables de la tabla MOTOR
        $responsable_distrito = mysqli_real_escape_string($db4, $_POST['responsable_distrito']);
        $responsable_sub_distrito = mysqli_real_escape_string($db4, $_POST['responsable_sub_distrito']);

    //actualizar el estado en la tabla orders
        $actualizar_estado = "UPDATE orders SET status = 'undelivered', updated_at = '${updated_at}' WHERE id = '${id}';";
        $eje_actualizar_estado = mysqli_query($db3, $actualizar_estado);    

    //reportar con historial de gestion
        //consultar el id del despacho
        $buscar_id_despacho = "SELECT * FROM dispatches WHERE order_id = '${id}';";
        $eje_buscar_id_despacho = mysqli_query($db3, $buscar_id_despacho);
        $id_despacho = mysqli_fetch_assoc($eje_buscar_id_despacho); 
        $id_despacho2 = $id_despacho['id'];
        //variables generales
        $dispatch_id = $id_despacho2;
        $user_id = $_SESSION['id'];

    //actualizar dispatches con el id
        //crear el numero de despacho

        $actualizar_dispatches = "UPDATE dispatches SET 
                                status = '${status}',
                                carrier_name = '${carrier_name}',  
                                transport_type = '${transport_type}', 
                                updated_at = '${updated_at}',
                                observation = '${observation}' 
                                WHERE id = '${id_despacho2}';";
        $eje_actualizar_dispatches = mysqli_query($db3, $actualizar_dispatches);

        //query para guardar el hostirial
        $historial = "INSERT INTO dispatch_statuses (status, comment, dispatch_id, user_id, created_at, updated_at, deleted_at)
                                    VALUES ('${status}', '${observation}', '${dispatch_id}', '1', '${created_at}', '${updated_at}', null);";
        $eje_historial = mysqli_query($db3, $historial);

    //asiganacion de distrito y captura de datos en el motor de control, TABLA.
        $guardar_distrito = "INSERT INTO registro (id, order_id, fecha_proceso, n_manifiesto, distrito, sub_distrito, estado_control, estado_cod, monto_cod, observacion)
                                        VALUES ('${dispatch_id}', '${id}', '${updated_at}', null, '${responsable_distrito}', '${responsable_sub_distrito}', 'Despachado', null, null, null);";
        $eje_guardar_distrito = mysqli_query($db4, $guardar_distrito);

    if ($eje_historial) {
        echo "<script>
                alert('Orden actualizada con exito');
                window.location.href='lista_despacho.php';
              </script>";
    } else {
        echo "
            <div class='alert alert-danger' role='alert'>
                <strong>Error!</strong> 
                No se pudo borrar a esa buena persona.
            </div>";
        exit;
    }
}

?>

<body class="bg-gradient-primary">
    <div class="container">
        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Numero de Orden</th>
                        <th>Fecha de creacion</th>
                        <th>Distrito</th>
                        <th>Sub Distrito</th>
                        <th>Direccion</th>
                        <th>Ver productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($orders = mysqli_fetch_assoc($eje_ordenes_requested)) : ?>
                        <form action=" " method="POST">
                        <tr>
                            <td><?php echo $orders['order_id']; ?></td>
                            <td><?php echo $orders['order_at']; ?></td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_distrito = $distrito3['canton'];

                                //consultar el nombre del distrito
                                $buscar_distrito = "SELECT * FROM cantones WHERE nombre_canton = '${consulta_distrito}';";
                                $eje_buscar_distrito = mysqli_query($db, $buscar_distrito);
                                $distrito = mysqli_fetch_assoc($eje_buscar_distrito);
                                $n_distrito = $distrito['distrito'];

                                //nombre del distrito
                                $nombre_distrito = "SELECT * FROM distrito WHERE id = '${n_distrito}';";
                                $eje_nombre_distrito = mysqli_query($db, $nombre_distrito);
                                $distrito21 = mysqli_fetch_assoc($eje_nombre_distrito);
                                echo $distrito21['nombre'];
                                ?>
                                <input type="text" hidden name="responsable_distrito" value="<?php echo $distrito21['id']; ?>" id="">
                            </td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_distrito = $distrito3['canton'];
                                //consultar el nombre del distrito
                                $buscar_distrito = "SELECT * FROM cantones WHERE nombre_canton = '${consulta_distrito}';";
                                $eje_buscar_distrito = mysqli_query($db, $buscar_distrito);
                                $distrito = mysqli_fetch_assoc($eje_buscar_distrito);
                                $n_distrito = $distrito['sub_distrito'];
                                

                                //nombre del distrito
                                $nombre_subdistrito = "SELECT * FROM sub_distrito WHERE id = '${n_distrito}';";
                                $eje_nombre_subdistrito = mysqli_query($db, $nombre_subdistrito);
                                $distrito2 = mysqli_fetch_assoc($eje_nombre_subdistrito);

                                if ($distrito2 == null) {
                                    echo "No hay sub distrito";
                                } else {
                                    $sub_distrito = $distrito2['nombre'];
                                    $id_sub_distrito = $distrito2['id'];
                                    echo $sub_distrito;
                                }
                                ?>
                                <input type="text" hidden name="responsable_sub_distrito" value="<?php echo $distrito2['id']; ?>" id="">

                            </td>
                            <td>
                                <?php
                                //buscar el nombre del canton
                                $canton = $orders['id'];
                                $buscar_distrito = "SELECT * FROM order_clients WHERE order_id = '${canton}';";
                                $eje_buscar_distrito = mysqli_query($db3, $buscar_distrito);
                                $distrito3 = mysqli_fetch_assoc($eje_buscar_distrito);
                                $consulta_provincia = $distrito3['address'];
                                echo $consulta_provincia;
                                ?>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $orders['order_id']; ?>">
                                    Productos
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop<?php echo $orders['order_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Listado de Productos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php $productos =  $orders['id'];
                                                $buscar_productos = "SELECT * FROM order_products WHERE order_id = '${productos}';";
                                                $eje_buscar_productos = mysqli_query($db3, $buscar_productos);
                                                while ($productos = mysqli_fetch_assoc($eje_buscar_productos)) : ?>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <strong>Producto: </strong> <?php echo $productos['name']; ?>
                                                            <br><strong>Cantidad: </strong> <?php echo $productos['quantity']; ?>
                                                        </li>
                                                    </ul>
                                                <?php endwhile; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Listo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <input type="text" hidden name="id" value="<?php echo $orders['id'];?>" id="">
                                        <input type="text" hidden name="created_at" value="<?php echo $orders['created_at'];?>" id="">
                                        <button type="submit" class="btn btn-success">Despachar</button>
                                        <a href="guia_cosm.php?id=<?php echo $orders['id']?>" class="btn btn-primary">Guia</a>
                                        
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php 
incluirTemplate('fottersis')
?>