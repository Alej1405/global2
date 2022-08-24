<?php

//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: index.php');
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

$inicio_datos = $_SESSION['cedula'];

$consulta = "SELECT * FROM clientes WHERE cedula = '$inicio_datos'";
$resultado = mysqli_query($db4, $consulta);
$usuario = mysqli_fetch_assoc($resultado);

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

<body>
    <br>
    <div class="container vw-95">
        <div class="card text-center">
            <div class="card-header">

                Hola <strong><?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></strong>
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h5>
                        Bienvenido a <img src="../../IMG/gc-go.png" class="img-fluid pt-1 m-auto" alt="Logo GC-GO" style="width: 2.8rem;">
                    </h5>
                </div>
                <p class="card-text">
                    Para mayor comodidad ponemos a tu disposicion nuestra plataforma de consultas,
                    aqui puedes encontrar el estado de tus paques y de tu cuenta, consulta general de envios.
                    <br>
                    <span>
                        Por favor, selecciona una opcion de consulta.
                    </span>

                </p>
                <div class="card" role="group" aria-label="Basic example">   
                    <a href="#" class="btn btn-primary m-1">Ver Estado de Cuenta</a>
                    <a href="#" class="btn btn-primary m-1">Traking actual</a>
                    <a href="#" class="btn btn-primary m-1">Estado general de envios</a>
                </div>
            </div>
            <div class="card">
                <h6>PEDIDOS EN PROCESO</h6>
                <table>
                    <thead>
                        <tr>
                            <th>
                                <strong>
                                    Nombre del cliente.
                                </strong>
                            </th>
                            <th>
                                <strong>
                                    Numero de Guia.
                                </strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $envios = "SELECT * FROM ordenes WHERE cliente = '$inicio_datos' AND estado = 'recolectar' AND estado = 'ingresado';";
                            $resultado_envios = mysqli_query($db4, $envios);
                            while($envio = mysqli_fetch_assoc($resultado_envios)):?>
                        <tr>
                            <td>
                                <?php echo $envio['id']; ?>
                            </td>
                            <td>
                                <?php echo $envio['guia']; ?>
                            </td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
            </div>
            <div class="card">
                <h6>PEDIDOS ENTREGADOS</h6>
                <table>
                    <thead>
                        <tr>
                            <th>
                                <strong>
                                    Nombre del cliente.
                                </strong>
                            </th>
                            <th>
                                <strong>
                                    Numero de Guia.
                                </strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $datos = date('y-m');
                            $diamenos = date('y-m');
                            $envios = "SELECT * FROM ordenes WHERE cliente = '$inicio_datos' AND estado = 'delivered';";
                            $resultado_envios = mysqli_query($db4, $envios);
                            while($envio = mysqli_fetch_assoc($resultado_envios)):?>
                        <tr>
                            <td>
                                <?php echo $envio['nombre']; ?>
                            </td>
                            <td>
                                <?php echo $envio['guia']; ?>
                            </td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">
                Cliente desde <?php echo $usuario['fecha_registro']; ?>
            </div>
        </div>
    </div>
    <br>
    <?php
    incluirTemplate('fottersis2');
    ?>