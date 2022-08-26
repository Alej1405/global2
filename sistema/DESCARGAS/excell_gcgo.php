<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=informediario.xls");
 
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

    //coneccion callcenter
    conectarDB5();
    $db5 =conectarDB5();

    //coneccion callcenter
    conectarDB6();
    $db6 =conectarDB6();

    $auth = estaAutenticado();

    // proteger la página
    if (!$auth) {
        header('location: index.php');
    }
    //-------- inicio del consultas de informacion de cargas GC_GO ----------
    $consulta_ordenes = "SELECT * FROM ordenes order by fecha_reg DESC";
    $ejecutar_consulta_ordenes = mysqli_query($db4, $consulta_ordenes);

?>
<h1>Reporte General GC-Go</h1>
<table class="form2 consulta__tabla" >
        <thead>
            <tr>
                <th>CLIENTE</th>
                <th>ASESOR</th>
                <th>PUNTO DE ORIGEN</th>
                <th>NUEMRO DE GUIA</th>
                <th>NUMERO DE FACTURA</th>
                <th>DESTINATARIO</th>
                <th>VALOR DEL ENVIO</th>
                <th>TARIFA APLICADA</th>
                <th>DESTINO</th>
                <th>PROVINCIA</th>
                <th>CIUDAD</th>
                <th>MEDIDAS</th>
                <th>ESTADO</th>
                <th>FECH DE SOLITUD</th>
                <th>TRANSPORTISTA</th
            </tr>
        </thead>
        <tbody>
            <?php while($datos_ordenes = mysqli_fetch_assoc($ejecutar_consulta_ordenes)): ?>
                <tr>
                    <td>
                        <?php 
                            $consulta_cliente =$datos_ordenes['cliente'];
                            //consulta de datos del cliente en la tabla de clientes
                            $ejecutar_consulta_cliente = mysqli_query($db4, "SELECT * FROM clientes WHERE cedula = '${consulta_cliente}';");
                            $datos_cliente = mysqli_fetch_assoc($ejecutar_consulta_cliente);
                            echo $datos_cliente['nombre'] . " " . $datos_cliente['apellido'];
                            $asesor = $datos_cliente['vendedor'];
                        ?>
                    </td>
                    <td><?php echo $datos_ordenes['asesor'] ?></td>
                    <td><?php echo $datos_ordenes['direccion_recoleccion']?></td>
                    <td><?php echo $datos_ordenes['guia']; ?></td>
                    <td>
                        <?php 
                            //consulta de datos de la factura en la tabla de financiero
                            $consulta_factura = $datos_ordenes['guia'];
                            $ejecutar_consulta_factura = mysqli_query($db6, "SELECT * FROM liquidacion_gc WHERE guia = '${consulta_factura}';");
                            $datos_factura = mysqli_fetch_assoc($ejecutar_consulta_factura);
                            //$factura = $datos_factura['n_factura'];
                                //condicion de impresion de la factura
                                if(!$datos_factura){
                                    echo "No hay factura";
                                }else{
                                    echo $datos_factura['n_factura'];
                                }
                        ?>
                    </td>
                    <td><?php echo $datos_ordenes['nombre']; ?></td>
                    <td>
                                    <?php
                                    $consultar_tarifa = $datos_ordenes['tarifa'];
                                    //consultar el valor de tarifa a aplicar
                                    $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                    $eje_consT = mysqli_query($db4, $cons_tarifa);
                                    $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                    $tarifa = $valor_tarif['valor'];
                                    $tarifa_extra = $valor_tarif['valor_extra'];
                                    $peso_base = $valor_tarif['peso'];
                                    $consultar_tarifa = $datos_ordenes['tarifa'];
                                    //consultar el valor de tarifa a aplicar
                                    // $cons_tarifa = "SELECT * FROM tarifas WHERE nombre = '${consultar_tarifa}';";
                                    // $eje_consT = mysqli_query($db4, $cons_tarifa);
                                    // $valor_tarif = mysqli_fetch_assoc($eje_consT);
                                    // $tarifa = $valor_tarif['valor'];
                                    // $tarifa_extra = $valor_tarif['valor_extra'];
                                    // $peso_base = $valor_tarif['peso'];
                                    //calculo del peso real comparacion con el pesovolumetrico
                                    $largo = $datos_ordenes['l'];
                                    $ancho = $datos_ordenes['a'];
                                    $alto = $datos_ordenes['h'];
                                    $P = $datos_ordenes['peso'];
                                    //calculo peso volumentrico
                                        $peso_vol1 = round(($largo * $ancho * $alto) / 5000, 2);
                                         
                                    if ($peso_vol1 > $P) {
                                        //calculo con el peso volumetrico
                                            $peso_aplicar = $peso_vol1 - $peso_base;
                                            if ($peso_aplicar >= $peso_base) {
                                                $valor_extra = $peso_aplicar * $tarifa_extra;
                                                //valor que captura para la facturacion variable sin IVA
                                                    $valor_pagar = $valor_extra + $tarifa;
                                                    //calculo del IVA para asesores
                                                        $iva = $valor_pagar * 0.12;
                                                        $valor_pagar2 = $valor_pagar + $iva;
                                                        echo "$ ".round($valor_pagar2, 2);
                                            }else {
                                                // valor que se captura para la facturacion
                                                $valor_pagar = $tarifa;
                                                // calculo del iva    
                                                    $iva = $valor_pagar * 0.12;
                                                    $valor_pagar2 = $valor_pagar + $iva;
                                                    echo "$ " . round($valor_pagar2, 2);
                                            }
                                    } else {
                                        $peso_aplicar = $P - $peso_base;
                                        if ($peso_aplicar > $peso_base) {
                                            $valor_extra = $peso_aplicar * $tarifa_extra; 
                                            //valor que captura para la facturacion
                                                $valor_pagar = $valor_extra + $tarifa;
                                            //calculo del iva 
                                                $iva = $valor_pagar * 0.12;
                                                $valor_pagar2 = $valor_pagar + $iva;
                                                echo "$  " . round($valor_pagar2, 2);
                                        } else {
                                            // valor que se captura para la facturacion
                                            $valor_pagar = $tarifa;
                                            // calculo del iva    
                                                $iva = $valor_pagar * 0.12;
                                                $valor_pagar2 = $valor_pagar + $iva;
                                                echo "$ " . round($valor_pagar2, 2);
                                        };
                                    }
                                    ?>
                    </td>
                    <td><?php echo $datos_ordenes['tarifa']; ?></td>
                    <td><?php echo $datos_ordenes['direccion'];?></td>
                    <td><?php echo $datos_ordenes['provincia'];?></td>
                    <td><?php echo $datos_ordenes['ciudad']; ?></td>
                    <td><?php echo $datos_ordenes['l'] . " x " .$datos_ordenes['a']." x ".$datos_ordenes['h']; ?></td>
                    <td><?php echo $datos_ordenes['estado']; ?></td>
                    <td><?php echo $datos_ordenes['fecha_reg']; ?></td>
                    <td>
                        <?php 
                            $consulta = $datos_ordenes['transporte']; 
                            //consulta para el nombre del motorizado
                            $consulta_transporte = "SELECT * FROM colaborador WHERE id = '${consulta}';";
                            $ejecutar_consulta_transporte = mysqli_query($db4, $consulta_transporte);
                            $datos_colaborador = mysqli_fetch_assoc($ejecutar_consulta_transporte);
                            echo $datos_colaborador['nombre']." ".$datos_colaborador['apellido'];
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>