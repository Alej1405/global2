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

    //coneccion callcenter
    conectarDB5();
    $db5 =conectarDB5();
    
    //coneccion callcenter
    conectarDB6();
    $db6 =conectarDB6();
    
    //declaraicion de variables    
        $errores = [];
        $nombre = "";
        $apellido = "";
        $telefono1 = "";
        $telefono2 = "";
        $cedula = "";
        $direccion ="";
        $cuenta_banco = "";
        $banco = "";
        $correo = "";
        $emprendimiento = "";
        $actividad_comercial = "";
        $productos = "";
        $referencias = "";
        $vendedor = "";
        $fecha_registro = "";
        $revision = "";


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
            $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
            $telefono1 = mysqli_real_escape_string($db, $_POST['telefono1']);
            $telefono2 = mysqli_real_escape_string($db, $_POST['telefono2']);
            $cedula = mysqli_real_escape_string($db, $_POST['cedula']);
            $direccion =mysqli_real_escape_string($db, $_POST['direccion']);
            $cuenta_banco = $_POST['cuenta_banco'];
            $banco = mysqli_real_escape_string($db, $_POST['banco']);
            $correo = mysqli_real_escape_string($db, $_POST['correo']);
            $emprendimiento = mysqli_real_escape_string($db, $_POST['emprendimiento']);
            $actividad_comercial = mysqli_real_escape_string($db, $_POST['actividad_comercial']);
            $productos = mysqli_real_escape_string($db, $_POST['productos']);
            $referencias = mysqli_real_escape_string($db, $_POST['referencias']);
            $vendedor = mysqli_real_escape_string($db, $_POST['vendedor']);
            $fecha_registro = date('y-m-d');

            if(!$nombre) {
                $errores[] = "HEY TE FALTA UN DATO!!!! AGREGA EL NOMBRE";
            }
            if(!$apellido) {
                $errores[] = "HEY!!!! AYUDANO CON TU APELLIDO";
            }
            if(!$telefono1) {
                $errores[] = "TE FALTO!!!! NECESITAMOS UN CONTACTO POR FAVOR AGREGA";
            }
            if(!$cedula) {
                $errores[] = "HEY FALTO ALGO!!!! IMPORTANTE MUY IMPORTANTE LA CEDULA O RUC";
            }
            if(!$correo) {
                $errores[] = "QUE HACEEEEEEEE!!!! FALTO EL CORREO ES IMPORTANTE";
            }
            if(!$productos) {
                $errores[] = "HEY!!!! POR FAVOR CUENTANOS QUE VAMOS A TRANSPORTAR";
            }
            if(empty($errores)) {
            
                //query guardar los datos en la base 
                    $G_cliente = "INSERT INTO clientes (nombre, apellido, telefono1, telefono2, cedula, direccion, cuenta_banco, banco, correo, emprendimiento, actividad_comercial, productos, referencias, vendedor, fecha_registro)
                    values ('$nombre', '$apellido', '$telefono1', '$telefono2', '$cedula', '$direccion', '$cuenta_banco', '$banco', '$correo', '$emprendimiento', '$actividad_comercial', '$productos', '$referencias', '$vendedor', '$fecha_registro')";
        
                    // prueba de queryecho $G_cliente;    
                    $guardar = mysqli_query($db4, $G_cliente);
                        if ($guardar){
                            
                                //enviar correo de notificacion primer MENSAJE 
                                    $destinatario = 'mafer.fernandez@globalcargoecuador.com';
                                    $asunto = 'NUEVO CLIENTE REGISTRADO';
                                    
                                    // configuración del mensaje
                                        $header = "Nuevo cliente registrado por medio del link.";
                                        $mensajeCompleto = "Hola Mafer, un nuevo registro se encuentra procesado,
                                                            por favor verificar si todos los datos estan correctos.";
                                        mail($destinatario, $asunto, $mensajeCompleto, $header);
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
        <!-- FORMULARIO DE ACTUALIZACION -->
            <!-- <v class="card bg-light"> -->
                    <?php foreach($errores as $error) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>
                <hr>
                <div class="alert alert-success fs-5">
                        <h1 class="fs-4">GRACIAS POR REGISTRARTE!!!!</h1>
                        <p class="fs-5">Empecemos, por favor llena los datos del formulario,
                            cuando termines, revisa tu correo con informacion importante.
                        </p>
                </div>
                <form class="user" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="nombre" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="Nombre..." maxlength="79">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="int"  require name="apellido" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Apellido..." maxlength="79">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <input type="number"  require name="telefono1" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Primer contacto..." maxlength="10">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" name="telefono2" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Segundo contacto..." maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" minlength="10" maxlength="13" require name="cedula" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Numero de cedula...">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" require name="correo" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Correo electronico...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" name="cuenta_banco" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Numero de cuenta...">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="80" name="banco" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="A que banco pertenece...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text"  require name="direccion" minlength="3" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Direccion domiciliaria.">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="actividad_comercial" minlength="8" maxlength="200" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Que hace tu negocio...">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="emprendimiento" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Como se llama tu negocio...?">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" minlength="8" maxlength="200" require name="productos" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Que productos vendes...?">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" require name="referencias" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Ayudame con una referencia personal...?">
                                    </div>
                                    <div class="col-sm-6">
                                        <select type="text" minlength="8" maxlength="200" require name="vendedor" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Que productos vendes...?">
                                                <option selected>Selecciona un nombre</option>
                                                <option value="Katherine Perez">Katherine Perez</option>
                                                <option value="Bryan Ramos">Bryan Ramos</option>
                                                <option value="Luis Revilla">Luis Revilla</option>
                                                <option value="Domenica Fajardo">Domenica Fajardo</option>
                                                <option value="Camila Pazmino">Camila Pazmino</option>
                                                <option value="Krystel Quintong">Krystel Quintong</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-user btn-block" title="REGISTRAR CLIENTE">registrar</button>
                </form>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src = "../../js/confirmacion.js"></script>
</body>
</html>