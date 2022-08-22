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

$errores = [];
$factura = null;
//----------------------variables del sistema----------------------
$detalles_factura1 = "SELECT * FROM liquidacion_gc WHERE cliente = '$id';";
$ejecutar_consulta1 = mysqli_query($db6, $detalles_factura1);
$fila2 = mysqli_fetch_array($ejecutar_consulta1);
$N_tarifa = $fila2['tarifa'];

$detalles_factura = "SELECT count(valor_pagar), sum(valor_pagar), tarifa FROM liquidacion_gc WHERE cliente = '$id' and estado = 'liquidado' GROUP BY tarifa;";
$ejecutar_consulta = mysqli_query($db6, $detalles_factura);

//----------------captura de datos desde el formulario----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $factura = $_POST['factura'];
    if(!$factura) {
        $errores[] = "EMPEZO!!!!! PONGA LA FECHA SI NO, COMO!!!!";
    }
    if(empty($errores)) {
        // actualizacion en la base de datos financiero
        $consulta_fin = "UPDATE liquidacion_gc SET n_factura = '$factura', estado = 'facturado'  WHERE cliente = '$id' and estado = 'liquidado';";
        $ejecutar_consulta33 = mysqli_query($db6, $consulta_fin);

        //actualizacion en la base de datos ordenes
        $consulta_fin2 = "UPDATE ordenes SET estado = 'facturado' WHERE cliente = '$id' and estado = 'liquidado';";
        $ejecutar_consulta3 = mysqli_query($db4, $consulta_fin2);

        if($ejecutar_consulta3){
                
            echo "<script>
            guardar();
                window.location.href='facturacion_gc.php?id=$filtro_asesor';
            </script>";
        }
    }
    //    UPDATE ordenes SET estado = 'facturado' WHERE estado = 'liquidado' and cliente = '1705394243001';

}

?>
<div class="container">
    <h1>REGISTRAR NUMERO DE FACTURA</h1>
    <div class="card">
        <div class="card-header">
            Cliente <strong><?php $nombre = $fila2['cliente'];
                            $buscar_nombre = "SELECT * FROM clientes WHERE cedula = '$nombre';";
                            $ejecutar_nombre = mysqli_query($db4, $buscar_nombre);
                            $nombre_p = mysqli_fetch_assoc($ejecutar_nombre);
                            echo $nombre_p['nombre'] . " " . $nombre_p['apellido'] . " / " . $nombre_p['emprendimiento'] . " / " . $nombre_p['cedula']; ?></strong>
        </div>
        <div class="card-body">
            <h5 class="card-title">FACTURACION MENSUAL DE SERVICIOS</h5>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne22">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne22" aria-expanded="true" aria-controls="collapseOne">
                            <strong>
                                DETALLE DEL SERVICIO
                            </strong>
                        </button>
                    </h2>
                    <div id="collapseOne22" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NUMERO DE ENVIOS POR TARIFA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = mysqli_fetch_array($ejecutar_consulta)) : ?>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <?php echo $fila['tarifa'] ?>
                                                </strong>
                                                <br>
                                                Numero envios: <strong><?php echo $fila['count(valor_pagar)'] ?></strong>
                                            </td>
                                            <td>


                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo22" aria-expanded="false" aria-controls="collapseTwo">
                            <strong>
                                VALOR POR COD
                            </strong>
                        </button>
                    </h2>
                    <div id="collapseTwo22" class="accordion-collapse collapse" aria-labelledby="headingTwo22" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php

                            $detalles_factura210 = "SELECT count(cod), sum(cod_cobrar) from liquidacion_gc WHERE cliente = '$id' and cod = 'si' and not estado = 'facturado';";
                            $ejecutar_consulta210 = mysqli_query($db6, $detalles_factura210);
                            while ($fila210 = mysqli_fetch_array($ejecutar_consulta210)) :
                            ?>
                                Numero envios con COD: <strong><?php echo $fila210['count(cod)'] ?></strong>
                                <br>
                                Valor Servicio COD: <strong> $ <?php echo round($fila210['sum(cod_cobrar)'], 2); ?></strong>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree22">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree22" aria-expanded="false" aria-controls="collapseThree">
                            <strong>
                                PESO EXTRA
                            </strong>
                        </button>
                    </h2>
                    <div id="collapseThree22" class="accordion-collapse collapse" aria-labelledby="headingThree22" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php
                            $detalles_factura112 = "SELECT count(id), sum(peso_extra), t_kgextra FROM liquidacion_gc WHERE cliente = '$id' and estado = 'liquidado' GROUP BY t_kgextra;";
                            $ejecutar_consulta112 = mysqli_query($db6, $detalles_factura112);

                            while ($fila112 = mysqli_fetch_array($ejecutar_consulta112)) :
                                $nombre = $fila112['t_kgextra'];
                                //buscar tarifa 
                                $detalles_factura1 = "SELECT * FROM liquidacion_gc WHERE t_kgextra = '$nombre';";
                                $ejecutar_consulta1 = mysqli_query($db6, $detalles_factura1);
                                $fila2 = mysqli_fetch_array($ejecutar_consulta1);
                                $N_tarifa = $fila2['tarifa'];
                                $valid = $fila112['sum(peso_extra)'];
                                if ($valid > 0) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong>
                                                <?php echo $fila112['t_kgextra']; ?> valor a cobrar:
                                            </strong>
                                            <strong>
                                                <?php
                                                $sonsulta_tarifaExt = "SELECT * FROM tarifas WHERE nombre = '$N_tarifa';";
                                                $ejecutar_consulta_tarifaExt = mysqli_query($db4, $sonsulta_tarifaExt);
                                                $fila_tarifaExt = mysqli_fetch_array($ejecutar_consulta_tarifaExt);
                                                $valor_extra = $fila_tarifaExt['valor_extra'];
                                                $valor_cobrar = $valor_extra * $fila112['sum(peso_extra)'];
                                                echo "$ " . round($valor_cobrar, 2);
                                                ?>
                                            </strong>
                                            <br>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <h6>
                <strong> REGISTRAR NUMERO DE FACTURA </strong>
            </h6>
            <br>
            <form method="POST">
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control" name="factura" placeholder="NUMERO DE FACTURA" aria-label="Username" aria-describedby="addon-wrapping">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">AGREGAR FACTURA</button>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<br>
<?php
incluirTemplate('fottersis2');
?>