<?php
//coneccion a la base de datos
require '../../includes/config/database.php';
conectarDB();
$db = conectarDB();

//BASE DE DATOS BODEGA 
conectarDB2();
$db2 = conectarDB2();

//CONECCION API
conectarDB3();
$db3 = conectarDB3();

//CONECCION CALLCENTER
conectarDB4();
$db4 = conectarDB4();

//CONECCION FINANCIERO
conectarDB6();
$db6 = conectarDB6();

//autenticar el usuario
$errores = [];
$contrasena = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasena = mysqli_real_escape_string($db, $_POST['contrasena']);
    if (!$contrasena) {
        $errores[] = "No se ingreso ningun codigo de cliente";
    }
    if(empty($errores)){
        //revisar si el usuario existe
        $query = "SELECT * FROM clientes WHERE cedula = '${contrasena}' ";
        $resultado = mysqli_query($db4, $query);
        
        if( $resultado->num_rows){
            //revisar si el pasword es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            if ($usuario['cedula'] === $contrasena){
                //var_dump($usuario);
                //El usuario está autentiacado
                session_start();
                //pasar datos en la super global session 
                $_SESSION['login'] = true;
                $_SESSION['cedula'] = $usuario['cedula'];
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['emprendimiento'] = $usuario['emprendimiento'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['apellido'] = $usuario['apellido'];
                $_SESSION['telefono'] = $usuario['telefono'];

                header('location: master_cliente.php');
            }
        }else {
            $errores[] = "El codigo de cliente ingresado no existe, por favor comunicate con tu asesor";
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
    <meta name="description" content="Consulta de estado de envios realizados con los asesores comerciales de GC-Go estado en tiempo real">
    <meta name="author" content="Mahsa WebCorp">

    <title>CONSULTAS GC-GO</title>

    <!-- agregando favicion de gc-go -->
    <link rel="icon" href="../../IMG/gc-go.png" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container vw-100">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <figure class="col-lg-6 d-none d-lg-block figure m-auto">
                                <img src="../../IMG/gc-go.png" class="figure-img img-fluid m-auto" alt="...">
                            </figure>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            CONSULTAR INFORMACION
                                        </h1>
                                        <h6>
                                            Un gusto verte por aqui, para ingresar por favor ingresa tu codigo de cliente.
                                            Si no lo recuerdas, comunicate con tu asesor, el te puede ayudar.
                                        </h6>
                                        <br>
                                    </div>
                                    <form method="post" action=" " class="user">
                                        <?php foreach ($errores as $error) : ?>
                                            <div class="alert alert-warning">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php endforeach ?>
                                        <div class="form-group">
                                            <input type="password" name="contrasena" class="form-control form-control-user" id="exampleInputPassword" placeholder="Ingresar el codigo de CLIENTE">
                                        </div>
                                        <div class="form-group">
                                        </div>
                                        <input type="submit" href="index.html" class="btn btn-primary btn-user btn-block" value="Consultar Informacion">
                                        <hr>
                                    </form>
                                    <p class="m-auto">
                                        Gracias por confiar en GC-Go.
                                    </p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>



</body>

</html>