<?php 
    $error = $_GET['error'] ?? null; 

    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    //coneccion de sesion
    conectarDB();
    $db =conectarDB();

    //coneccion api
    conectarDB3();
    $db3 =conectarDB3();

    //coneccion callcenter
    conectarDB4();
    $db4 =conectarDB4();

    //$auth = estaAutenticado(); //averiguar que pasa con esta liena de codigo

    
    $orden = null;
    $filtro = null;
    //declarar el valor para la consulta de la query.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orden = $_POST['orden'];
        $filtro ="WHERE order_id = ${orden}";   
    }


    $query = "SELECT * FROM orders ${filtro}";


            $resultado = mysqli_query($db3, $query);
?>

<!-- inicio de formulario de actualizacion -busqueda de ordenes- -->
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
<!-- fin de inicio de formulario de actualizacion -busqueda de ordenes- -->

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
                                        <h1 class="h4 text-gray-900 mb-4">REPORTES</h1>
                                    </div>

                                        <?php if(intval($error) === 1 ): ?>
                                            <p class="alert alert-danger">NO HAY UN ESTADO QUE REPORTAR, INGRESA BIEN!!!!</p>
                                        <?php elseif(intval($error) === 2 ): ?>
                                            <p class="alert alert-danger">AGREGA LA OBSERVACION!!!!</p>
                                        <?php elseif(intval($error) === 3 ): ?>
                                            <p class="alert alert-success">ESTADO REPORTADO GENIAL!!!!</p>
                                        <?php elseif(intval($error) === 4 ): ?>
                                            <p class="alert alert-warning">LA ORDEN FUE CERRADA SI NECESITAS REPORTAR, INFORMA A COORDINACION!!!!</p>
                                        <?php elseif(intval($error) === 5 ): ?>
                                            <p class="alert alert-danger">NO EXISTE ESE NUMERO DE GUIA!!!! HAZ BIEN!!!!</p>
                                        <?php endif ?>

                                        <form action="actualizacion_campo.php" method="POST" class="user" >

                                            <div class="form-group">
                                                <input type="text" name="orden" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Ingresar la orden...">
                                            </div>
                                            <input type="submit" value="REPORTA" class="btn btn-primary btn-user btn-block">
                                        </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

</html>