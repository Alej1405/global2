<?php

$id = $_GET['id'] ?? null;
//incluye el header
require '../../includes/funciones.php';
require '../../includes/config/database.php';

//PROTEGER PAGINA WEB
$auth = estaAutenticado();

if (!$auth) {
    header('location: ../index.php');
}

incluirTemplate('headersis2');

//BASE DE DATOS ADMINISTRADOR
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

//----------------------variables del sistema----------------------
$detalles_factura1 = "SELECT * FROM liquidacion_gc WHERE cliente = '$id';";
$ejecutar_consulta1 = mysqli_query($db6, $detalles_factura1);
$fila2 = mysqli_fetch_array($ejecutar_consulta1);

$detalles_factura = "SELECT count(valor_pagar), sum(valor_pagar), tarifa FROM liquidacion_gc WHERE cliente = '$id' and estado = 'liquidado' GROUP BY tarifa;";
$ejecutar_consulta = mysqli_query($db6, $detalles_factura);


?>
<div class="container">
    <h1>REGISTRAR NUMERO DE FACTURA</h1>
    <div class="card">
    <div class="card-header">
        Cliente <strong><?php $nombre = $fila2['cliente'];
                            $buscar_nombre = "SELECT * FROM clientes WHERE cedula = '$nombre';";
                            $ejecutar_nombre = mysqli_query($db4, $buscar_nombre);
                            $nombre_p = mysqli_fetch_assoc($ejecutar_nombre);
                            echo $nombre_p['nombre']." ".$nombre_p['apellido']." / ".$nombre_p['emprendimiento']." / ".$nombre_p['cedula']; ?></strong>
    </div>
    <div class="card-body">
        <h5 class="card-title">Liquidacion de ENVIOS</h5>
        <p class="card-text">
        <table class="table table-hover">
                <thead>
                    <tr>
                        <th>TIPO DE ENVIOS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_array($ejecutar_consulta)):?>
                    <tr>
                        <td>
                            <?php echo $fila['tarifa']." ".$fila['count(valor_pagar)'];?> 
                            VALOR A COBRAR POR ENVIO. <?php echo "$"." ".round($fila['sum(valor_pagar)'],2); ?>
                        </td>
                     </tr>
                     <?php endwhile; ?>
                </tbody> 
            </table>
        </p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    </div>
</div>
<?php
    incluirTemplate('fottersis2');
?>