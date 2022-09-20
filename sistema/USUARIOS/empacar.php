<?php
//actualiza el estado a collected, no se recibe por get solo por post

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
//coneccion api
conectarDB();
$db = conectarDB();

//coneccion api
conectarDB3();
$db3 = conectarDB3();

//coneccion callcenter
conectarDB4();
$db4 = conectarDB4();

$id =''; //id de la orden

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = mysqli_real_escape_string($db3, $_POST['id']);
    
    //actualizar el estado en la tabla orders
    $actualizar_estado = "UPDATE orders SET status = 'collected' WHERE id = '${id}';";
    $eje_actualizar_estado = mysqli_query($db3, $actualizar_estado);

    //crear el numero de despacho
        //variables generales
        $carrier_name = 'Centro de Distribucion';
        $delivery_at = null;
        $transport_type = 'Camion Recolector';
        $status = 'collected'; // utilizada en la tabla estatus de historial
        $observation = 'Orden lista para ser despachada';
        $order_id = $id;
        $created_at = mysqli_real_escape_string($db3, $_POST['created_at']);
        date_default_timezone_set("America/Bogota");
        date_default_timezone_get();
        $updated_at = date("Y-m-d G:i:s");
        $deleted_at = null;

        $dispatches = "INSERT INTO dispatches (carrier_name, delivery_at, transport_type, status, observation, order_id, created_at, updated_at, deleted_at) 
        VALUES ('${carrier_name}', null, '${transport_type}', '${status}', '${observation}', '${order_id}', '${created_at}', '${updated_at}', null);";
        $eje_dispatches = mysqli_query($db3, $dispatches);
    
    //reportar con historial de gestion
        //consultar el id del despacho
        $buscar_id_despacho = "SELECT * FROM dispatches WHERE order_id = '${id}';";
        $eje_buscar_id_despacho = mysqli_query($db3, $buscar_id_despacho);
        $id_despacho = mysqli_fetch_assoc($eje_buscar_id_despacho); 
        $id_despacho2 = $id_despacho['id'];
        //variables generales
        $dispatch_id = $id_despacho2;
        $user_id = $_SESSION['id'];
        //query para guardar el hostirial
        $historial = "INSERT INTO dispatch_statuses (status, comment, dispatch_id, user_id, created_at, updated_at, deleted_at)
                                    VALUES ('${status}', '${observation}', '${dispatch_id}', '1', '${created_at}', '${updated_at}', null);";
        $eje_historial = mysqli_query($db3, $historial);
    if ($eje_historial) {
        echo "<script>
                guardar();
                window.location.href='listade_empaque.php';
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