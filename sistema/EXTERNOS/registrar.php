<?php
//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

require '../../includes/config/database.php';
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

//variable de errores
$errores = [];

//variables del sistema
$guia = '';
$fecha = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //variables desde el formulario
    $guia = mysqli_real_escape_string($db4, $_POST['guia']);
    date_default_timezone_set("America/Bogota");
    date_default_timezone_get();
    $fecha = date('Y-m-d G:i:s');
    $transporte = $_SESSION['id'];
    $n_usuario = $_SESSION['usuario'];
    $t_trasport = 'Motorcycle';

    //validacion de campos
    if (!$guia) {
        $errores[] = "Con que paquete te relaciono si no pones guiaaaaaaaa!!! ";
    }
    if (empty($errores)) {
    //VALIDAR DE QUE CLIENTE ES LA GUIA
        //VALIDAR SI LA GUIA EXISTE
        $consultas = "SELECT * FROM ordenes WHERE guia = '${guia}';";
        $resultados = mysqli_query($db4, $consultas);
        $resultado_existe = mysqli_fetch_assoc($resultados);
        if ($resultado_existe) {
            //capturar documentos
            //actualizar datos en la base de datos
            $query = "UPDATE ordenes SET    transporte = '${transporte}',
                                            fecha_actualizacion = '${fecha}'
                                            WHERE guia = '${guia}';";
            $resultado = mysqli_query($db4, $query);
            if ($resultado) {
                echo "<script>
                        alert('Genial!! tienes una guia, hay que entregar rapido pilas');
                        window.location.href='registrar.php';
                    </script>";
            } else {
                echo "
                            <div class='alert alert-danger' role='alert'>
                                <strong>Error!</strong> 
                                No te asignaste nada, registra bien!!!!
                            </div>";
                exit;
            }
        } else {
            //MODIFICACION CON LA BASE DE DATOS CORRECTA. ACTUALIZACION DE DATOS RUSIA
            //consultar el order id
            $order_id = "SELECT * FROM orders WHERE order_id = '${guia}';";
            $resultado_order_id = mysqli_query($db3, $order_id);
            $resultado_order_id = mysqli_fetch_assoc($resultado_order_id);
            if ($resultado_order_id) {
                    $id_primary = $resultado_order_id['id'];
                    $created_at = $resultado_order_id['created_at'];

                    //actualizar el estado a UNDELIVERED TABLA ORDERS
                    $query = "UPDATE orders SET    status = 'undelivered',
                                                    updated_at = '${fecha}'
                                                    WHERE order_id = '${guia}';";
                    $resultado = mysqli_query($db3, $query);

                    //actualizar el estado a UNDELIVERED TABLA DISPATCHES
                    $observation = 'En ruta, para entrega';
                    $query = "UPDATE dispatches SET    status = 'undelivered',
                                                        updated_at = '${fecha}',
                                                        carrier_name = '${n_usuario}',
                                                        transport_type = '${t_trasport}'
                                                        WHERE order_id = '${id_primary}';";
                    $resultado = mysqli_query($db3, $query);

                    //generar historial de entregas 
                        //consultar el id del usuario
                        $id_usuario = "SELECT * FROM dispatches WHERE order_id = '${id_primary}';";
                        $resultado_id_usuario = mysqli_query($db3, $id_usuario);
                        $resultado_id_usuario = mysqli_fetch_assoc($resultado_id_usuario);
                        $id_dispatches = $resultado_id_usuario['id'];

                        //generar el historial
                        $historial = "INSERT INTO dispatch_statuses (status, comment, dispatch_id, user_id, created_at, updated_at, deleted_at)
                                            VALUES ('undelivered', '${observation}', '${id_dispatches}', '${transporte}', '${created_at}', '${fecha}', null);";
                        $eje_historial = mysqli_query($db3, $historial);
                        if ($eje_historial) {
                            echo "<script>
                                    alert('Genial!! tienes una guia, hay que entregar rapido pilas');
                                    window.location.href='registrar.php';
                                </script>";
                        } else {
                            echo "
                                        <div class='alert alert-danger' role='alert'>
                                            <strong>Error!</strong> 
                                            No te asignaste nada, registra bien!!!!
                                        </div>";
                            exit;
                        }
                    } else {
                        echo "
                                    <div class='alert alert-danger' role='alert'>
                                        <strong>Error!</strong> 
                                        Escribe bien esa guia no existe, siga participando!!!!
                                    </div>";
                    }
        }
    }
}
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>
    <div class="container primary">
        <br>
        <div>
            <img src="/IMG/gc-go.png" alt="" class="rounded mx-auto d-block" style="width: 6rem;">
        </div>
        <br>
        <form action="" method="post">
            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endforeach ?>
            <div class="input-group input-group-sm mb-3">
                <input type="text" class="form-control" name="guia" placeholder="Ingresa el nuermo de guia " aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Registrar</button>
        </form>
        <br>
        <div>
            <p>
                Si ya no tienes mas guias para registrar por favor dale click aqui.
            </p>
            <strong><a href="motorizados.php" class="btn btn-danger btn-sm">TERMINAR</a></strong>
        </div>
    </div>