<?php 

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

    //coneccion financiero
    conectarDB5();
    $db5 =conectarDB5();
    
    //coneccion comercial
    conectarDB6();
    $db6 =conectarDB6();
    
    //declaraicion de variables    
        $errores = [];
        $nombre = "";
        $cedula = "";
        $provincia = "";
        $ciudad = "";
        $sector = "";
        $direccion = "";
        $telefono = "";
        $cod = "";
        $valor = "";
        $fragil = "";
        $reempaque = "";
        $l = "";
        $a = "";
        $h = "";
        $peso = "";
        $estado = "";
        $fecha_reg = "";
        $asesor = "";


    //captura de variables por medio de post
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consulta = $_POST['usuario'];
             // validacion y consulta de usuario habilitado
                $consulta = "SELECT * FROM clientes WHERE cedula = '${consulta}';";
                    $ejecutar_consul = mysqli_query($db4, $consulta);
                    $valid = mysqli_fetch_assoc($ejecutar_consul);
                    if (empty($valid)){
                            echo '
                            <div class = "alert alert-success">
                                <p>Lo sentimos no encontramos tu registro, para registrarte</p>
                                <a href = "http://globalcargo-ec.com/sistema/EXTERNOS/registro_cliente.php">click aqui</a>
                            </div>';
                    }else{
                        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
                        $cedula = mysqli_real_escape_string($db, $_POST['cedula']);
                        $correo = mysqli_real_escape_string($db, $_POST['correo']);
                        $provincia = mysqli_real_escape_string($db, $_POST['provincia']);
                        $ciudad = mysqli_real_escape_string($db, $_POST['ciudad']);
                        $sector = mysqli_real_escape_string($db, $_POST['sector']);
                        $direccion = mysqli_real_escape_string($db, $_POST['direccion']);
                        $direccion_recoleccion = mysqli_real_escape_string($db, $_POST['direccion']);
                        $cod = mysqli_real_escape_string($db, $_POST['cod']);
                        $valor = mysqli_real_escape_string($db, $_POST['valor']);
                        $telefono = mysqli_real_escape_string($db, $_POST['telefono']);
                        $fragil = $_POST['fragil'];
                        $reempaque = $_POST['reempaque'];
                        $l = mysqli_real_escape_string($db, $_POST['l']);
                        $a = mysqli_real_escape_string($db, $_POST['a']);
                        $h = mysqli_real_escape_string($db, $_POST['h']);
                        $peso = mysqli_real_escape_string($db, $_POST['peso']);
                        $estado = "recolectar";
                        $fecha_reg = date('y-m-d');
                        $const_nom = $valid['vendedor'];
                        $asesor = $const_nom;

                        //validacion de ingreso de datos.
                        if(!$nombre) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$cedula) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$correo) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$provincia) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$ciudad) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$sector) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        if(!$direccion) {
                            $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
                        }
                        //query para guardar
                            $guardar_servicio = "INSERT INTO ordenes (nombre, cedula, correo, provincia, ciudad, sector, direccion, direccion_recoleccion, telefono, cod, valor, fragil, reemparque, l, a, h, peso, estado, fecha_reg, asesor)
                                                              values ('$nombre', '$cedula', '$correo', '$provincia', '$ciudad', '$sector', '$direccion', '$direccion_recoleccion', '$telefono', '$cod', '$valor', '$fragil', '$reempaque', '$l', '$a', '$h', '$peso', '$estado', '$fecha_reg', '$asesor');";
                            $ejecutar_guar = mysqli_query($db4, $guardar_servicio);
                            if ($ejecutar_guar){
                                echo '
                                <div class = "alert alert-success">
                                    <p>Tu servivicio ha sido solicitado con exito, gracias!!!</p>
                                </div>';
                                //enviar correo de notificacion primer MENSAJE DE COORDINACION
                                    $destinatario = 'mafer.fernandez@globalcargoecuador.com';
                                    $asunto = 'NUEVO SERVICIO SOLICITADO';
                                
                                // configuración del mensaje
                                    $header = "Nueva solicitud de envio registrada";
                                    $mensajeCompleto = "Hola Mafer, tenemos una  nueva solicitu de cliente.";
                                    mail($destinatario, $asunto, $mensajeCompleto, $header);
                                
                                //enviar correo de notificacion primer MENSAJE DE COORDINACION OPERATIVA
                                    $destinatario = 'camila@globalcargoecuador.com';
                                    $asunto = 'NUEVO SERVICIO SOLICITADO';
                                
                                // configuración del mensaje
                                    $header = "Nueva solicitud de envio registrada";
                                    $mensajeCompleto = "Hola CAMI, tenemos una  nueva solicitu de cliente.";
                                    mail($destinatario, $asunto, $mensajeCompleto, $header);
                               
                                //enviar correo de notificacion primer MENSAJE DE CLIENTE
                                    $destinatario2 = $correo;
                                    $asunto2 = 'HOLA, TENEMOS UNA ENTREGA PARA TI.';
                                    
                                    // configuración del mensaje
                                        $header2 = "Hola somos GC-GO tenemos un paquete para entregarte.";
                                        $mensajeCompleto2 = "Hola, somos GC-GO tenemos una entrega para ti, 
                                                            en un momento un asesor se comunicara contigo.
                                                            Esto no es un SPAM, son las notificaciones que llegaran,
                                                            de acuerdo al proceso de entrega tenga su secuencia.";
                                        mail($destinatario2, $asunto2, $mensajeCompleto2, $header2);
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

    <title>NUEVO ENVIO</title>

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
        <hr>
        <form class="user" method="post">
                <div class="alert alert-success fs-5">
                        <h1 class="fs-4">SOLICITAR NUEVO ENVIO!!</h1>
                </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="usuario" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Codigo de Cliente(Cedula)" maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="email"  require name="correo" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Correo de Consignatario..." maxlength="70">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="nombre" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Nombre y Apellido Consignatario..." maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="number"  require name="cedula" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Cedula Consignatario..." maxlength="13">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="provincia" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Provincia.." maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="text"  require name="ciudad" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Ciudad" maxlength="79">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="sector" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Sector de entrega..." maxlength="79">
                </div>
                <div class="col-sm-6">
                    <input type="text"  require name="direccion" class="form-control form-control-user" id="exampleLastName"
                        placeholder="Direccion de entrega" maxlength="79">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="number" require name="telefono" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Telefono de consignatario..." maxlength="10">
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <select require name="cod" class="form-control form-control-user" id="exampleFirstName">
                        <option selected>Necesitas que cobremos </option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="valor" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Valor por cobrar.." maxlength="79">
                </div>
                <div class="col-sm-6">
                    <select require name="fragil" class="form-control form-control-user" id="exampleFirstName">
                        <option selected>Es fragil...?</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" placeholder="Largo" aria-label="largo" name="l">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" placeholder="Ancho" aria-label="ancho" name="a">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" placeholder="Altura" aria-label="altura" name="h">
                </div>
                <div class="col-sm">
                    <input type="text" class="form-control form-control-user" placeholder="Peso" aria-label="peso" name="peso">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" require name="valor" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Valor por cobrar.." maxlength="79">
                </div>
                <div class="col-sm-6">
                    <select require name="reempaque" class="form-control form-control-user" id="exampleFirstName">
                        <option selected>Lo volvemos a empacar...?</option>
                        <option value="si">si</option>
                        <option value="no">no</option>
                    </select>
                </div>
            </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary btn-user btn-block" title="REGISTRAR CLIENTE">SOLICITAR ENVIO</button>
                </div>
        </form>
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src = "../../js/confirmacion.js"></script>
    </body>
</html>