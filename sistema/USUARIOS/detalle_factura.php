<?php

use Masterminds\HTML5\Parser\StringInputStream;
use Svg\Gradient\Stop;

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
                        <th>NUMERO DE ENVIOS POR TARIFA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_array($ejecutar_consulta)):?>
                    <tr>
                        <td>
                            <strong>
                            <?php echo $fila['tarifa']?> 
                            </strong>
                            <br>
                            Numero envios: <strong><?php echo $fila['count(valor_pagar)']?></strong> 
                        </td>
                        <td>
                            

                        </td>
                     </tr>
                     <?php endwhile; ?>
                </tbody> 
            </table>
            <div class="card">
                <div class="card-header">
                    <strong>
                        VALOR POR COD
                    </strong>
                </div>
                <div class="card-body">
                    <?php 
                                    
                        $detalles_factura210 = "SELECT count(cod), sum(cod_cobrar) from liquidacion_gc WHERE cliente = '$id' and cod = 'si';";
                        $ejecutar_consulta210 = mysqli_query($db6, $detalles_factura210);
                        while($fila210 = mysqli_fetch_array($ejecutar_consulta210)):
                        ?>
                            Numero envios con COD: <strong><?php echo $fila210['count(cod)']?></strong>
                            <br>
                            Valor total del servicio COD: <strong> $ <?php echo round($fila210['sum(cod_cobrar)'],2);?></strong> 
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <strong>
                        PESO EXTRA
                    </strong>
                </div>
                <div class="card-body">
                    <?php
                        //buscar tarifa
                        $detalles_factura112 = "SELECT * FROM liquidacion_gc WHERE cliente = '$id' and estado = 'liquidado';";
                        $ejecutar_consulta112 = mysqli_query($db6, $detalles_factura112);
                        $fila112 = mysqli_fetch_array($ejecutar_consulta112);
                        // 
                            $detalles_factura11 = "SELECT count(t_kgextra), sum(peso_extra), t_kgextra FROM liquidacion_gc WHERE cliente = '$id' and estado = 'liquidado' GROUP BY t_kgextra;";
                            $ejecutar_consulta11 = mysqli_query($db6, $detalles_factura11);
                            $fila11 = mysqli_fetch_array($ejecutar_consulta11);
                            $extra_P = $fila11['sum(peso_extra)'];
                            $N_tarifa = $fila112['tarifa'];
                            $tarifa_ext = $fila11['t_kgextra'];
                            if ($extra_P > 0 ){
                                //echo $id;
                                $sonsulta_tarifaExt = "SELECT * FROM tarifas WHERE nombre = '$N_tarifa';";
                                $ejecutar_consulta_tarifaExt = mysqli_query($db4, $sonsulta_tarifaExt);
                                $fila_tarifaExt = mysqli_fetch_array($ejecutar_consulta_tarifaExt);
                                $valor_extra = $fila_tarifaExt['valor_extra'];
                                $valor_extra_corbrar = $extra_P * $valor_extra;
                                echo "Tipo de Tarifa: <strong>".$tarifa_ext."</strong><br>";
                                echo "Extras: <strong>".$extra_P." Kg"."</strong><br>";
                                echo "Valor a cobrar: $ ".round($valor_extra_corbrar, 2);
                            }else{
                                echo "no applica";
                            }
                    ?>
                </div>
            </div>          
        </p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    </div>
</div>
<br>
<br>
<?php
    incluirTemplate('fottersis2');
?>