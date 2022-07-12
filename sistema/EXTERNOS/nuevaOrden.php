<?php 

    $resultado = $_GET['resultado'] ?? null;

    //incluye el header

    require '../../includes/config/database.php';

    conectarDB();
    $db =conectarDB(); 
    
    //BASE DE DATOS BODEGA 
    conectarDB2();
    $db2 =conectarDB2();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();
    
    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    $errores = [];
    $confirm = NULL;
    //consulta generar codigo de cliente
        $cliente ="SELECT id from datosordenes where cliente = 'ronny'";
        $cod_cliente = mysqli_query($db4, $cliente);
        $cod_cliente1 = mysqli_fetch_assoc($cod_cliente);
        $cod_cliente1['id'];
        $cliente4 ="SELECT count(id) from datosordenes where cliente = 'ronny'";
        $cod_cliente2 = mysqli_query($db4, $cliente4);
        $cod_cliente3 = mysqli_fetch_assoc($cod_cliente2);
        //echo $cod_cliente3['count(id)'];
        $cod_cli = $cod_cliente1['id'] + $cod_cliente3['count(id)'] + 1 ;
        //echo $cod_cli;
    // REGISTRO DE DATOS DESDE EL FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //datos del formulario confirmación
            $nombres = mysqli_real_escape_string($db4, $_POST['nombres']);
            $cedula = mysqli_real_escape_string($db4, $_POST['cedula']);
            $direccion = mysqli_real_escape_string($db4, $_POST['direccion']);
            $correo = mysqli_real_escape_string($db4, $_POST['correo']);
            $telefono = mysqli_real_escape_string($db4, $_POST['telefono']);
            $metodoPago = mysqli_real_escape_string($db4, $_POST['metodoPago']);  
            $observacion = mysqli_real_escape_string($db4, $_POST['observacion']);
            $fecha_pago = mysqli_real_escape_string($db4, $_POST['fecha_pago']);
            $resLlamada = "CLIENTE NACIONAL";
            $cod = mysqli_real_escape_string($db4, $_POST['cod']); //variable nueva crear en la BDD
            $cliente = "ronny";
        //datos complementerios y duplicados
            $order_id = $cod_cli;// DATOS PARA CALCULO
            $order_at = date('y-m-d h:i:s'); // CAPTURAR LA FECHA DEL SISTEMA 
            //$delivery_at = mysqli_real_escape_string($db4, $_POST['delivery_at']);// DATOS DE ACTUALIZACION
            $total = mysqli_real_escape_string($db4, $_POST['total']); // captura desde el formulario
            $status = "pickUp";
            $created_at = date('y-m-d h:i:s'); // capturar la fecha del sistema 
        //datos consumo de API order_clients
            $idG  = $cod_cli."001";
            $name = mysqli_real_escape_string($db4, $_POST['nombres']);
            $last_name = mysqli_real_escape_string($db4, $_POST['nombres']);
            $province = mysqli_real_escape_string($db4, $_POST['province']);
            $city = mysqli_real_escape_string($db4, $_POST['city']);
            $address = mysqli_real_escape_string($db4, $_POST['direccion']);
            $reference = mysqli_real_escape_string($db4, $_POST['reference']);
            $phone = mysqli_real_escape_string($db4, $_POST['telefono']);
            $landline = mysqli_real_escape_string($db4, $_POST['landline']);
        //datos para el cambio en la verificacion
            $contactado = $idG;
            $facturado = null;
            $filtro = "no";
            $fechaGest = date('y-m-d h:i:s');
        //variables actualizacion de estados
            $status = "collected"; // fecha capturada como parte del historial
            $fechaGest = date('y-m-d h:i:s'); // fecha capturada como parte del historial
        
        
            if(!$nombres) {
                $errores[] = "Si no hay nombres no puedes guardar, asi no se HACE!!!!";
            }
            if(!$cedula) {
                $errores[] = "Si no hay cédula por favor agrega ceros,";
            }
            if(!$metodoPago) {
                $errores[] = "Solo tienes que elegir la forma de págo, pregunta todo!!!";
            }
            if(!$telefono) {
                $errores[] = "Si no hay cambios con la informacion inicial, solo MISMO NUMERO pero llena todos los campos!!!";
            }
            if(!$direccion) {
                $errores[] = "No solo es llenar tienes que especificar bien la direccion PILAS!!!";
            }
            if(!$fecha_pago) {
                $errores[] = "La fecha de pago tambien es importante esto también llena todo POR FAVOR!!!!";
            }
            if(!$province) {
                $errores[] = "Es necesario conocer la provincia, por favor selecciona una!!!!";
            }
            if(empty($errores)) {

                //GUARDAR DATOS DE NUEVA ORDEN
                $query4 = "INSERT INTO datosordenes (id, name, last_name, province, city, address, reference, 
                        phone, landline, order_id, order_at, total, status, created_at, nombres, cedula,
                        direccion, correo, telefono, metodoPago, estado, observacion, fecha_pago, fechaGest, resLlamada, cliente, cod ) 
                        VALUES ('$idG', '$name', '$last_name', '$province', '$city', '$address', '$reference', '$phone', 
                        '$landline', '$order_id', '$order_at', '$total', '$status', '$created_at', 
                        '$nombres', '$cedula', '$direccion', '$correo', '$telefono', '$metodoPago', '$filtro', '$observacion', '$fecha_pago', '$fechaGest', '$resLlamada', '$cliente', '$cod')";
                        $resultado1 = mysqli_query($db4, $query4);
                        //echo $query4;
                        if ($resultado1){
                            $confirm = 1;
                        }else{
                            $confirm = 2;
                        
                        }
            }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GLOBAL CARGO SYS</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

</head>


<body class="bg-gradient-primary">

    <div class="container">
            <?php foreach($errores as $error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>
            <?php if($confirm === 1) : ?>
                <div class="alert alert-success" role="alert">
                    ORDEN CREADA
                </div>
            <?php endif ?>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Nuevo envio!</h1>
                            </div>
                            <form class="user" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="nombres" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Entregar a..." minlength="8" maxlength="79">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="int"  require name="cedula" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Numero de cedula " minlength="10" maxlength="13">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="number"  require name="telefono" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Numero contacto...">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="landline" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Numero segundo contacto...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"  require name="correo" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Tiene correo o email...">
                                </div>

                                <div class="form-group">
                                    <input type="text"  require name="province" minlength="3" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Que provincia vamos...">
                                </div>
                                <div class="form-group">
                                    <input type="text"  require  name="direccion" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Direccion para la entrega...">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="date" name="fecha_pago" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Cuando entregamos...">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="200" require name="city" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="En que ciudad...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" require  name="reference" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Referencia del lugar...">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="text" require  name="cod" class="form-control form-control-user"
                                            id="exampleRepeatPassword" maxlength="2" placeholder="Debemos cobrar...">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" require name="total" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Cuanto debemos cobrar...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" require  name="metodoPago" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Como pagara el cliente...">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="observacion" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Hay algun detalle...">
                                </div>
                                <hr>
                                <input type="submit"  class="btn btn-primary btn-user btn-block" value="Crear envio">
                                </input>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>





<?php 
    incluirTemplate('fottersis');     
?>