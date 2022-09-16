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
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Hola!!! buen dia..</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Bienvenido a Grupo Revilla</h6>
                <p class="card-text"><?php echo $_SESSION['usuario'] ?> Como vas iniciar el dia</p>
                <a href="registrar.php" class="btn btn-primary">Registrar Guias</a>
                <br>
                <br>
                <a href="#" class="btn btn-success">Entregas Pendientes</a>
            </div>
        </div>
        <br>
        <?php
        $buscar = $_SESSION['id'];
        // consulta de gestion de entregas
            $query = "SELECT count(id) as entregadas FROM ordenes WHERE transporte = '${buscar}' and estado = 'delivered';";
            $resultado = mysqli_query($db4, $query);
            $ordenes = mysqli_fetch_assoc($resultado);
            $delivered = $ordenes['entregadas'];

            $query2 = "SELECT count(id) as facturados FROM ordenes WHERE transporte = '${buscar}' and estado = 'facturado';";
            $resultado2 = mysqli_query($db4, $query2);
            $ordenes2 = mysqli_fetch_assoc($resultado2);
            $facturado = $ordenes2['facturados'];

            $query3 = "SELECT count(id) as liquidado FROM ordenes WHERE transporte = '${buscar}' and estado = 'liquidado';";
            $resultado3 = mysqli_query($db4, $query3);
            $ordenes3 = mysqli_fetch_assoc($resultado3);
            $liquidado = $ordenes3['liquidado'];

            $entregas = $delivered + $facturado + $liquidado;

        //consulta de paquetes en proceso
            $query0 = "SELECT count(id) as procesos FROM ordenes WHERE transporte = '${buscar}' and estado = 'ingreso';";
            $resultado0 = mysqli_query($db4, $query0);
            $ordenes0 = mysqli_fetch_assoc($resultado0);
            $proceso1 = $ordenes0['procesos'];

            $query9 = "SELECT count(id) as noentregados FROM ordenes WHERE transporte = '${buscar}' and estado = 'undelivered';";
            $resultado9 = mysqli_query($db4, $query9);
            $ordenes9 = mysqli_fetch_assoc($resultado9);
            $proceso2 = $ordenes9['noentregados'];

            $proceso = $proceso1 + $proceso2;


        
        //consulta de paqutes asignados
            $query4 = "SELECT count(id) as asignados FROM ordenes WHERE transporte = '${buscar}' and estado = 'recolectar';";
            $resultado4 = mysqli_query($db4, $query4);
            $ordenes4 = mysqli_fetch_assoc($resultado4);
            $asignados = $ordenes4['asignados'];    
        

        ?>
        <div>
            <p>
                Bien!!!! te presentamos un resumen de gestion. Suerte el dia de hoy!!
            </p>
            <samp>
                <?php 
                    $buscar = $_SESSION['id'];
                    // consulta de gestion de entregas
                        $query8 = "SELECT count(id) as total FROM ordenes WHERE transporte = '${buscar}';";
                        $resultado8 = mysqli_query($db4, $query8);
                        $ordenes8 = mysqli_fetch_assoc($resultado8);
                        $delivered = $ordenes8['total'];
                ?>
                <strong>
                    <h7>Guias asignadas</h7>  <?php echo $delivered;?>
                </strong>
            </samp>
        </div>
        <table class="table table-hover">
            <thead>
                <tr class="table-primary">
                    <th>Entregas</th>
                    <th>Pendientes</th>
                    <th>Asignados</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td><?php echo $entregas; ?></td>
                        <td><?php echo $proceso; ?></td>
                        <td><?php echo $asignados; ?></td>
                    </tr>
            </tbody>
        </table>
    </div>
    <br>
    <?php
    incluirTemplate('fottersis');
    ?>