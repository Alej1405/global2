<?php

//incluye el header

require '../../includes/config/database.php';
require '../../includes/funciones.php';
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

//coneccion callcenter
conectarDB5();
$db5 = conectarDB5();

//coneccion callcenter
conectarDB6();
$db6 = conectarDB6();

//consulta de ordenes nuevas ordenes en request

$query = "SELECT count(id) as provincia FROM orders WHERE status = 'requested';";
$resultado = mysqli_query($db3, $query);


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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css2/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body class="bg-gradient-light">
    <div class="container">
        <main class="titulos mt-4">
            <h6 class="f-s7 text-primary">
                Consulta Genreal.
            </h6>
        </main>
 
        <br>
        <section>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Ordenes Cosmetics.
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table tabla_scroll">
                                    <thead>
                                        <tr>
                                            <th class="fs-6">Nuevas</th>
                                            <th class="fs-6">Empacadas</th>
                                            <th class="fs-6">Proceso</th>
                                            <th class="fs-6">Entregadas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($orders = (mysqli_fetch_assoc($resultado))) : ?>
                                            <tr>
                                                <td><?php echo $orders['provincia'] ?></td>
                                                <td>
                                                    <?php
                                                    $query12 = "SELECT count(id) as entregadas FROM orders WHERE status = 'collected';";
                                                    $resultado12 = mysqli_query($db3, $query12);
                                                    $orders12 = (mysqli_fetch_assoc($resultado12));
                                                    echo $orders12['entregadas'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $query122 = "SELECT count(id) as proceso FROM orders WHERE status = 'undelivered';";
                                                    $resultado122 = mysqli_query($db3, $query122);
                                                    $orders122 = (mysqli_fetch_assoc($resultado122));
                                                    echo $orders122['proceso'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $query121 = "SELECT count(id) as delivered FROM orders WHERE status = 'delivered';";
                                                    $resultado121 = mysqli_query($db3, $query121);
                                                    $orders1221 = (mysqli_fetch_assoc($resultado121));
                                                    echo $orders1221['delivered'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Ordenes por Provincia.
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table tabla_scroll">
                                    <thead>
                                        <tr>
                                            <th class="fs-6">QT</th>
                                            <th class="fs-6">Provincia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //seleccionar las ordenes en collected y undelivered
                                        $query_ordenes = "SELECT count(id) as cantidad, province FROM order_clients GROUP BY province ;";
                                        $resultado_ordenes = mysqli_query($db3, $query_ordenes);
                                        while ($orders = (mysqli_fetch_assoc($resultado_ordenes))) :
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    //seleccionar las ordenes en collected y undelivered
                                                    echo $orders['province'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    //seleccionar las ordenes en collected y undelivered
                                                    echo $orders['cantidad'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Ordenes GC-GO Nuevas
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table tabla_scroll">
                                    <thead>
                                        <tr>
                                            <th class="fs-6">Cliente</th>
                                            <th class="fs-6">QT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                $query1 = "SELECT count(id) as cantidad, cliente FROM ordenes WHERE estado = 'recolectar' GROUP BY cliente;";
                                                $resultado1 = mysqli_query($db4, $query1);
                                                $orders1 = (mysqli_fetch_assoc($resultado1));
                                                $consulta = $orders1['cliente'];
                                                $cantidad = $orders1['cantidad'];
                                                //consultar nombre del cliente
                                                $query2 = "SELECT * FROM clientes WHERE cedula = '$consulta';";
                                                $resultado2 = mysqli_query($db4, $query2);
                                                $orders2 = (mysqli_fetch_assoc($resultado2));
                                                echo $orders2['nombre'] . " " . $orders2['apellido'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $cantidad;
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>