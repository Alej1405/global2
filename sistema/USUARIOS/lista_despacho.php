<?php
//incluye el header
require '../../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

require '../../includes/config/database.php';
incluirTemplate('headersis2');
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

//caracterizacion de la pagina. Cambia los estados a UNDELIVERED con el comentario EN CENTRO LOGISTICO 
//registra las ordenes con el distrito y subdistrito para la creacion de manifiestos automaticos de control.

//consulta de ordenes en estado COLLECTED
$consulta_collected = "SELECT * FROM orders WHERE status = 'COLLECTED' AND id NOT IN (SELECT id_order FROM despacho)";

?>

<body>
    <div class="container primary">
        <div class="heading">
            <h1>Crear Distritos</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    incluirTemplate('fottersis');
    ?>