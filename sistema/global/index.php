<?php


    //coneccion a la base de datos
    require '../../includes/config/database.php';
    conectarDB();
    $db =conectarDB();

    //autenticar el usuario
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // var_dump($_POST);

        $email = mysqli_real_escape_string($db, $_POST['email'] );
        $contrasena = mysqli_real_escape_string($db, $_POST['contrasena'] );

        if(!$email) {
            $errores[] = "No se que estas haciendo pero ese usuario está mal, jejejé";
        }
        if(!$contrasena) {
            $errores[] = "La contraseña tambien está mal, asi no se puede...";
        }

        if(empty($errores)){
            //revisar si el usuario existe
            $query = "SELECT * FROM usuario WHERE correo1 = '${email}' ";
            $resultado = mysqli_query($db, $query);
            
            if( $resultado->num_rows){
                //revisar si el pasword es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                if ($usuario['cedula'] === $contrasena){

                    //tiempo de inicio de sesion
                    ini_set("session.cookie_lifetime","2");
                    ini_set("session.gc_maxlifetime","2");

                    //El usuario está autentiacado
                    session_start();

                    //pasar datos en la super global session 
                    $_SESSION['login'] = true;
                    $_SESSION['rol'] = $usuario['tipo'];
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['usuario'] = $usuario['correo1'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['apellido'] = $usuario['apellido'];
                    $_SESSION['cliente'] = $usuario['cliente'];
                    $_SESSION['foto'] = $usuario['foto'];
                    $_SESSION['cedula'] = $usuario['cedula'];

                //guardar la hora de ingreso en la base de datos
                date_default_timezone_set("America/Bogota");
                date_default_timezone_get();
                $hora_ingreso =  date('G:i:s');
                $fecha_ingreso = date('Y-m-d');
                //guardar la hora de ingreso en la base de datos
                if($hora_ingreso >= '7:50:00'){
                    $consulta = "SELECT * FROM registro_horarios WHERE usuario_id = ${_SESSION['id']} AND fecha = '${fecha_ingreso}';";
                    $ejecutar = mysqli_query($db, $consulta);
                    $resultado_consulta = mysqli_fetch_assoc($ejecutar);
                    if ($resultado_consulta == null) {
                        $query_ingreso = "INSERT INTO registro_horarios (hora_ingreso, hora_almuerzo, hora_ingreso_almuerzo, hora_salida, usuario_id, fecha, nombre) 
                                                    VALUES ('${hora_ingreso}', '0:00:00', '0:00:00', '0:00:00', '${_SESSION['id']}', '${fecha_ingreso}', '${_SESSION['nombre']}');";
                        $resultado_ingreso = mysqli_query($db, $query_ingreso);
                    }
                }
                    
                    header('location: admin.php');
                    switch ($_SESSION['rol']){
                        case "admin":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "recursos humanos":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "coordinacionP":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "gerencia_paqueteria":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "asesor":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "superAdmin":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "superAdmin2":
                            header('location: ../superAdmin2.php');
                            break;
                        case "comercial":
                            header('location: ../comercial.php');
                            break;
                        case "facturacion":
                            header('location: ../facturacion.php');
                            break;
                        case "adminBodega":
                            header('location: ../adminBodega.php');
                            break;
                        case "bodega":
                            header('location: ../bodega.php');
                            break;
                        case "callcenter":
                            header('location: ../callcenterAdmin.php');
                            break;
                        case "motorizado": // ingreso de motorizados derivado a pantalla responsive
                            header('location: ../EXTERNOS/motorizados.php');
                            break;
                        case "coordinacion":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "seguimiento":
                            header('location: ../USUARIOS/usuarios.php');
                            break;
                        case "cliente":
                            header('location: ../CLIENTE/cliente.php');
                            break;
                        case "cliente1":
                            header('location: ../CLIENTE/nuevaOrden.php');
                            break;
                    }

                }else{
                    $errores[] = "QUE HACEEEE, ESA CONTRASEÑA ESTA MAL...";
                }
                
            }else {
                $errores[] = "CHIII QUIEN ERES, TU USUARIO NO EXISTE";
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

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">HOLA !!!</h1>
                                    </div>
                                    <form method="post" action=" " class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="contrasena" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            
                                        </div>
                                        <input type="submit" href="index.html" class="btn btn-primary btn-user btn-block" value="Ingresar">   
                                        <hr>
                                    </form>
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