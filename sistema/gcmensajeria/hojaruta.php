<?php 
    $resultado = $_GET['resultado'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('headersis');
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }

    // //agragar la seleccion del cliente 
    // //$consulta = "SELECT * FROM cliente";
    // //$resultado = mysqli_query($db, $consulta);
    
    // //notificar despacho a bodega
    // //solitar factura de la venta
    // $destinatario = 'mafer.fernandez@globalcargoecuador.com';
    // // datos del correo

    // $nombre = $_POST['nombre'];
    // $empresa = $_POST['empresa'];
    // $email = $_POST['email'];
    // $telefono = $_POST['telefono'];
    // $mensaje = $_POST['mensaje'];
    // $asunto = 'Necesito contactarme con ustedes';

    // // configuración del mensaje
    // // $header = "Mensaje enviado desde la web";
    // // $mensajeCompleto = "$mensaje</br>". "<br>Atentamente</br>". $nombre ."</br>$telefono". "<br>$email</br>";
    
    // // mail($destinatario, $asunto, $mensajeCompleto, $header);
    // // echo "<script>alert('Su correo se envió exitosamente')</script>";
    // // echo "<script> setTimeout(\"location.href='../globalcargo/globalcargo.php'\",1000)</script>";

    // $errores = [];

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //     //echo "<pre>";
    //     //var_dump($_POST);
    //     //echo "</pre>";

    //     $id = $_POST['id'];
    //     $n_orden = $_POST['n_orden'];
    //     $nombres = $_POST['nombres'];
    //     $apellidos = $_POST['apellidos'];
    //     $cedula = $_POST['cedula'];
    //     $direccion = $_POST['direccion'];
    //     $correo = $_POST['correo'];
    //     $telefono = $_POST['telefono'];
    //     $metodoPago = $_POST['metodoPago'];
    //     //==================================
    //     //tabla ordenes
    //     $id = $_POST['id'];
    //     $order_id = $_POST['order_id'];
    //     $order_at = $_POST['order_at'];
    //     $delivery_at = $_POST['delivery_at'];
    //     $total = $_POST['total'];
    //     $status = $_POST['status'];
    //     $created_ad = $_POST['create_at'];
    //     $total = $_POST['total'];
    //     //==================================
    //     //tabla ordenes cliente
    //     $id = $_POST['id'];
    //     $name = $_POST['name'];
    //     $last_name = $_POST['last_name'];
    //     $province = $_POST['province'];
    //     $city = $_POST['city'];
    //     $address = $_POST['address'];
    //     $reference = $_POST['reference'];
    //     $phone = $_POST['phone'];
    //     $landline = $_POST['landline'];
    //     //clave foranea relacionada con ordenes
    //     $order_id = $_POST['order_id'];
    //     //==================================
    //     //tabla ordenes productos
    //     $id = $_POST['id'];
    //     $name = $_POST['name'];
    //     $unit_price = $_POST['unit_price'];
    //     $quantity = $_POST['quantity'];
    //     $product_id = $_POST['product_id'];
    //     $created_at = $_POST['created_at'];
    //     //clave foranea relacionada con ordenes
    //     $order_id = $_POST['order_id'];


    //     //echo "<pre>";
    //     //var_dump($usuario);
    //     //echo "</pre>";

    //     // validar el formulario

    //     if(empty($errores)) {
    //         // consultar datos de la API SELECT * from ingresog INNER JOIN ingreso on ingresog.id = ingreso.idIngresog order by nGuia
            

    //             //if ($resultado) {
    //                 //header('location: ../superAdmin.php?resultado=1');
    //             //}
    //     }

    // }

    

    $query = "SELECT * FROM orders INNER JOIN order_clients ON orders.id = order_clients.order_id";

            $resultado = mysqli_query($db3, $query);
                //echo "hasta aquí funciona" ;
            
            // $consultaApi = mysqli_fetch_assoc($resultado);

            // echo "<pre>";
            // var_dump($consultaApi);
            // echo "</pre>";
?>

    <p class="form__pp">
        Hola <?php echo $_SESSION['nombre']?> bienvenido, 
        antes de salir a ruta, verifica tus paquetes.
    </p>

<div class="contenerdor__prin2">
    <!-- <fieldset class="form__p1" method="POST"> -->
        <!-- <legend>GUIAS CONSIGNADAS</legend> -->
        <?php 
        
        
        ?>
        <table class="table__query">
            <thead class="thead">
                <tr >
                    <th class="th">N. Guia</th>
                    <th class="th">Nombre</th>
                    <th class="th">M Pago</th>
                    <th class="th">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                    <td class="td"></td>
                </tr>
            </tbody>
        </table>
    <!-- </fieldset> -->
</div>
